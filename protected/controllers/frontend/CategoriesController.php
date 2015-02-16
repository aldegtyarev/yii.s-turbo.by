<?php

class CategoriesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2r';
	
	public $CQtreeGreedView  = array (
		'modelClassName' => 'page2', //название класса
		'adminAction' => 'admin' //action, где выводится QTreeGridView. Сюда будет идти редирект с других действий.
	);
	
    public function actions() {
        return array (
            'create'=>'ext.QTreeGridView.actions.Create',
            'update'=>'ext.QTreeGridView.actions.Update',
            'delete'=>'ext.QTreeGridView.actions.Delete',
            'moveNode'=>'ext.QTreeGridView.actions.MoveNode',
            'makeRoot'=>'ext.QTreeGridView.actions.MakeRoot',
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','movecategories'),
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
		$model=new Categories;
		
		/*
		$root=new Categories;
		$root->name='Autos';
		$root->saveNode();
		*/
		
		//$model->getTreeCategories();
		$model->getDropDownlistData();
		//$DownListTree = $model->getdropDownListTreeCategories();
		//echo'<pre>';print_r($_POST);echo'</pre>';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		if(isset($_POST['Categories']))
		{
			$model->attributes = $_POST['Categories'];
			$model->parentId = $_POST['Categories']['parentId'];
			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
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
		$model=$this->loadModel($id);
		$model->getDropDownlistData();

		$model->parentId = $model->parent()->find();	//получаем предка	

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Categories']))
		{
			$model->attributes=$_POST['Categories'];
			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('admin','id'=>$model->id));
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
		
		$dataProvider=new CActiveDataProvider('Categories');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Categories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Categories']))
			$model->attributes=$_GET['Categories'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionMovecategories()
	{
		$connection = Yii::app()->db;
		
		$sql = 'TRUNCATE TABLE {{categories}}';
		$command = $connection->createCommand($sql);
		//$res = $command->execute();
		
		$sql = "select cr.*, cc.category_parent_id, ca.ordering
				FROM s9r5d_virtuemart_categories_ru_ru as cr
				INNER JOIN s9r5d_virtuemart_category_categories AS cc ON cc.category_child_id = cr.virtuemart_category_id
				INNER JOIN s9r5d_virtuemart_categories AS ca ON ca.virtuemart_category_id = cr.virtuemart_category_id
				WHERE cr.virtuemart_category_id >= 1000 AND cr.virtuemart_category_id <=1499 ORDER BY cr.virtuemart_category_id";
		$command = $connection->createCommand($sql);
		$virtuemart_categories = $command->queryAll();
		$virtuemart_categories1 = $virtuemart_categories;
		$deleted_cats = array();
		//echo'<pre>';print_r($virtuemart_categories);echo'</pre>';
		foreach($virtuemart_categories as $key=>$cat) {
			//echo'<pre>';print_r($cat);echo'</pre>';
			/*
			$data_['Categories'][parentId] = ;
			$data_['Categories'][name] = $cat['category_name'];
			$data_['Categories'][title] = '';
			$data_['Categories'][keywords] = '';
			$data_['Categories'][description] = '';
			$data_['Categories'][alias] = '';
			*/
			$add_record = false;
			$add_record = true;
			/*
			if($cat['category_parent_id'] == 0)	{
				$add_record = true;
			}	else	{
				foreach($virtuemart_categories1 as $cat1) {
					if($cat['category_parent_id'] == $cat1['virtuemart_category_id'])	{
						$add_record = true;
						break;
					}
				}
			}
			*/
			if($add_record)	{
				$model = new Categories;
				$model->id = $cat['virtuemart_category_id'];
				$model->parentId = $cat['category_parent_id'];
				$model->name = $cat['category_name'];
				$model->title = $cat['custom_title'];
				$model->keywords = $cat['metakey'];
				$model->description = $cat['metadesc'];
				$model->alias = $cat['slug'];
				$model->ordering = $cat['ordering'];
				$model->category_companies = $cat['category_companies'];
				$model->cat_column = $cat['cat_column'];
				$model->save();
			}	else	{
				$virtuemart_categories[$key]['deleted'] = 1;
			}
			echo'<pre>';print_r($cat);echo'</pre>';
		}
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Categories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Categories::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Categories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
