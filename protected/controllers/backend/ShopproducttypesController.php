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
				'actions'=>array(
					'admin',
					'delete',
					'moveup',
					'movedown',
					'relatedadd',
					'relateddelete',
					'relatedupdate',
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
		$app = Yii::app();

		$task = $app->request->getParam('task', '');

		$model = $this->loadModel($id);
		$model->getDropDownlistData();

		if(isset($_POST['ShopProductTypes'])) {
			$model->attributes=$_POST['ShopProductTypes'];

			if($task == 'update_price') {
				$model->updatePricesInProducts();
				$this->redirect(array('update','id'=>$id));
			}	elseif($task == 'update_price_fake')	{
				$model->updateFakePricesInProducts();
				$this->redirect(array('update','id'=>$id));
			}


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
	 * Добавление связанной категории к группе товаров
	 * @param int $id
	 */
	public function actionRelatedadd($id)
	{
		$model = new ShopProductTypeRelationForm();

		$model->type_id = $id;

		$DropDownCategories = ShopCategories::model()->getDropDownlistItems();
		$DropDownTypes = ShopProductTypes::model()->getDropDownlistItems();
		$DropDownModels = ShopModelsAuto::model()->getDropDownlistDataProduct();

		//echo'<pre>';print_r($_POST);echo'</pre>';die;

		if(isset($_POST['ShopProductTypeRelationForm']))	{
			$model->type_related_id = $_POST['ShopProductTypeRelationForm']['type_related_id'];
			$model->model_ids = $_POST['ShopProductTypeRelationForm']['model_ids'];
			$model->name = $_POST['ShopProductTypeRelationForm']['name'];
			$model->category_id = $_POST['ShopProductTypeRelationForm']['category_id'];

			if($model->category_id != 0 && count($model->model_ids) != 0) {
				$type_relation = new ShopProductTypesRelations();
				$type_relation->type_id = $model->type_id;
				$type_relation->name = $model->name;
				$type_relation->type_related_id = $model->type_related_id;
				$type_relation->category_id = $model->category_id;

				$type_relation->setSelectedModelIds($model->model_ids);
				$type_relation->save();

				$this->redirect(array('update', 'id' => $model->type_id));
			}
		}

		$category = $this->loadModel($model->type_id);

		$breadcrumbs = array(
			'Группа товаров' => array('admin'),
			$category->name => array('update','id'=>$category->type_id),
			'Связаная группа товаров - Новая',
		);

		$menu = array(
			array('label'=>'Группа товаров', 'url'=>array('admin')),
			array('label'=>$category->name, 'url'=>array('update','id'=>$category->type_id)),
		);

		$this->render('related-form', array(
			'model'=>$model,
			'DropDownCategories'=> $DropDownCategories,
			'DropDownTypes'=> $DropDownTypes,
			'DropDownModels'=> $DropDownModels,
			'breadcrumbs'=> $breadcrumbs,
			'menu'=> $menu,
		));

	}

	/**
	 * Обновление связанной категории к категории
	 * @param int $id
	 * @throws CHttpException
	 */
	public function actionRelatedupdate($id)
	{
		$cat_relation = ShopProductTypesRelations::model()->findByPk($id);

		if($cat_relation===null)
			throw new CHttpException(404,'The requested page does not exist.');

		$model = new ShopProductTypeRelationForm();

		$model->type_id = $cat_relation->type_id;
		$model->name = $cat_relation->name;
		$model->type_related_id = $cat_relation->type_related_id;
		$model->category_id = $cat_relation->category_id;

		foreach ($cat_relation->typesRelationsModels as $item)
			$model->model_ids[$item->model_id] = array('selected' => 'selected');

		//echo'<pre>';print_r($model);echo'</pre>';die;

		if(isset($_POST['ShopProductTypeRelationForm']))	{
			$model->type_related_id = $_POST['ShopProductTypeRelationForm']['type_related_id'];
			$model->model_ids = $_POST['ShopProductTypeRelationForm']['model_ids'];
			$model->name = $_POST['ShopProductTypeRelationForm']['name'];
			$model->category_id = $_POST['ShopProductTypeRelationForm']['category_id'];

			if($model->category_id != 0 && count($model->model_ids) != 0) {
				$cat_relation->setSelectedModelIds($model->model_ids);
				$cat_relation->type_id = $model->type_id;
				$cat_relation->name = $model->name;
				$cat_relation->type_related_id = $model->type_related_id;
				$cat_relation->category_id = $model->category_id;

				//echo'<pre>';print_r($cat_relation);echo'</pre>';die;
				$cat_relation->save();

				$this->redirect(array('update', 'id' => $model->type_id));
			}
		}

		$DropDownCategories = ShopCategories::model()->getDropDownlistItems();
		$DropDownTypes = ShopProductTypes::model()->getDropDownlistItems();
		$DropDownModels = ShopModelsAuto::model()->getDropDownlistDataProduct();

		$breadcrumbs = array(
			'Группа товаров' => array('admin'),
			$category->name => array('update','id'=>$category->type_id),
			'Связаная группа товаров - Изменить',
		);

		$menu = array(
			array('label'=>'Группа товаров', 'url'=>array('admin')),
			array('label'=>$category->name, 'url'=>array('update','id'=>$category->type_id)),
		);

		$this->render('related-form', array(
			'model'=>$model,
			'cat_relation'=>$cat_relation,
			'DropDownCategories'=> $DropDownCategories,
			'DropDownTypes'=> $DropDownTypes,
			'DropDownModels'=> $DropDownModels,
			'breadcrumbs'=> $breadcrumbs,
			'menu'=> $menu,
		));
	}

	/**
	 * @param int $id
	 * @throws CHttpException
	 */
	public function actionRelateddelete($id)
	{
		$model = ShopProductTypesRelations::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');

		$return_url = $this->createUrl('update', array('id'=>$model->type_id));
		$model->delete();
		$this->redirect($return_url);
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
