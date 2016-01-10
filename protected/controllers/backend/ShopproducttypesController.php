<?php

class ShopProductTypesController extends Controller
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
				'actions'=>array('admin','delete','moveup','movedown'),
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
		$model=new ShopProductTypes;
		$model->getDropDownlistData();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopProductTypes']))
		{
			$model->attributes=$_POST['ShopProductTypes'];
			$model->parentId = $_POST['ShopProductTypes']['parentId'];
			$model->parent_id = $_POST['ShopProductTypes']['parentId'];
			if($model->save())
				$this->redirect(array('admin'));
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
		$model->getDropDownlistData();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopProductTypes']))
		{
			$model->attributes=$_POST['ShopProductTypes'];
			$model->new_parentId = $_POST['ShopProductTypes']['parentId'];
			$model->parent_id = $_POST['ShopProductTypes']['parentId'];
			
			if($model->cargo_type != '') $model->updateCargoType();
			
			$model->validate();
			//echo'<pre>';print_r($model);echo'</pre>';die;
			if($model->save())
				$this->redirect(array('admin'));
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
		//$this->loadModel($id)->delete();
		$this->loadModel($id)->deleteNode();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ShopProductTypes');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ShopProductTypes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopProductTypes']))
			$model->attributes=$_GET['ShopProductTypes'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopProductTypes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShopProductTypes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		$model->getParentId();
		
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopProductTypes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-product-types-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionMoveup($id=0)
	{
		$category = ShopProductTypes::model()->findByPk($id);
		$prev_cat = $category->prev()->find();
		$category->moveBefore($prev_cat);
		$this->redirect(array('admin'));
	}	
	
	public function actionMovedown($id=0)
	{
		$category = ShopProductTypes::model()->findByPk($id);
		$next_cat = $category->next()->find();
		$category->moveAfter($next_cat);
		$this->redirect(array('admin'));
	}
	
}
