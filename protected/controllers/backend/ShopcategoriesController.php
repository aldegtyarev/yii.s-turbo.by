<?php

class ShopCategoriesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $defaultAction='admin';
	
	/*
	public $CQtreeGreedView  = array (
		'modelClassName' => 'page2', //название класса
		'adminAction' => 'admin' //action, где выводится QTreeGridView. Сюда будет идти редирект с других действий.
	);
	*/
	
    public function actions() {
        return array (
			/*
            'create'=>'ext.QTreeGridView.actions.Create',
            'update'=>'ext.QTreeGridView.actions.Update',
            'delete'=>'ext.QTreeGridView.actions.Delete',
            'moveNode'=>'ext.QTreeGridView.actions.MoveNode',
            'makeRoot'=>'ext.QTreeGridView.actions.MakeRoot',
			*/
        );
    }	


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
				'actions'=>array('index','view','show'),
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
					'movecategories',
					'updatepath',
					'updatemeta',
					'updatemeta1',
					'updateshowinmenu',
					'moveup',
					'movedown',
					'removefoto',
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
	
	
	public function actionShow($path)
	{
		$category = ShopCategories::model()->findByPath($path);
		$descendants = $category->children()->findAll(array('order'=>'ordering'));
		$products_and_pages = ShopProducts::model()->findProductsInCat($category->id);
		
		if(count($descendants)) ShopCategories::model()->getCategoriesMedias($descendants);		
		
		$data = array	(
			'category'=> $category,
			'descendants'=> $descendants,
			'products_and_pages'=> $products_and_pages,
		);
						
		$this->render('show', $data);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new ShopCategories;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->getDropDownlistData();

		if(isset($_POST['ShopCategories']))
		{
			$model->attributes = $_POST['ShopCategories'];
			$model->parentId = $_POST['ShopCategories']['parentId'];
			$model->parent_id = $_POST['ShopCategories']['parentId'];
			
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
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
		
		$model->cargo_type_old = $model->cargo_type;

		$task = Yii::app()->request->getParam('task', '');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopCategories']))	{

			$model->attributes=$_POST['ShopCategories'];

			if($task == 'update_price') {
				$model->updatePricesInProducts();
				$this->redirect(array('update','id'=>$id));
			}	elseif($task == 'update_price_fake')	{
				$model->updateFakePricesInProducts();
				$this->redirect(array('update','id'=>$id));
			}


			if($_FILES['ShopCategories']["name"]["uploading_foto"]) {
				$model->scenario = Pages::SCENARIO_UPLOADING_FOTO;
				$model->removeFoto();
				$model->uploading_foto = CUploadedFile::getInstance($model,'uploading_foto');
			}			
			

			$model->new_parentId = $_POST['ShopCategories']['parentId'];
			$model->parent_id = $_POST['ShopCategories']['parentId'];
			
			if($model->cargo_type != '' && $model->cargo_type != $model->cargo_type_old) $model->updateCargoType();
			
			if($model->save()) {
				if(isset($_POST['save']))	{
					$this->redirect(array('admin'));
				}	else	{
					$this->redirect(array('update','id'=>$model->id));
				}
			}
		}

		/*
		echo'<pre>';print_r($model->сategoriesRelated[0]->category->name);echo'</pre>';//die;
		echo'<pre>';print_r($model->сategoriesRelated[0]->categoriesRelationsModels[0]->model->id);echo'</pre>';//die;
		echo'<pre>';print_r(ShopModelsAuto::model()->getModelChain($model->сategoriesRelated[0]->categoriesRelationsModels[0]->model->id));echo'</pre>';//die;
		*/

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
	
	public function actionRemovefoto($id)
	{
		$model = $this->loadModel($id);
		$model->removeFoto();
		$model->save();
		$this->redirect(array('update','id'=>$model->id));
	}
	

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ShopCategories');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new ShopCategories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopCategories']))
			$model->attributes=$_GET['ShopCategories'];
		
		$app = Yii::app();
		
		//если выбрали какую-то категорию - сохнаняем ее в сессию
		$selected_category = $app->request->getParam('selected_category', -1);
		if($selected_category > -1)	{
			$app->session['ShopCategories.selected_category'] = (int)$selected_category;
		}
		
		$SelectedCategory = -1;
		if(isset($app->session['ShopCategories.selected_category']))	{
			$SelectedCategory = (int)$app->session['ShopCategories.selected_category'];
		}
		
		$model->SelectedCategory = $SelectedCategory;
		
		$ShopCategories = new ShopCategories;
		$ShopCategories->getDropDownlistData();

		$this->render('admin',array(
			'model'=>$model,
			'DropDownCategories'=>$ShopCategories->DropDownlistData,
			'SelectedCategory'=>$SelectedCategory,			
		));
	}
	
	public function actionMoveup($id=0)
	{
		$category = ShopCategories::model()->findByPk($id);
		$prev_cat = $category->prev()->find();
		$category->moveBefore($prev_cat);
		$this->redirect(array('admin'));
	}	
	
	public function actionMovedown($id=0)
	{
		$category = ShopCategories::model()->findByPk($id);
		$next_cat = $category->next()->find();
		$category->moveAfter($next_cat);
		$this->redirect(array('admin'));
	}

	/**
	 * Добавление связанной категории к категории
	 * @param int $id
	 */
	public function actionRelatedadd($id)
	{
		$model = new ShopCategoryRelationForm();

		$model->category_id = $id;

		$DropDownCategories = ShopCategories::model()->getDropDownlistItems();
		$DropDownModels = ShopModelsAuto::model()->getDropDownlistDataProduct();

		//echo'<pre>';print_r($_POST);echo'</pre>';die;

		if(isset($_POST['ShopCategoryRelationForm']))	{
			$model->category_related_id = $_POST['ShopCategoryRelationForm']['category_related_id'];
			$model->name = $_POST['ShopCategoryRelationForm']['name'];
			$model->model_ids = $_POST['ShopCategoryRelationForm']['model_ids'];

			if($model->category_related_id != 0 && count($model->model_ids) != 0) {
				$cat_relation = new ShopCategoriesRelations();
				$cat_relation->category_id = $model->category_id;
				$cat_relation->name = $model->name;
				$cat_relation->category_related_id = $model->category_related_id;

				$cat_relation->setSelectedModelIds($model->model_ids);
				$cat_relation->save();

				$this->redirect(array('shopcategories/update', 'id' => $model->category_id));
			}
		}

		$category = $this->loadModel($model->category_id);

		$breadcrumbs = array(
			'Список категорий' => array('admin'),
			$category->name => array('update','id'=>$category->id),
			'Связаная категория - Новая',
		);

		$menu = array(
			array('label'=>'Список категорий', 'url'=>array('admin')),
			array('label'=>$category->name, 'url'=>array('update','id'=>$category->id)),
		);

		$this->render('related-form', array(
			'model'=>$model,
			'cat_relation'=>$cat_relation,
			'DropDownCategories'=> $DropDownCategories,
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
		$cat_relation = ShopCategoriesRelations::model()->findByPk($id);

		if($cat_relation===null)
			throw new CHttpException(404,'The requested page does not exist.');

		$model = new ShopCategoryRelationForm();

		$model->category_id = $cat_relation->category_id;
		$model->category_related_id = $cat_relation->category_related_id;
		$model->name = $cat_relation->name;

		foreach ($cat_relation->categoriesRelationsModels as $item)
			$model->model_ids[$item->model_id] = array('selected' => 'selected');

		//echo'<pre>';print_r($model);echo'</pre>';die;



		if(isset($_POST['ShopCategoryRelationForm']))	{
			$model->category_related_id = $_POST['ShopCategoryRelationForm']['category_related_id'];
			$model->model_ids = $_POST['ShopCategoryRelationForm']['model_ids'];
			$model->name = $_POST['ShopCategoryRelationForm']['name'];

			if($model->category_related_id != 0 && count($model->model_ids) != 0) {
				//echo'<pre>';print_r($model);echo'</pre>';die;

				$cat_relation->setSelectedModelIds($model->model_ids);

				$cat_relation->category_id = $model->category_id;
				$cat_relation->category_related_id = $model->category_related_id;
				$cat_relation->name = $model->name;
				$cat_relation->save();

				$this->redirect(array('shopcategories/update', 'id' => $model->category_id));
			}
		}

		$DropDownCategories = ShopCategories::model()->getDropDownlistItems();
		$DropDownModels = ShopModelsAuto::model()->getDropDownlistDataProduct();

		$breadcrumbs = array(
			'Список категорий' => array('admin'),
			$cat_relation->category->name => array('update','id'=>$cat_relation->category_id),
			'Связаная категория - Изменить',
		);

		$menu = array(
			array('label'=>'Список категорий', 'url'=>array('admin')),
			array('label'=>$cat_relation->category->name, 'url'=>array('update','id'=>$cat_relation->category_id)),
		);

		$this->render('related-form', array(
			'model'=>$model,
			'cat_relation'=>$cat_relation,
			'DropDownCategories'=> $DropDownCategories,
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
		$model = ShopCategoriesRelations::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');

		$return_url = $this->createUrl('update', array('id'=>$model->category_id));
		$model->delete();
		$this->redirect($return_url);
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopCategories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = ShopCategories::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		$model->getParentId();
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopCategories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
