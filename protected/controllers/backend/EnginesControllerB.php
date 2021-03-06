<?php

class EnginesController extends Controller
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
				'actions'=>array('admin','delete','moveup','movedown','removeimg'),
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
		$model=new Engines;
		$model->getDropDownlistData();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Engines']))
		{
			$model->attributes=$_POST['Engines'];
			$model->parentId = $_POST['Engines']['parentId'];
			$model->parent_id = $_POST['Engines']['parentId'];
			
			if($_FILES['Engines']["name"]["fileImage"]) {
				$model->scenario = 'upload_file';
				$model->fileImage = CUploadedFile::getInstance($model,'fileImage');
			}
						
			if($model->validate()) {
				$model->uploadFile();
				$model->save();
				
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
		$model=$this->loadModel($id);
		$model->getDropDownlistData();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		//echo'<pre>';print_r($_FILES,0);echo'</pre>';die;

		if(isset($_POST['Engines']))
		{
			$model->attributes=$_POST['Engines'];
			$model->new_parentId = $_POST['Engines']['parentId'];
			$model->parent_id = $_POST['Engines']['parentId'];
			
			if($_FILES['Engines']["name"]["fileImage"]) {
				$model->scenario = 'upload_file';
				$model->fileImage = CUploadedFile::getInstance($model,'fileImage');
				
			}
			
			if($model->validate()) {
				$model->uploadFile();
				$model->save();
				
				if(isset($_POST['save']))	{
					$this->redirect(array('admin'));
				}	else	{
					$this->redirect(array('update','id'=>$model->id));
				}
				
				//$this->redirect(array('admin'));
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
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->deleteFile();
		$model->deleteNode();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Engines');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Engines('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Engines']))
			$model->attributes=$_GET['Engines'];
		
		$app = Yii::app();
		
		//если выбрали какую-то категорию - сохнаняем ее в сессию
		$selected_category = $app->request->getParam('selected_category', -1);
		if($selected_category > -1)	{
			$app->session['Engines.backend.selected'] = (int)$selected_category;
		}
		
		$SelectedCategory = -1;
		if(isset($app->session['Engines.backend.selected']))	{
			$SelectedCategory = (int)$app->session['Engines.backend.selected'];
		}
		
		$model->SelectedCategory = $SelectedCategory;
		
		$ShopCategories = new Engines;
		$ShopCategories->getDropDownlistData();
		

		$this->render('admin',array(
			'model'=>$model,
			'DropDownCategories'=>$ShopCategories->DropDownlistData,
			'SelectedCategory'=>$SelectedCategory,
		));
	}
	
	public function actionMoveup($id=0)
	{
		$model=$this->loadModel($id);
		$prev_model = $model->prev()->find();
		$model->moveBefore($prev_model);
		$this->redirect(array('admin'));
	}	
	
	public function actionMovedown($id=0)
	{
		$model=$this->loadModel($id);
		$next_next = $model->next()->find();
		$model->moveAfter($next_next);
		$this->redirect(array('admin'));
	}
	
	public function actionRemoveimg($id=0)
	{
		$app = Yii::app();
		$model = $this->loadModel($id);
		$model->new_parentId = $model->parent_id;
		
		//echo'<pre>';print_r($model,0);echo'</pre>';die;

		$model->deleteFile();
		$model->save();
		
		$this->redirect(array('update','id'=>$model->id));
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Engines the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Engines::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		$model->getParentId();		
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Engines $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='engines-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
