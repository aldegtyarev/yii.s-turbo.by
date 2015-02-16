<?php

class ShopProductsController extends Controller
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
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update','copy','searchajax'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','updateprice'),
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
		$model = new ShopProducts;
		$model->operate_method = 'insert';
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopProducts']))
		{
			$model->attributes=$_POST['ShopProducts'];
			
			if($_FILES['CatalogItems']["name"]["uploading_foto"]) {
				$model->scenario = ShopProducts::SCENARIO_UPLOADING_FOTO;
				$model->uploading_foto = CUploadedFile::getInstance($model,'uploading_foto');
			}
			
			$SelectedCategories = isset($_POST['ShopProducts']['category_ids']) ? $_POST['ShopProducts']['category_ids'] : array();
			$selectedValues = array();
			foreach($SelectedCategories as $cat)	{
				$selectedValues[$cat] = array( 'selected' => 'selected' );
			}
			$model->SelectedCategories = $selectedValues;
			
			$SelectedModels = isset($_POST['ShopProducts']['model_ids']) ? $_POST['ShopProducts']['model_ids'] : array();
			$selectedValues = array();
			foreach($SelectedModels as $cat)	{
				$selectedValues[$cat] = array( 'selected' => 'selected' );
			}
			$model->SelectedModels = $selectedValues;
			
			$SelectedBodies = isset($_POST['ShopProducts']['body_ids']) ? $_POST['ShopProducts']['body_ids'] : array();
			
			$selectedValues = array();
			foreach($SelectedBodies as $cat)	{
				$selectedValues[$cat] = array( 'selected' => 'selected' );
			}
			$model->SelectedBodies = $selectedValues;
			//echo'<pre>';print_r($model->SelectedBodies);echo'</pre>';die;
			
			if($_FILES['ShopProducts']["name"]["uploading_foto"]) {
				$model->scenario = ShopProducts::SCENARIO_UPLOADING_FOTO;
				$model->uploading_foto = CUploadedFile::getInstance($model,'uploading_foto');
			}			
		
			
			if($model->save())
				$this->redirect(array('admin'));
		}
		
		//подготавливаем выпадающий список категорий
		$model->DropDownListCategories = ShopCategories::model()->getDropDownlistDataProduct();
		$model->SelectedCategories = array();
		
		//подготавливаем выпадающий список модельного ряда
		$model->DropDownListModels = ShopModelsAuto::model()->getDropDownlistDataProduct();
		$model->SelectedModels = array();
		
		//подготавливаем выпадающий список кузовов
		$model->DropDownListBodies = ShopBodies::model()->getDropDownlistBodies();
		$model->SelectedBodies = array();
		
		//подготавливаем выпадающий список производителей
		$model->DropDownListManufacturers = ShopManufacturers::model()->getDropDownlistManufacturers();
		$model->SelectedManufacturerId = array();
		
		//подготавливаем выпадающий список фирм
		$model->DropDownListFirms = ShopFirms::model()->getDropDownlistFirms();
		$model->SelectedFirmId = array();
		
		//подготавливаем выпадающий список типов товаров
		$model->DropDownListTypes = ShopProductTypes::model()->getDropDownlistTypes();
		$model->SelectedTypeId = array();
		
		//подготавливаем выпадающий список производителей
		$model->DropDownProductAvailability = ShopProducts::model()->getDropDownProductAvailability();
		$model->SelectedProductAvailabilityId = array();
		$model->SelectedProductAvailabilityId[$model->product_availability] = array('selected' => 'selected');
		
		
		
		$params = Yii::app()->params;

		$this->render('create',array(
			'model'=>$model,
			'params'=>$params,
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
		
		//если нажали "Отмена" возврат на список компаний
		if(isset($_POST['cancel']))	{
			$this->redirect(array('admin'));
		}
		
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$model = $this->loadModel($id);
		
		//$related_product_ids = $app->request->getParam('related_product_ids', array());
		//echo'<pre>';print_r($related);echo'</pre>';die;
		//echo'<pre>';print_r(Yii::getPathOfAlias('webroot.img'). DIRECTORY_SEPARATOR ."watermark.png");echo'</pre>';die;
		
		//если нажали на удаление фото
		$delete_foto = $app->request->getParam('delete_foto', array());
		//echo'<pre>';print_r($delete_foto);echo'</pre>';die;
		
		if(count($delete_foto))	{
			foreach($delete_foto as $foto_id => $foto)	{
				$foto = ShopProductsImages::model()->findByPk($foto_id);
				//echo'<pre>';print_r($foto->main_foto);echo'</pre>';die;
				if($foto->main_foto)	{
					$model->product_image = '';
					$model->save();
					//echo'<pre>';print_r($model);echo'</pre>';die;
				}
				
				ShopProductsImages::model()->deleteFoto($foto_id);
				$this->redirect(array('update','id'=>$id));
			}
		}
		
		
		$model->operate_method = 'update';
		

		if(isset($_POST['ShopProducts']))
		{
			$model->attributes=$_POST['ShopProducts'];
			
			$SelectedCategories = isset($_POST['ShopProducts']['category_ids']) ? $_POST['ShopProducts']['category_ids'] : array();
			$selectedValues = array();
			foreach($SelectedCategories as $cat)	{
				$selectedValues[$cat] = Array ( 'selected' => 'selected' );
			}
			$model->SelectedCategories = $selectedValues;
			
			$SelectedModels = isset($_POST['ShopProducts']['model_ids']) ? $_POST['ShopProducts']['model_ids'] : array();
			$selectedValues = array();
			foreach($SelectedModels as $cat)	{
				$selectedValues[$cat] = Array ( 'selected' => 'selected' );
			}
			$model->SelectedModels = $selectedValues;
			
			$SelectedBodies = isset($_POST['ShopProducts']['body_ids']) ? $_POST['ShopProducts']['body_ids'] : array();
			$selectedValues = array();
			foreach($SelectedBodies as $cat)	{
				$selectedValues[$cat] = Array ( 'selected' => 'selected' );
			}
			$model->SelectedBodies = $selectedValues;
			
			if($_FILES['ShopProducts']["name"]["uploading_foto"]) {
				$model->scenario = ShopProducts::SCENARIO_UPLOADING_FOTO;
				$model->uploading_foto = CUploadedFile::getInstance($model,'uploading_foto');
			}
		
			
			if($model->save())
				//$this->redirect(array('admin'));
				if(isset($_POST['save']))	{
					$this->redirect(array('admin'));
				}	elseif(isset($_POST['apply']))	{
					$this->redirect(array('update','id'=>$model->product_id));
				}
			
		}
		
		//подготавливаем выпадающий список категорий
		$model->DropDownListCategories = ShopCategories::model()->getDropDownlistDataProduct();
		$model->getSelectedCategories();
		
		//подготавливаем выпадающий список модельного ряда
		$model->DropDownListModels = ShopModelsAuto::model()->getDropDownlistDataProduct();
		$model->getSelectedModels();
		
		//подготавливаем выпадающий список производителей
		$model->DropDownListManufacturers = ShopManufacturers::model()->getDropDownlistManufacturers();
		$model->SelectedManufacturerId = array();
		$model->SelectedManufacturerId[$model->manufacturer_id] = array('selected' => 'selected');
		
		//подготавливаем выпадающий список фирм
		$model->DropDownListFirms = ShopFirms::model()->getDropDownlistFirms();
		$model->SelectedFirmId = array();
		$model->SelectedFirmId[$model->firm_id] = array('selected' => 'selected');
		
		//подготавливаем выпадающий список типов товаров
		$model->DropDownListTypes = ShopProductTypes::model()->getDropDownlistTypes();
		$model->SelectedTypeId = array();
		$model->SelectedTypeId[$model->type_id] = array('selected' => 'selected');
		
		//подготавливаем выпадающий список кузовов
		$model->DropDownListBodies = ShopBodies::model()->getDropDownlistBodies();
		$model->getSelectedBodies();

		//подготавливаем выпадающий список производителей
		$model->DropDownProductAvailability = ShopProducts::model()->getDropDownProductAvailability();
		$model->SelectedProductAvailabilityId = array();
		$model->SelectedProductAvailabilityId[$model->product_availability] = array('selected' => 'selected');
		
		
		
		
		
		
		$params = Yii::app()->params;
		//echo'<pre>';print_r($params,0);echo'</pre>';

		$this->render('update',array(
			'model'=>$model,
			'params'=>$params,
		));
	}
	
	public function actionCopy($id)
	{
		$app = Yii::app();
		$model = $this->loadModel($id);
		$model->copyProduct();
		$this->redirect(array('admin'));
	}
	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		
		$Images = $model->Images;
		if(count($Images))	{
			foreach($Images as $row)	{
				ShopProductsImages::model()->deleteFoto($row['image_id']);
			}
		}
		
		
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
		$dataProvider=new CActiveDataProvider('ShopProducts');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new ShopProducts('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['ShopProducts']))
			$model->attributes = $_GET['ShopProducts'];
		
		
		$app = Yii::app();
		
		//echo'<pre>';print_r($_POST,0);echo'</pre>';
		
		//если выбрали какую-то категорию - сохнаняем ее в сессию
		$selected_category = $app->request->getParam('selected_category', -1);
		
		//если выбрали какую-то модель авто - сохнаняем ее в сессию
		$selected_model = $app->request->getParam('selected_model', -1);
		
		
		
		if($selected_category > -1)	{
			$app->session['ShopProducts.selected_category'] = (int)$selected_category;
			$app->session['ShopModelsAuto.selected_model'] = 0;
		}
		
		if($selected_model > -1)	{
			$app->session['ShopModelsAuto.selected_model'] = (int)$selected_model;
			$app->session['ShopProducts.selected_category'] = 0;
		}
		
		
		$SelectedCategory = -1;
		if(isset($app->session['ShopProducts.selected_category']))	{
			$SelectedCategory = (int)$app->session['ShopProducts.selected_category'];
		}
		
		$model->SelectedCategory = $SelectedCategory;		
		
		
		$ShopCategories = new ShopCategories;
		$ShopCategories->getDropDownlistData();
		
		
		
		
		$SelectedModel = -1;
		if(isset($app->session['ShopModelsAuto.selected_model']))	{
			$SelectedModel = (int)$app->session['ShopModelsAuto.selected_model'];
		}
		
		$model->SelectedModel = $SelectedModel;		
		
		
		$ShopModelsAuto = new ShopModelsAuto;
		$ShopModelsAuto->getDropDownlistData();
		
		
		
		
		$this->render('admin',array(
			'model'=>$model,
			'DropDownCategories' => $ShopCategories->DropDownlistData,
			'SelectedCategory' => $SelectedCategory,
			'DropDownModels' => $ShopModelsAuto->DropDownlistData,
			'SelectedModel' => $SelectedModel,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopProducts the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShopProducts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopProducts $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-products-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	function getDropDownLists()
	{
		$lists = array();
		//$lists['categories'] = 
	}
	
	public function actionSearchajax($str)
	{
		$rows = ShopProducts::model()->findAll("`product_name` LIKE :str OR `product_sku` LIKE :str",array(':str' => '%'.$str.'%'));
		//echo'<pre>';print_r($rows,0);echo'</pre>';
		$params = Yii::app()->params;
		
		$this->renderPartial('searchajax',array(
			'rows'=>$rows,
			'params'=>$params,
		));
		
	}
	/*
	public function actionUpdateprice()
	{
		$connection = Yii::app()->db;
		$sql = "SELECT `product_id`, `product_price` FROM {{shop_product_prices}}";
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		
		foreach($rows as $row)	{
			$sql = "UPDATE {{shop_products}} SET `product_price` = :product_price WHERE `product_id` = :product_id";
			$command = $connection->createCommand($sql);
			$command->bindParam(":product_price", $row['product_price']);
			$command->bindParam(":product_id",  $row['product_id']);
			$command->execute();
		}
	}
	*/
}
