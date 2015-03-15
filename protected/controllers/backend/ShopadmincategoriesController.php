<?php

class ShopadmincategoriesController extends Controller
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
		$model=new ShopAdminCategories;
		
		$model->getDropDownlistData();
		$model->SelectedCategory = array();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopAdminCategories']))
		{
			$model->attributes = $_POST['ShopAdminCategories'];
			$model->parentId = $_POST['ShopAdminCategories']['parentId'];
			$model->parent_id = $_POST['ShopAdminCategories']['parentId'];
			
			//echo'<pre>';print_r($model);echo'</pre>';die;
			
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
		$model = $this->loadModel($id);
		
		$model->getDropDownlistData();
		$model->SelectedCategory = array();
		$model->SelectedCategory[$model->parent_id] = array('selected' => 'selected');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopAdminCategories']))
		{
			$model->attributes=$_POST['ShopAdminCategories'];
			$model->new_parentId = $_POST['ShopAdminCategories']['parentId'];
			$model->parent_id = $_POST['ShopAdminCategories']['parentId'];
			
			//echo'<pre>';print_r($model);echo'</pre>';die;
			
			if($model->price_discount) {
				$connection = Yii::app()->db;
				
				$rows = ShopProductsAdminCategories::model()->getProducts($model->id, $connection);
				//echo'<pre>';print_r($rows);echo'</pre>';die;
				if(count($rows))	{
					foreach($rows as $row)	{
						$product_price = $row['product_price'] - ($row['product_price'] / 100 * $model->price_discount);
						//echo'<pre>';print_r($product_price);echo'</pre>';die;
						ShopProducts::model()->updateProductPrice($connection, $row['product_id'], $product_price);
					}
				}
				//die;
				$this->redirect(array('update', 'id' => $model->id));
			}
						
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
		$dataProvider=new CActiveDataProvider('ShopAdminCategories');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ShopAdminCategories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopAdminCategories']))
			$model->attributes=$_GET['ShopAdminCategories'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopAdminCategories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShopAdminCategories::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopAdminCategories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-admin-categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
