<?php

class DeliveryController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('superman'),
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
		$model=new DeliveryForm;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		
		
		if(isset($_POST['DeliveryForm']))
		{
			$model->attributes=$_POST['DeliveryForm'];
			
			$model->units_qty12 = $_POST['DeliveryForm']['units_qty12'];
			$model->units_qty3 = $_POST['DeliveryForm']['units_qty3'];
			$model->units_qty12_q = $_POST['DeliveryForm']['units_qty12_q'];
			$model->units_qty3_q = $_POST['DeliveryForm']['units_qty3_q'];
			
			$options = $_POST['DeliveryForm'];
			unset($options['name']);
			unset($options['options']);
			
			$model->options = json_encode($options);
			
			if($model->validate()) {
				
				$model_delivery = new Delivery;
				$model_delivery->name = $model->name;
				$model_delivery->ico = $model->ico;
				$model_delivery->options = $model->options;
				$model_delivery->save();
				
				if(isset($_POST['save']))	{
					$this->redirect(array('admin'));
				}	else	{
					$this->redirect(array('update','id'=>$model->id));
				}
			}
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
		$model_delivery=$this->loadModel($id);
		$model = new DeliveryForm;
		
		$model->name = $model_delivery->name;
		$model->ico = $model_delivery->ico;
		$model->id = $model_delivery->id;
		$model->options = $model_delivery->options;
		$options = json_decode($model->options, true);
		//echo'<pre>';print_r($options);echo'</pre>';die;
		if(isset($options['units_qty12'])) $model->units_qty12 = $options['units_qty12'];
		if(isset($options['units_qty3'])) $model->units_qty3 = $options['units_qty3'];
		if(isset($options['units_qty12_q'])) $model->units_qty12_q = $options['units_qty12_q'];
		if(isset($options['units_qty3_q'])) $model->units_qty3_q = $options['units_qty3_q'];
		if(isset($options['free'])) $model->free = $options['free'];

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DeliveryForm']))
		{
			$model->attributes=$_POST['DeliveryForm'];
			$model->units_qty12 = $_POST['DeliveryForm']['units_qty12'];
			$model->units_qty3 = $_POST['DeliveryForm']['units_qty3'];
			$model->units_qty12_q = $_POST['DeliveryForm']['units_qty12_q'];
			$model->units_qty3_q = $_POST['DeliveryForm']['units_qty3_q'];
			
			$options = $_POST['DeliveryForm'];
			unset($options['name']);
			unset($options['options']);
			
			$model->options = json_encode($options);
			
//			echo'<pre>';print_r($_POST['DeliveryForm']);echo'</pre>';//die;
//			echo'<pre>';print_r($options);echo'</pre>';//die;
//			echo'<pre>';print_r(json_encode($options));echo'</pre>';die;
			if($model->validate()) {
				$model_delivery->name = $model->name;
				$model_delivery->ico = $model->ico;
				$model_delivery->options = $model->options;
				$model_delivery->save();
				if(isset($_POST['save']))	{
					$this->redirect(array('admin'));
				}	else	{
					$this->redirect(array('update','id'=>$model->id));
				}
			}
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
		$dataProvider=new CActiveDataProvider('Delivery');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Delivery('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Delivery']))
			$model->attributes=$_GET['Delivery'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Delivery the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Delivery::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Delivery $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='delivery-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
