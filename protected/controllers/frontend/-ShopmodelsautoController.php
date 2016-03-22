<?php

class ShopModelsAutoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','descendants'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ShopModelsAuto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopModelsAuto']))
		{
			$model->attributes=$_POST['ShopModelsAuto'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopModelsAuto']))
		{
			$model->attributes=$_POST['ShopModelsAuto'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ShopModelsAuto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ShopModelsAuto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopModelsAuto']))
			$model->attributes=$_GET['ShopModelsAuto'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopModelsAuto the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShopModelsAuto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopModelsAuto $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-models-auto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionDescendants()
	{
		$app = Yii::app();
		$model_id = $app->request->getParam('model_id', 0);
		$level = $app->request->getParam('level', 0);
		
		$model = $this->loadModel($model_id);
		
		
		if($level > 1)	{
			$descendants = $model->descendants()->findAll();
			foreach($descendants as $c){
				$separator = '';
				for ($x=3; $x++ < $c->level;) $separator .= '- ';
				$c->name = ' '.$separator.$c->name;
			}			
		}	else	{
			$descendants = $model->children()->findAll();
		}
		
		
		$dropdownData = CHtml::listData($descendants, 'id','name');
		$selected = null;
		
		switch($level) {
			case 1:
				$empty = 'Выберите модель';
				$name = 'select-model';
				unset($app->session['autofilter.year']);
				unset($app->session['autofilter.model']);
				break;
			case 2:
				$empty = 'Выберите год';
				$name = 'select-year';
				unset($app->session['autofilter.year']);
				break;
			default:
				$empty = '';
				break;
		}
		
		
		
		echo CHtml::dropDownList($name, $selected, $dropdownData, array('empty' => $empty, 'class'=>'search-auto-form__border_white'));
		
		Yii::app()->end();
	}
	
}
