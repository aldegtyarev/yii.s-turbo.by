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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(
					'admin',
					'delete',
					'create',
					'moveup',
					'movedown',
					'updateparents',
				),

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
		$model=new ShopModelsAuto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$model->getDropDownlistData();
		
		$model->operate_method = 'insert';

		if(isset($_POST['ShopModelsAuto']))
		{
			$model->attributes = $_POST['ShopModelsAuto'];
			$model->parentId = $_POST['ShopModelsAuto']['parentId'];
			$model->parent_id = $_POST['ShopModelsAuto']['parentId'];
			
			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
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
	public function actionUpdateparents()	{
		$models = ShopModelsAuto::model()->findAll();
		foreach($models as $model) {
			$parent_ = $model->parent()->find();
			$model->parent_id = $parent_->id;
			$model->save(false);
		}
	}
	
	
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$model->getDropDownlistData();
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$model->operate_method = 'update';

		if(isset($_POST['ShopModelsAuto']))
		{
			$model->attributes=$_POST['ShopModelsAuto'];
			$model->new_parentId = $_POST['ShopModelsAuto']['parentId'];
			$model->parent_id = $_POST['ShopModelsAuto']['parentId'];
						
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
		
		$app = Yii::app();
		
		//если выбрали какую-то категорию - сохнаняем ее в сессию
		$selected_category = $app->request->getParam('selected_category', -1);
		if($selected_category > -1)	{
			$app->session['ShopModelsAuto.selected_category'] = (int)$selected_category;
		}
		
		$SelectedCategory = -1;
		if(isset($app->session['ShopModelsAuto.selected_category']))	{
			$SelectedCategory = (int)$app->session['ShopModelsAuto.selected_category'];
		}
		
		$model->SelectedCategory = $SelectedCategory;
		
		
		$ShopModelsAuto = new ShopModelsAuto;
		$ShopModelsAuto->getDropDownlistData();
		

		$this->render('admin',array(
			'model'=>$model,
			'DropDownCategories'=>$ShopModelsAuto->DropDownlistData,
			'SelectedCategory'=>$SelectedCategory,
		));
	}
	
	public function actionMoveup($id=0)
	{
		$category = ShopModelsAuto::model()->findByPk($id);
		$prev_cat = $category->prev()->find();
		$category->moveBefore($prev_cat);
		$this->redirect(array('admin'));
	}	
	
	public function actionMovedown($id=0)
	{
		$category = ShopModelsAuto::model()->findByPk($id);
		$next_cat = $category->next()->find();
		$category->moveAfter($next_cat);
		$this->redirect(array('admin'));
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
		
		$model->getParentId();
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
}
