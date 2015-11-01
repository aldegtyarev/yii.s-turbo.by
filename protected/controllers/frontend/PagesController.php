<?php

class PagesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2l';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
		//подключаем класс для замены 
		//больших изображений на миниютюры со ссылками
		$aadThumbnails = new AadThumbnails();	
		
		$model = $this->loadModel($id);
		//var_dump($model);

		//$mvThumbnails = new aadThumbnails();
		$aadThumbnails->onPrepareContent($model);
		//mvThumbnails::onPrepareContent($model);
		$regex = '#<img\s.*?>#';
		//$model->text = preg_replace_callback($regex, array($this, "imageReplacer"), $model->text);
		
		$this->render('view',array(
			'model'=>$model,
		));
	}


	/**
	 * Доставка
	 */
	public function actionDelivery()
	{
		$id = 3;
		$this->renderPage($id);
	}

	/**
	 * Доставка
	 */
	public function actionPayment()
	{
		$id = 4;
		$this->renderPage($id);
	}

	/**
	 * гарантия
	 */
	public function actionGuarantee()
	{
		$id = 5;
		$this->renderPage($id);
	}

	/**
	 * Города доставки по Беларуси:
	 */
	public function actionTownslist()
	{
		$id = 7;
		$this->renderPage($id);
	}
	
	public function renderPage($id)
	{
		$model = $this->loadModel($id);
		
		$app = Yii::app();		
		$modal = (int) $app->request->getParam('modal', '0');
		$current_action = $app->getController()->getAction()->getId();
		$current_controller =  $app->getController()->getId();
		
		if($modal == 0) {
			$this->render('view',array(
				'model'=>$model,
				'current_action'=>$current_action,
				'current_controller'=>$current_controller,
			));			
		}	else	{
			$this->renderPartial('view-modal',array(
				'model'=>$model,
				'current_action'=>$current_action,
				'current_controller'=>$current_controller,
			));
		}
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pages the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pages $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
