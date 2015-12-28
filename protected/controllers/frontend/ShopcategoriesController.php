<?php

class ShopCategoriesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2l';
	public $product_images_liveUrl ='';
	public $show_models = true;
	
	public $CQtreeGreedView  = array (
		'modelClassName' => 'page2', //название класса
		'adminAction' => 'admin' //action, где выводится QTreeGridView. Сюда будет идти редирект с других действий.
	);
	
    public function actions() {
        return array (
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
				'actions'=>array('admin','delete','movecategories','updatepath','updatemeta','updatemeta1', 'updateshowinmenu'),
				'users'=>array('superman'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionShow($id)
	{
		$app = Yii::app();
		$connection = $app->db;
		
		$url_params = UrlHelper::getUrlParams($app);	// это забирается из GET параметров
		$selected_auto = UrlHelper::getSelectedAuto($app);	//это то что храниться в сессии
		
		if($url_params['marka'] != $selected_auto['marka'] || $url_params['model'] != $selected_auto['model'] || $url_params['year'] != $selected_auto['year']) {
			$app->session['autofilter.marka'] = $selected_auto['marka'] = $url_params['marka'];
			$app->session['autofilter.model'] = $selected_auto['model'] = $url_params['model'];
			$app->session['autofilter.year'] = $selected_auto['year'] = $url_params['year'];
			unset($app->session['autofilter.modelinfo']);
		}
		
		//если мы в выхлопной системе кликнули на кузов то устанавливаем 
		//это значение в сессию и редиректим на просмотр глушителей
		$bodyset = (int) $app->request->getParam('bodyset', -1);
		//echo'<pre>';print_r($bodyset);echo'</pre>';die;
		if($bodyset > -1) {
			$app->session['autofilter.year'] = $bodyset;
			$selected_auto['year'] = $bodyset;
			//echo'<pre>';print_r($selected_auto);echo'</pre>';die;			
			$url_params_ = UrlHelper::buildUrlParams($selected_auto, $url_params['id']);
			$url = $url_params_[0];
			unset($url_params_[0]);
			
			//echo'<pre>';print_r($url_params_);echo'</pre>';die;
			$this->redirect($this->createUrl($url, $url_params_));
		}
		
		
		$this->processPageRequest('page');
		
		//echo'<pre>';print_r($_GET);echo'</pre>';//die;
		
		$selected_view = $app->request->getParam('select-view', -1);
		
		$type_request = (int)$app->request->getParam('type', 0);
		$firm_request = (int)$app->request->getParam('firm', 0);
		$body_request = (int)$app->request->getParam('body', 0);
		$engine_id = (int)$app->request->getParam('engine', 0);
		
		$engineImage = null;
		$engineTitle = null;
		
		if($selected_view != -1)	{
			$app->session['Shopcategories.selected_view'] = $selected_view;
			$url_params = array('id'=>$id);
			if($body_request != 0) $url_params['body'] = $body_request;
			if($type_request != 0) $url_params['type'] = $type_request;
			if($firm_request != 0) $url_params['firm'] = $firm_request;
			$this->redirect($this->createUrl('show', $url_params));
		}	else	{
			if(isset($app->session['Shopcategories.selected_view']))	{
				$selected_view = $app->session['Shopcategories.selected_view'];
			}	else	{
				$selected_view = 'row';
			}
		}
		
		$category = ShopCategories::model()->findByPk($id);
		$descendants = $category->children()->findAll(array('order'=>'ordering'));
		
		if(isset($app->session['autofilter.modelinfo']))	{
			$modelinfo = json_decode($app->session['autofilter.modelinfo'], 1);
		}	else	{

			$select_marka = $url_params['marka'] ? $url_params['marka'] : -1;
			$select_model = $url_params['model'] ? $url_params['model'] : -1;
			$select_year = $url_params['year'] ? $url_params['year'] : -1;

			if($select_marka != -1 && $select_model != -1 && $select_year != -1)
					$modelinfo = ShopModelsAuto::model()->getModelInfo($connection, $select_marka, $select_model, $select_year);
				else $modelinfo = array();
		}

		if(count($modelinfo)) {
			if($category->name1 != '') $category->name = $category->name1;
			if(count($modelinfo))	$category->name .= ' для';
			foreach($modelinfo as $k=>$i) {
				if(isset($modelinfo[$k+1])) {
					//бывает что часть названия попадает в двух частях, поэтому отлавливаем этот момент
					$findme = $i['name'];
					$mystring = $modelinfo[$k+1]['name'];
					$pos = strpos($mystring, $findme);
					if ($pos === false) {
						$category->name .= ' ' . $i['name'];
					}
				}	else	{
					$category->name .= ' ' . $i['name'];
				}
			}
		}
				
		//если фильруем по какой-то модели - то получаем ИД этих моделей
		$model_ids = ShopModelsAuto::model()->getModelIds($app, $selected_auto);
		
		$currency_info = Currencies::model()->loadCurrenciesList();
		
		$criteria = new CDbCriteria();
		$criteria->select = "t.product_id";
		$criteria->join = 'INNER JOIN {{shop_products_categories}} AS pc USING (`product_id`) ';
		
		$condition_arr = array();
		$condition_arr[] = "pc.`category_id` = ".$category->id;
		
		if(count($model_ids))	{
			if($engine_id != 0) $product_ids = ProductsEngines::model()->getProductIdFromEngines($connection, array($engine_id), $model_ids);
				else $product_ids = ShopProductsModelsAuto::model()->getProductIdFromModels($connection, $model_ids);
			
			$product_ids = ProductsModelsDisabled::model()->checkForExcludedProducts($connection, $product_ids, $model_ids);
				
			if(count($product_ids))
				$condition_arr[] = "t.`product_id` IN (".implode(', ', $product_ids).")";
		}
		
		$criteria->condition = implode(' AND ', $condition_arr);
		$criteria->order = $app->params->products_list_order;
		
		//получаем сначала все позиции для получения их id без учета пагинации
		$rows = ShopProducts::model()->findAll($criteria);
		$finded_product_ids = ShopProducts::model()->getProductIds($rows);
		
		if($type_request != 0)	{
			$condition_arr[] = "t.type_id = ".$type_request;
		}
		
		if($firm_request != 0)	{
			$condition_arr[] = "t.firm_id = ".$firm_request;
		}
		
		if($body_request != 0)	{
			$criteria->join .= ' INNER JOIN {{shop_products_bodies}} AS pb USING (`product_id`) ';
			$condition_arr[] = "pb.body_id = ".$body_request;
		}
		
		$criteria->condition = implode(' AND ', $condition_arr);
				
		$criteria->select = "t.*";
		
		if($engine_id != 0) {
			$criteria->join .= ' INNER JOIN {{shop_products_engines}} as eng ON t.product_id = eng.product_id';
			$criteria->distinct = true;
			
			$criteria->order = 'eng.ordering ASC, eng.product_id ASC'; // устанавливаем сортировку по умолчанию
			$criteria->addCondition("eng.model_id IN (".implode(',', $model_ids).") AND eng.engine_id = $engine_id");
			
			$engineImage = Engines::model()->getEngineImage($connection, $engine_id);
			$engineTitle = EnginesModels::model()->getEngineTitle($connection, $engine_id, $model_ids);
		}
		
        $dataProvider = new CActiveDataProvider('ShopProducts', array(
            'criteria'=>$criteria,
            'pagination'=>array(
				'pageSize'=>$app->params->pagination['products_per_page'],
				//'pageSize'=>120,
				'pageVar' =>'page',
            ),
        ));
		
		if(count($descendants))	{
			ShopCategories::model()->getCategoriesMedias($descendants);
		}
		
		if(count($finded_product_ids))	{
			//загрузить группы товаров
			$producttypes = ShopProductTypes::model()->getProductTypesForProductList($connection, $finded_product_ids, $get_null = true);
			//загрузить фирмы
			$firms = ShopFirms::model()->getFirmsForProductList($connection, $finded_product_ids);
			
			$bodies = ShopBodies::model()->getBodiesForProductList($connection, $finded_product_ids, $model_ids);
		}	else	{
			$firms = array();
			$producttypes = array();
			$bodies = array();
		}
		
		if(count($dataProvider->data))	{
			$product_ids = array();
			
			$modelIds = array();
			foreach($model_ids as $id)
				if($id != $select_year && $id != $app->params['universal_products'])
					$modelIds[] = $id;
			
			foreach($dataProvider->data as $row)	{
				$product_ids[] = $row->product_id;
				$row->product_url = $this->createUrl('shopproducts/detail', array('product'=> $row->product_id));
				$row->product_image = $app->params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.jpg');
				$row->firm_name = $firms[$row->firm_id]['name'];
				$row->model_ids = $modelIds;
				
				$product_price = PriceHelper::formatPrice($row->product_price, $row->currency_id, 3, $currency_info, true, true);
				if($product_price >= $app->params['free_delivery_limit']) $row->free_delivery = 1;
				
				$row->model_ids = $modelIds;
			}
			
			//получаем массив доп. изображений для списка товаров
			$ProductsImages = ShopProductsImages::model()->getFotoForProductList($connection, $product_ids);
			
			if(count($ProductsImages))	{
				foreach($ProductsImages as $Image)	{
					foreach($dataProvider->data as $row)	{
						if($Image['product_id'] == $row->product_id)	{
							$row->AdditionalImages[] = array('image_file'=>$Image['image_file'], 'image_id'=>$Image['image_id']);
						}						
					}
				}
			}
		}	else	{
			//echo'<pre>';print_r($type_request);echo'</pre>';die;
			if($type_request != 0)
				$this->redirect($this->createUrl('shopcategories/index'));
			
			
			if(isset($url_params['marka']) || isset($url_params['model']) || isset($url_params['year']) || isset($url_params['type']) || isset($url_params['engine'])) {
				/*
				$url_params_ = UrlHelper::buildUrlParams($selected_auto, $url_params['id']);


				$url = $url_params_[0];
				unset($url_params_[0]);

				//echo'<pre>';print_r($url);echo'</pre>';//die;
				//echo'<pre>';print_r($url_params);echo'</pre>';//die;
				//echo'<pre>';print_r($url_params_);echo'</pre>';die;

				$this->redirect($this->createUrl($url, $url_params_));
				*/
				$this->redirect($this->createUrl('shopcategories/index'));				
			}
			
			$ProductsImages = array();
		}
		
		//echo'$model_ids<pre>';print_r(($model_ids));echo'</pre>';
		//echo'$model_ids<pre>';print_r(($select_year));echo'</pre>';
		//echo'$model_ids<pre>';print_r(count($model_ids));echo'</pre>';
		
		
		$breadcrumbs = $this->createBreadcrumbs($category);
		
		if(count($model_ids))	{
			if(count($model_ids) == 2 && $model_ids[1] == 1247)	{
				$this->show_models = false;
			}	else	{
				$this->show_models = true;
			}

		}	else	{
			$firms = array();
			$bodies = array();
			//$show_models = true;
			$this->show_models = false;
		}
		//echo'<pre>';var_dump($this->show_models);echo'</pre>';
		if(count($firms))	{
			$firmsArr = array();
			foreach($firms as $f) $firmsArr[$f['id']] = $f['name'];
			$firmsDropDown = CHtml::listData($firms, 'id','name');
			//$firmsDropDown = CHtml::listData($firmsArr, 'id','name');
		}
		//echo'<pre>';print_r($firmsDropDown);echo'</pre>';
		if($selected_view == 'row')	{
			$itemView = "_view-row";
		}	else	{
			$itemView = "_view";
		}
		
		// если не выбрана марка модель год то выводим уведомление
		if($select_marka != -1 && $select_model != -1 && $select_year != -1) $show_search_notice = false;
			else $show_search_notice = true;
		
		
		/*
        if ($app->request->isAjaxRequest){
            $this->renderPartial('_loopAjax', array(
				//'app'=> $app,
                'dataProvider'=>$dataProvider,
                'itemView'=>$itemView,
				'currency_info' => $currency_info,
            ));
            $app->end();
        } else {
			$data = array(
				'app'=> $app,
				'dataProvider'=> $dataProvider,
				'itemView'=>$itemView,				
				'type_request'=> $type_request,
				'firm_request'=> $firm_request,
				'body_request'=> $body_request,
				'category_id'=> $category_id,
				'selected_view'=> $selected_view,
				'category'=> $category,
				'descendants'=> $descendants,
				'ProductsImages'=> $ProductsImages,
				'breadcrumbs' => $breadcrumbs,
				'producttypes' => $producttypes,
				'bodies' => $bodies,
				'firms' => $firms,
				'productsTotal' => count($finded_product_ids),
				'firmsDropDown' => $firmsDropDown,
				'engineImage' => $engineImage,
				'engineTitle' => $engineTitle,
				'show_search_notice' => $show_search_notice,
				'currency_info' => $currency_info,
			);

			$this->render('show', $data);
        }
		*/
		
		$data = array(
			'app'=> $app,
			'dataProvider'=> $dataProvider,
			'itemView'=>$itemView,				
			'type_request'=> $type_request,
			'firm_request'=> $firm_request,
			'body_request'=> $body_request,
			'category_id'=> $category_id,
			'selected_view'=> $selected_view,
			'category'=> $category,
			'descendants'=> $descendants,
			'ProductsImages'=> $ProductsImages,
			'breadcrumbs' => $breadcrumbs,
			'producttypes' => $producttypes,
			'bodies' => $bodies,
			'firms' => $firms,
			'productsTotal' => count($finded_product_ids),
			'firmsDropDown' => $firmsDropDown,
			'engineImage' => $engineImage,
			'engineTitle' => $engineTitle,
			'show_search_notice' => $show_search_notice,
			'currency_info' => $currency_info,
		);
		/*
		if ($app->request->isAjaxRequest){
			$this->renderPartial('show', $data);
			$app->end();
		}	else	{
			$this->render('show', $data);
		}
		*/
		$this->render('show', $data);
		
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$app = Yii::app();
		$connection = $app->db;
		
		$this->processPageRequest('page');
		
		$selected_view = $app->request->getParam('select-view', -1);
		$type_request = (int)$app->request->getParam('type', 0);
		
		if($selected_view != -1)	{
			$app->session['Shopcategories.selected_view'] = $selected_view;
			$this->redirect(array('index'));
		}	else	{
			if(isset($app->session['Shopcategories.selected_view']))	{
				$selected_view = $app->session['Shopcategories.selected_view'];
			}	else	{
				$selected_view = 'row';
			}
		}
		
		$type_request = (int)$app->request->getParam('type', 0);
		$firm_request = (int)$app->request->getParam('firm', 0);
		$body_request = (int)$app->request->getParam('body', 0);
		
		$select_marka = isset($app->session['autofilter.marka']) ? $app->session['autofilter.marka'] : -1;
		$select_model = isset($app->session['autofilter.model']) ? $app->session['autofilter.model'] : -1;
		$select_year = isset($app->session['autofilter.year']) ? $app->session['autofilter.year'] : -1;

		$model_info = ShopModelsAuto::model()->getModelInfo($connection, $select_marka, $select_model, $select_year);
		//echo'<pre>';print_r($model_info,0);echo'</pre>';
		
		
		//$category = ShopCategories::model()->findByPk($id);
		//$descendants = $category->children()->findAll(array('order'=>'ordering'));
		
		//если фильруем по какой-то модели - то получаем ИД этих моделей
		$model_ids = ShopModelsAuto::model()->getModelIds($app);
		//echo'$model_ids<pre>';print_r($model_ids,0);echo'</pre>';
		
		$criteria = new CDbCriteria();
		$criteria->select = "t.product_id";
		
		$condition_arr = array();		
		
		if(count($model_ids))	{
			$product_ids = ShopProductsModelsAuto::model()->getProductIdFromModels($connection, $model_ids);
			if(count($product_ids))	{
				$condition_arr[] = "t.`product_id` IN (".implode(',', $product_ids).")";
			}
		}
		
		$criteria->condition = implode(' AND ', $condition_arr);
		
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		
		//получаем сначала все позиции для получения их id без учета пагинации
		//$rows = ShopProducts::model()->findAll($criteria);
		//$finded_product_ids = ShopProducts::model()->getProductIds($rows);
		if(count($product_ids))	{
			$finded_product_ids = $product_ids;
		}	else	{
			$rows = ShopProducts::model()->findAll($criteria);
			$finded_product_ids = ShopProducts::model()->getProductIds($rows);			
		}
		
		//echo'<pre>';print_r($product_ids,0);echo'</pre>';
		//echo'<pre>';print_r($finded_product_ids,0);echo'</pre>';
		
		$criteria->select = "t.*";
		
		if($type_request != 0)	{
			$condition_arr[] = "t.type_id = ".$type_request;
		}
				
		$criteria->condition = implode(' AND ', $condition_arr);
		
		//$criteria->order = "t.`product_id`";
		$criteria->order = $app->params->products_list_order;
		
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		
        $dataProvider = new CActiveDataProvider('ShopProducts', array(
            'criteria'=>$criteria,
            'pagination'=>array(
               	'pageSize'=>$app->params->pagination['products_per_page'],
				'pageVar' =>'page',
            ),
        ));
		
		//$finded_product_ids = ShopProducts::model()->getProductIds($dataProvider->data);
		
		if(count($finded_product_ids))	{
			//загрузить группы товаров
			//$producttypes = ShopProductTypes::model()->getProductTypesForProductList($connection, $product_ids, $get_null = true);
			//загрузить фирмы
			$firms = ShopFirms::model()->getFirmsForProductList($connection, $finded_product_ids);
			
			//$bodies = ShopBodies::model()->getBodiesForProductList($connection, $finded_product_ids, $model_ids);
		}	else	{
			$firms = array();
			//$producttypes = array();
			//$bodies = array();
		}
		
		
		//echo'<pre>';print_r($finded_product_ids);echo'</pre>';
		//echo'<pre>';print_r($firms);echo'</pre>';
		if(count($dataProvider->data))	{
			$product_ids = array();
			
			$modelIds = array();
			foreach($model_ids as $id)
				if($id != $select_year && $id != $app->params['universal_products'])
					$modelIds[] = $id;
			
			foreach($dataProvider->data as $row)	{
				$product_ids[] = $row->product_id;
				$row->product_url = $this->createUrl('shopproducts/detail', array('product'=> $row->product_id));
				$row->product_image = $app->params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.jpg');
				$row->firm_name = $firms[$row->firm_id]['name'];
				//$row->product_availability_str = $firms[$row->firm_id]['name'];
				$row->model_ids = $modelIds;				
			}
			
			//получаем массив доп. изображений для списка товаров
			$ProductsImages = ShopProductsImages::model()->getFotoForProductList($connection, $product_ids);
			
			if(count($ProductsImages))	{
				foreach($ProductsImages as $Image)	{
					foreach($dataProvider->data as $row)	{
						if($Image['product_id'] == $row->product_id)	{
							$row->AdditionalImages[] = $Image['image_file'];
						}
					}
				}
			}
		}	else	{
			$ProductsImages = array();
		}
		
		//echo'<pre>';print_r(count($finded_product_ids));echo'</pre>';
		//echo'<pre>';print_r($model_info);echo'</pre>';die;
		$title = 'Список товаров';
		if(count($model_info))	$title .= ' для';
		foreach($model_info as $k=>$i) {
			if(isset($model_info[$k+1])) {
				//бывает что часть названия попадает в двух частях, поэтому отлавливаем этот момент
				$findme = $i['name'];
				$mystring = $model_info[$k+1]['name'];
				$pos = strpos($mystring, $findme);
				if ($pos === false) {
					$title .= ' ' . $i['name'];
				}
			}	else	{
				$title .= ' ' . $i['name'];
			}
		}
			
		$breadcrumbs = array(
			$title,
		);
		
		if(count($model_ids))	{
			if(count($model_ids) == 2 && $model_ids[1] == 1247)	{
				$this->show_models = false;
			}	else	{
				$this->show_models = true;
			}

		}	else	{
			$firms = array();
			$bodies = array();
			$show_models = true;
		}
		
		if($selected_view == 'row')	{
			$itemView = "_view-row";
		}	else	{
			$itemView = "_view";
		}
		
		// если выбрана марка модель год то выводим уведомление
		if($select_marka != -1 && $select_model != -1 && $select_year != -1) $show_search_notice = true;
			else $show_search_notice = false;
		
		
        if ($app->request->isAjaxRequest){
            $this->renderPartial('_loopAjax', array(
                'dataProvider'=>$dataProvider,
                'itemView'=>$itemView,
            ));
            $app->end();
        } else {
			$data = array(
				'app'=> $app,
				'dataProvider'=> $dataProvider,
				'itemView'=>$itemView,				
				'selected_view'=> $selected_view,
				'breadcrumbs' => $breadcrumbs,
				'title' => $title,
				//'producttypes' => $producttypes,
				'productsTotal' => count($finded_product_ids),
				'show_search_notice' => $show_search_notice,
			);

			$this->render('index', $data);
        }		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ShopCategories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopCategories']))
			$model->attributes=$_GET['ShopCategories'];

		$this->render('admin',array(
			'model'=>$model,
		));
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
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
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
	
	//метод собирает хлебную крошку
	public function createBreadcrumbs($category)
	{
		$ancestors = $category->ancestors()->findAll();
		unset($ancestors[0]);	//удаляем из масива главную категорию "Автомобили".
		$breadcrumb = array();
		foreach($ancestors as $row)	{
			$breadcrumb[$row->name] = array('/shopcategories/show/', 'id'=>$row->id);
			
		}
		$breadcrumb[] = $category->name;
		return $breadcrumb;
	}
	
    protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }
	
}
