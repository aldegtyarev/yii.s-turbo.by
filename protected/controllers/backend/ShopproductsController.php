<?php

class ShopProductsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $defaultAction='admin';


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
				'actions'=>array(
					'admin',
					'delete',
					'updateprice',
					'publishup',
					'publishdown',
					'batchdelete',
					'moveup',
					'movedown',
					'imgrename',
					'sitemapcreate',
					'setuni',
				),
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
		$model = new ShopProducts;
		$model->operate_method = 'insert';
		
		$app = Yii::app();
		
		$current_tab = $app->request->getParam('current-tab', '#tab1');
		

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

			$model->product_price_default = $model->product_price;
			
			if($_FILES['ShopProducts']["name"]["uploading_foto"]) {
				$model->scenario = ShopProducts::SCENARIO_UPLOADING_FOTO;
				$model->uploading_foto = CUploadedFile::getInstance($model,'uploading_foto');
			}			
		
			
			if($model->save())
				$this->redirect(array('admin'));
		}
        
		//подготавливаем выпадающий список адм. категорий
		$model->DropDownListAdminCategories = ShopAdminCategories::model()->getDropDownlistDataProduct();
		$model->getSelectedAdminCategories();
		
		//подготавливаем выпадающий список категорий
		$model->DropDownListCategories = ShopCategories::model()->getDropDownlistDataProduct();
		$model->SelectedCategories = array();
		
		//подготавливаем выпадающий список модельного ряда
		$model->DropDownListModels = ShopModelsAuto::model()->getDropDownlistDataProduct();
		$model->SelectedModels = array();
		
		//подготавливаем выпадающий список модельного ряда для исключения на опред. моделях
		$model->DropDownListModelsDisabled = $model->DropDownListModels;
		$model->getSelectedModelsDisabled();
		
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
		
		//подготавливаем выпадающий список наличия товара
		$model->DropDownProductAvailability = ShopProducts::model()->getDropDownProductAvailability();
		$model->SelectedProductAvailabilityId = array();
		$model->SelectedProductAvailabilityId[$model->product_availability] = array('selected' => 'selected');
		
		//подготавливаем выпадающий список для стороны товара
		$model->DropDownProductSide = ShopProducts::model()->getDropDownProductSide();
		$model->SelectedProductSideId = array();
		$model->SelectedProductSideId[$model->side] = array('selected' => 'selected');
		
		//подготавливаем выпадающий список объемов двигателей
		$model->DropDownListEngines = Engines::model()->getDropDownlistEngines($model->SelectedModels);
		$model->getSelectedEngines();
		
		$params = $app->params;

		$this->render('create',array(
			'model'=>$model,
			'params'=>$params,
			'current_tab'=>$current_tab,
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
		if(isset($_POST['cancel']))	
			$this->redirect(array('admin'));

		$task = $app->request->getParam('task', '');

		$current_tab_request = $app->request->getParam('current-tab', '');
		
		if(isset($app->session['ShopproductForm.current_tab']))	{
			$current_tab_session = $app->session['ShopproductForm.current_tab'];
		}	else	{
			$current_tab_session = '#tab1';
		}
		
		if($current_tab_request != '')	{
			$current_tab = $current_tab_request;
		}	else	{
			$current_tab = $current_tab_session;
		}
				
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$model = $this->loadModel($id);
		
		//если нажали на удаление фото
		$delete_foto = $app->request->getParam('delete_foto', array());
		
		if(count($delete_foto))	{
			foreach($delete_foto as $foto_id => $foto)	{
				$foto = ShopProductsImages::model()->findByPk($foto_id);
				if($foto->main_foto)	{
					$model->product_image = '';
					$model->save();
				}
				ShopProductsImages::model()->deleteFoto($foto_id, $model->product_id);
			}
            
			$Images = $model->Images;
			//echo'<pre>';print_r($Images, 0);echo'</pre>';//die;
			
			if(count($Images))	{
                $main_foto_present = false;
                
                foreach($Images as $img) {
                    if($img->main_foto == 1)    {
                        $main_foto_present = true;
                        break;
                    }
                }
                
                if($main_foto_present == false) {
                    $connection = $app->db;				
                    $_POST['main_foto'] = $Images[0]->image_id;
                    ShopProducts::model()->setProductImage($connection,  $Images[0]->image_file, $model->product_id);
					ShopProductsImages::model()->setMainFoto($connection, $Images[0]->image_id, $model->product_id);
                }
			}
            
            $this->redirect(array('update','id'=>$model->product_id));
		}
		
		
		$model->operate_method = 'update';
		

		if(isset($_POST['ShopProducts']))
		{
			$model->attributes=$_POST['ShopProducts'];

			if($task == 'update_price') {
				$model->updatePriceInProduct();
				$this->redirect(array('update','id'=>$id));
			}	elseif($task == 'update_price_fake')	{
				$model->updateFakePriceInProduct();
				$this->redirect(array('update','id'=>$id));
			}

			$SelectedCategories = isset($_POST['ShopProducts']['admin_category_ids']) ? $_POST['ShopProducts']['admin_category_ids'] : array();
			$selectedValues = array();
			foreach($SelectedCategories as $cat)	{
				$selectedValues[$cat] = Array ( 'selected' => 'selected' );
			}
			$model->SelectedAdminCategories = $selectedValues;
			
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
			
			$SelectedModels = isset($_POST['ShopProducts']['model_ids_dis']) ? $_POST['ShopProducts']['model_ids_dis'] : array();
			$selectedValues = array();
			foreach($SelectedModels as $cat)	{
				$selectedValues[$cat] = Array ( 'selected' => 'selected' );
			}
			$model->SelectedModelsDisabled = $selectedValues;
			
			$SelectedBodies = isset($_POST['ShopProducts']['body_ids']) ? $_POST['ShopProducts']['body_ids'] : array();
			$selectedValues = array();
			foreach($SelectedBodies as $cat)	{
				$selectedValues[$cat] = Array ( 'selected' => 'selected' );
			}
			$model->SelectedBodies = $selectedValues;
			
			$SelectedEngines = isset($_POST['ShopProducts']['engine_ids']) ? $_POST['ShopProducts']['engine_ids'] : array();
			$selectedValues = array();
			foreach($SelectedEngines as $cat)	{
				$selectedValues[$cat] = Array ( 'selected' => 'selected' );
			}
			$model->SelectedEngines = $selectedValues;
			
			
			if($_FILES['ShopProducts']["name"]["uploading_foto"]) {
				$model->scenario = ShopProducts::SCENARIO_UPLOADING_FOTO;
				$model->uploading_foto = CUploadedFile::getInstance($model,'uploading_foto');
			}
		
			
			if($model->save())
				if(isset($_POST['save']))	{
					$app->session['ShopproductForm.current_tab'] = '#tab1';
					$this->redirect(array('admin'));
				}	else	{
					$app->session['ShopproductForm.current_tab'] = $current_tab;
					$this->redirect(array('update','id'=>$model->product_id));
				}
		}
		
		//подготавливаем выпадающий список адм. категорий
		$model->DropDownListAdminCategories = ShopAdminCategories::model()->getDropDownlistDataProduct();
		$model->getSelectedAdminCategories();
		
		//подготавливаем выпадающий список категорий
		$model->DropDownListCategories = ShopCategories::model()->getDropDownlistDataProduct();
		$model->getSelectedCategories();
		
		//подготавливаем выпадающий список модельного ряда
		$model->DropDownListModels = ShopModelsAuto::model()->getDropDownlistDataProduct();
		$model->getSelectedModels();
		
		//подготавливаем выпадающий список модельного ряда для исключения на опред. моделях
		$model->DropDownListModelsDisabled = $model->DropDownListModels;
		$model->getSelectedModelsDisabled();
		
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

		//подготавливаем выпадающий список наличия товара
		$model->DropDownProductAvailability = ShopProducts::model()->getDropDownProductAvailability();
		$model->SelectedProductAvailabilityId = array();
		$model->SelectedProductAvailabilityId[$model->product_availability] = array('selected' => 'selected');
		
		//подготавливаем выпадающий список для стороны товара
		$model->DropDownProductSide = ShopProducts::model()->getDropDownProductSide();
		$model->SelectedProductSideId = array();
		$model->SelectedProductSideId[$model->side] = array('selected' => 'selected');
		
		//подготавливаем выпадающий список объемов двигателей
		$model->DropDownListEngines = Engines::model()->getDropDownlistEngines($model->SelectedModels);
		$model->getSelectedEngines();
		
		//echo'<pre>';print_r($model->SelectedCategories);echo'</pre>';
		if($model->product_price == 0) {
			foreach($model->SelectedCategories as $cat_id=>$i) {
				$model->currency_id = ShopCategories::model()->getCategoryCurrencyId($app->db, $cat_id);
				break;
			}
		}
			

		$this->render('update',array(
			'model'=>$model,
			'params'=>$app->params,
			'current_tab'=>$current_tab,
		));
	}
	
	public function actionCopy($id)
	{
		$app = Yii::app();
		$model = $this->loadModel($id);
		$model->copyProduct();
        $app->session['ShopproductForm.current_tab'] = '#tab1';
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
				ShopProductsImages::model()->deleteFoto($row['image_id'], $model->product_id);
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
        
        $model->AllModelslist = ShopModelsAuto::model()->getAllModelslist();
		
		if(isset($_GET['ShopProducts']))
			$model->attributes = $_GET['ShopProducts'];
		
		
		$app = Yii::app();
		
		//echo'<pre>';print_r($_POST,0);echo'</pre>';
		
		//если выбрали какую-то категорию - сохнаняем ее в сессию
		$selected_category = $app->request->getParam('selected_category', -1);
		
		//если выбрали какую-то модель авто - сохнаняем ее в сессию
		$selected_model = $app->request->getParam('selected_model', -1);
		
		//если выбрали какой-то двигатель - сохнаняем его в сессию
		$selected_engine = $app->request->getParam('selected_engine', -1);
		
		
		
		if($selected_category > -1)	{
			$app->session['ShopProducts.selected_category'] = (int)$selected_category;
			//$app->session['ShopModelsAuto.selected_model'] = 0;
		}
		
		if($selected_model > -1)	{
			$app->session['ShopModelsAuto.selected_model'] = (int)$selected_model;
			//$app->session['ShopProducts.selected_category'] = 0;
		}
		
		if($selected_engine > -1)	{
			$app->session['ShopProducts.selected_engine'] = (int)$selected_engine;
			//$app->session['ShopProducts.selected_category'] = 0;
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
		
		$EnginesDropDownlistData = CHtml::listData((Engines::model()->getEnginesInfo($SelectedModel)), 'id','name');
		if(count($EnginesDropDownlistData))
			$EnginesDropDownlistData = array(0=>'Все') + $EnginesDropDownlistData;
		
		$SelectedEngine = -1;
		if(isset($app->session['ShopProducts.selected_engine']))	{
			$SelectedEngine = (int)$app->session['ShopProducts.selected_engine'];
		}
		
		$model->SelectedEngine = $SelectedEngine;
		
		//echo'<pre>';print_r($SelectedEngine);echo'</pre>';//die;
		
		$this->render('admin',array(
			'model'=>$model,
			'DropDownCategories' => $ShopCategories->DropDownlistData,
			'SelectedCategory' => $SelectedCategory,
			'DropDownModels' => $ShopModelsAuto->DropDownlistData,
			'SelectedModel' => $SelectedModel,
			'EnginesDropDown' => $EnginesDropDownlistData,
		));
	}
	
	public function actionMoveup()
	{
		$app = Yii::app();
		
		$product_id = $app->request->getParam('id', 0);
		$category_id = $app->request->getParam('category', 0);
		$model_id = $app->request->getParam('model', 0);
		$engine_id = $app->request->getParam('engine', 0);
		
		$connection = $app->db;
		
		ProductsEngines::model()->movePosition($connection, 'up', $product_id, $category_id, $model_id, $engine_id);
		
		$this->redirect(array('admin'));
	}

	public function actionMovedown()
	{
		$app = Yii::app();
		
		$product_id = $app->request->getParam('id', 0);
		$category_id = $app->request->getParam('category', 0);
		$model_id = $app->request->getParam('model', 0);
		$engine_id = $app->request->getParam('engine', 0);
		
		$connection = $app->db;
		
		ProductsEngines::model()->movePosition($connection, 'down', $product_id, $category_id, $model_id, $engine_id);
		
		$this->redirect(array('admin'));
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
	
	public function actionPublishup($id)
	{
		$model = $this->loadModel($id);
		$model->published = 1;
		$model->save(false);
		$this->redirect(array('admin'));
	}
	
	public function actionPublishdown($id)
	{
		$model = $this->loadModel($id);
		$model->published = 0;
		$model->save(false);
		$this->redirect(array('admin'));
	}
	
	public function actionBatchdelete()
	{		
		$batchId = Yii::app()->request->getParam('batchId', array());
		foreach($batchId as $id) {
			
			$model = $this->loadModel($id);

			$Images = $model->Images;
			if(count($Images))	{
				foreach($Images as $row)	{
					ShopProductsImages::model()->deleteFoto($row['image_id'], $model->product_id);
				}
			}
			$model->delete();			
		}		
	}
	
	/**
	 * переименование картинок
	 * 1. получаем список товаров product_id, product_name, product_image, manufacturer_sku 3hnspc_shop_products
	 * 2. в цикле по каждой записи получаем ее изобажения image_id, image_file 3hnspc_shop_products_images
	 * 3. Проверяем, универсльный ли это товар
	 * 4. Если нет, то еще получаем первую модель, назначенную для этого товара
	 */
	public function actionImgrename()
	{
		$app = Yii::app();
		$connection = $app->db;
		
		$file_name_arr = Yii::getPathOfAlias('webroot').'/file_name_arr.json';
		//echo'<pre>';print_r(Yii::getPathOfAlias('webroot'));echo'</pre>';die;
		
		$start_at = $app->request->getParam('start_at', 0);
		$go = $app->request->getParam('go', '');
		

		/*
		$mytext = json_encode(array(
			'qwe'=>12,
			'sfwe'=>32,
		));
		*/
		if($start_at == 0) {
			$mytext = json_encode(array());		
			$fp = fopen($file_name_arr, "w"); // Открываем файл в режиме записи
			$test = fwrite($fp, $mytext); // Запись в файл
			fclose($fp); //Закрытие файла
		}
//		echo'<pre>';print_r(Yii::getPathOfAlias('webroot'));echo'</pre>';die;
		
		
		$file = file_get_contents($file_name_arr);
		$image_file_name_arr = json_decode($file, true);
		//echo'<pre>';print_r($image_file_name_arr);echo'</pre>';die;			
		
		
		$limit = 50;
		//$limit = 1000;
		
		//$sql = "SELECT product_id, product_name, product_image, manufacturer_sku, product_sku FROM {{shop_products}} WHERE product_id = 6180 ORDER BY product_id LIMIT $start_at, $limit";
		$sql = "SELECT product_id, product_name, product_image, manufacturer_sku, product_sku FROM {{shop_products}} ORDER BY product_id LIMIT $start_at, $limit";
		$command = $connection->createCommand($sql);
		$products = $command->queryAll();
		
		$start_at += $limit;
		echo'<pre>';print_r($sql);echo'</pre>';//die;
		//echo'<pre>';print_r($products);echo'</pre>';//die;
		
		
		foreach($products as $product) {
			//echo'<pre>';print_r($product);echo'</pre>';//die;
			$product_name = ShopProducts::model()->ToTranslitStr($product['product_name']);
			$product_name = str_replace('--', '-', $product_name);
			$product_name = str_replace('--', '-', $product_name);
			
			if($product['product_sku'] != '') $product_name .= '-'.ShopProducts::model()->ToTranslitStr($product['product_sku']);
			$product_name = str_replace('--', '-', $product_name);
			$product_name = str_replace('--', '-', $product_name);
			
			if($product['manufacturer_sku'] != '') $product_name .= '-'.ShopProducts::model()->ToTranslitStr($product['manufacturer_sku']);
			$product_name = str_replace('--', '-', $product_name);
			$product_name = str_replace('--', '-', $product_name);
			
			
			//echo'<pre>';print_r($product_name );echo'</pre>';//die;
			$model_name_arr = ShopProductsModelsAuto::model()->getModelsFullNamesFull($product['product_id']);
			
			if(count($model_name_arr)) {
				$model_name = ShopProducts::model()->ToTranslitStr($model_name_arr[0]['fullname']);
				$model_name = str_replace('--', '-', $model_name);
				$model_name = str_replace('--', '-', $model_name);
			}	else	{
				$model_name = '';
			}
				
			//echo'<pre>';print_r($model_name );echo'</pre>';//die;
			$sql = "SELECT image_id, image_file FROM {{shop_products_images}} WHERE product_id = " . $product['product_id'];
			$command = $connection->createCommand($sql);
			$product_images = $command->queryAll();
			//echo'<pre>';print_r($product_images);echo'</pre>';//die;
			
			$is_universal_products = ShopProductsModelsAuto::model()->isUniversalroduct($product['product_id']);
			if($is_universal_products) $model_name = 'uni';
			
			$img_num = 1;
				foreach($product_images as $img) {
					$file_extention = ShopProducts::model()->getExtentionFromFileName($img['image_file']);

					if($img['image_file'] == $product['product_image']) {
						$main_foto = 1;
						$image_file_name = $product_name . '-' . $model_name . $file_extention;
						if(isset($image_file_name_arr[$image_file_name])) {
							$x = 0;
							while (isset($image_file_name_arr[$image_file_name]))	{
								$x++; // Увеличение счетчика
								$image_file_name = $product_name . '-' . $x . '-' . $model_name . $file_extention;;
							}
						}	
						$image_file_name_arr[$image_file_name] = $product['product_id'];
						
						//echo'<pre>';print_r($image_file_name);echo'</pre>';//die;

						ShopProducts::model()->renameImg($app, $img['image_file'], $image_file_name);
						ShopProducts::model()->updateImg($connection, $img['image_id'], $image_file_name);
						ShopProducts::model()->updateMainImg($connection, $product['product_id'], $image_file_name);

					}	else	{
						$main_foto = 0;
						$image_file_name = $product_name . '-' . $model_name . '-' . $img_num . $file_extention;
						$img_num++;
						
						if(isset($image_file_name_arr[$image_file_name])) {
							$x = 0;
							while (isset($image_file_name_arr[$image_file_name]))	{
								$x++; // Увеличение счетчика
								$image_file_name = $product_name . '-' . $x . '-' . $model_name . $file_extention;;
							}
						}						
						$image_file_name_arr[$image_file_name] = $product['product_id'];
						
						//echo'<pre>';print_r($image_file_name);echo'</pre>';//die;
						
						ShopProducts::model()->renameImg($app, $img['image_file'], $image_file_name);
						//ShopProducts::model()->updateImg($connection, $img['image_id'], $image_file_name);
					}
				}
			
			$fp = fopen($file_name_arr, "w"); // Открываем файл в режиме записи
			$mytext = json_encode($image_file_name_arr);
			$test = fwrite($fp, $mytext); // Запись в файл
			fclose($fp); //Закрытие файла
			
			
			//echo'<pre>';print_r($file_extention);echo'</pre>';die;
			
			//$img_name = 
		}
		
		
		//die;
		echo'<pre>';print_r(count($products));echo'</pre>';
		
		
		//die;
		$this->renderPartial('img-rename',array(
			'start_at'=>$start_at,
			'limit'=>$limit,
			'count'=>count($products),
			'go'=>$go,
			'image_file_name_arr'=>$image_file_name_arr,
		));
		
				
		//$this->redirect(array('admin'));
	}

	public function actionSetuni()
	{
		$app = Yii::app();
		$connection = $app->db;

		$sql = "SELECT product_id FROM {{shop_products}} ORDER BY product_id";
		$command = $connection->createCommand($sql);
		$products = $command->queryAll();

		//echo'<pre>';print_r(count($products));echo'</pre>';
		//echo'<pre>';print_r(($products));echo'</pre>';die;


		$sql = 'UPDATE {{shop_products}} SET `is_uni` = 1 WHERE `product_id` = :product_id';
		$command = $connection->createCommand($sql);

		foreach($products as $product) {
			$is_uni = ShopProductsModelsAuto::model()->isUniversalroduct($product['product_id']);

			if($is_uni === true) {
				$command->bindParam(":product_id", $product['product_id']);
				$res = $command->execute();
			}
		}
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
}
