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
				'actions'=>array('admin','delete','modellist','createtomodel','updatetomodel','removeimg','removeimage','copy'),
				'users'=>array('superman', 'superman2'),
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
		
		//подготавливаем выпадающий список модельного ряда
		$model->DropDownListModels = ShopModelsAuto::model()->getDropDownlistDataProduct();
		$model->getSelectedModels();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Engines']))
		{
			$model->attributes=$_POST['Engines'];
			if($_FILES['Engines']["name"]["fileImage"]) {
				$model->scenario = 'upload_file';
				$model->fileImage = CUploadedFile::getInstance($model,'fileImage');
			}
			
			$this->setSelectedModels($model);
			//echo'<pre>';print_r($model);echo'</pre>';die;			
						
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

	public function actionCreatetomodel($id)
	{
		$model = new Engines;
		
		//$model->model_id = $id;
		//подготавливаем выпадающий список модельного ряда
		$model->DropDownListEngines = $model->getDropDownlistAllEngines();
		$model->getSelectedModels();
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Engines']))
		{
			$model->attributes=$_POST['Engines'];
			
			if($_FILES['Engines']["name"]["fileImage"]) {
				$model->scenario = 'upload_file';
				$model->fileImage = CUploadedFile::getInstance($model,'fileImage');
			}
			
			if($model->validate()) {
				$model->uploadFile();
				$model->save();
				
				if(isset($_POST['save']))	{
					$this->redirect(array('modellist','model_id'=>$id));
				}	else	{
					$this->redirect(array('update','id'=>$model->id));
				}

			}
		}

		$this->render('create-to-model',array(
			'model'=>$model,
			'model_title'=>ShopModelsAuto::model()->getModelChain($id),
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
		
		//подготавливаем выпадающий список модельного ряда
		$model->DropDownListModels = ShopModelsAuto::model()->getDropDownlistDataProduct();
		$model->getSelectedModels();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Engines']))
		{
			$model->attributes=$_POST['Engines'];
			if($_FILES['Engines']["name"]["fileImage"]) {
				$model->scenario = 'upload_file';
				$model->fileImage = CUploadedFile::getInstance($model,'fileImage');
			}
			
			$this->setSelectedModels($model);
			
			
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

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionUpdatetomodel($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Engines']))
		{
			$model->attributes=$_POST['Engines'];
			if($_FILES['Engines']["name"]["fileImage"]) {
				$model->scenario = 'upload_file';
				$model->fileImage = CUploadedFile::getInstance($model,'fileImage');
			}
			
			if($model->validate()) {
				$model->uploadFile();
				$model->save();
				
				if(isset($_POST['save']))	{
					$this->redirect(array('modellist', 'model_id'=>$model->model_id));
				}	else	{
					$this->redirect(array('updatetomodel','id'=>$model->id));
				}
			}
		}

		$this->render('update-to-model',array(
			'model'=>$model,
			'model_title'=>ShopModelsAuto::model()->getModelChain($model->model_id),
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
		$model=$this->loadModel($id);
		$model->deleteFile();
		$model->delete();
		

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
		
		$app = Yii::app();
		
		//подготавливаем выпадающий список модельного ряда
		$model->DropDownListModels = ShopModelsAuto::model()->getDropDownlistDataProduct();
		$list_data = array(0 => 'Все');
		$model->DropDownListModels = $list_data + $model->DropDownListModels;
		
		if(isset($_GET['Engines']))
			$model->attributes=$_GET['Engines'];
		
		//если выбрали какую-то модель авто - сохнаняем ее в сессию
		$selected_model = $app->request->getParam('selected_model', 0);

		if($selected_model >= 0)	{
			$app->session['Engines.selected_model'] = (int)$selected_model;
		}
		
		$SelectedModel = 0;
		if(isset($app->session['Engines.selected_model']))	{
			$SelectedModel = (int)$app->session['Engines.selected_model'];
		}
		
		//echo'<pre>';print_r($SelectedModel);echo'</pre>';//die;
		

		$this->render('admin',array(
			'model'=>$model,
			'SelectedModel' => $SelectedModel,			
		));
	}

	public function actionModellist($model_id)
	{
		$model = new Engines('searchmodellist');
		$model->unsetAttributes();  // clear any default values
		
		$model->model_id = $model_id;
		
		if(isset($_GET['Engines']))
			$model->attributes=$_GET['Engines'];

		$this->render('model-list',array(
			'model'=>$model,
			'model_id'=>$model_id,
			'model_title'=>ShopModelsAuto::model()->getModelChain($model_id),
		));
	}
	
	public function actionRemoveimg($id=0)
	{
		$model = $this->loadModel($id);
		$model->deleteFile();
		$model->save();
		$this->redirect(array('updatetomodel','id'=>$model->id));
	}
	
	public function actionRemoveimage($id=0)
	{
		$model = $this->loadModel($id);
		
		//echo'<pre>';print_r($model,0);echo'</pre>';die;

		$model->deleteFile();
		$model->save();
		
		$this->redirect(array('update','id'=>$model->id));
	}
	
	public function actionCopy($id)
	{
		$app = Yii::app();
		$model_copy = $this->loadModel($id);
		
		$model = new Engines();
		$model->name = $model_copy->name.' copy';
		$model->image_file = $model_copy->image_file;
		$model->title = $model_copy->title;
		$model->keywords = $model_copy->keywords;
		$model->description = $model_copy->description;
		
		
		//echo'<pre>';print_r($model);echo'</pre>';die;
		
		$imagePath = Yii::getPathOfAlias(Yii::app()->params->product_imagePath);
		
		if($model->image_file != '' && file_exists($imagePath . DIRECTORY_SEPARATOR . $model->image_file)) {
			//echo'<pre>';print_r($model);echo'</pre>';	
			$file_extention = $model->getExtentionFromFileName($model->image_file);
			
			$filename = md5(strtotime('now')).$file_extention;
			
			copy (($imagePath . DIRECTORY_SEPARATOR . $model->image_file), ($imagePath . DIRECTORY_SEPARATOR . $filename) );
			
			$model->image_file = $filename;
		}
		
		$model->save();
		
		//die;
		
		//$model->copyProduct();
        //$app->session['ShopproductForm.current_tab'] = '#tab1';
		$this->redirect(array('admin'));
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
	
	private function setSelectedModels(&$model)
	{
		$SelectedModels = isset($_POST['Engines']['model_ids']) ? $_POST['Engines']['model_ids'] : array();
		$selectedValues = array();
		foreach($SelectedModels as $cat)	{
			$selectedValues[$cat] = array( 'selected' => 'selected' );
		}
		$model->SelectedModels = $selectedValues;
		//echo'<pre>';print_r($selectedValues);echo'</pre>';die;
		return;
	}
}
