<?php

class ShopProductsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2l';
	public $show_models = false;

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
				'actions'=>array('index','view','detail','lastviewed','buyoneclick', 'delivery', 'sitemapcreate'),
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

	//метод загружает товар. $product = product_id
	public function actionDetail($product)
	{
		$app = Yii::app();
		$connection = $app->db;
		$url_params = UrlHelper::getUrlParams($app);	// это забирается из GET параметров
		UrlHelper::checkChangeAuto($app);

		//echo'<pre>';print_r($url_params);echo'</pre>';die;

		$selected_auto = UrlHelper::getSelectedAuto($app);	//это то что храниться в сессии
		
		if($url_params['marka'] != $selected_auto['marka'] || $url_params['model'] != $selected_auto['model'] || $url_params['year'] != $selected_auto['year']) {
			$app->session['autofilter.marka'] = $selected_auto['marka'] = $url_params['marka'];
			$app->session['autofilter.model'] = $selected_auto['model'] = $url_params['model'];
			$app->session['autofilter.year'] = $selected_auto['year'] = $url_params['year'];
			unset($app->session['autofilter.modelinfo']);
		}
		
		//$model = $this->loadModelbySlug($slug);
		$model = $this->loadModel($product);
		
		//получаем сопутствующие товары
        $RelatedDataProvider = ShopProductsRelations::model()->getRelatedProducts($product);
		
		$finded_product_ids = ShopProducts::model()->getProductIds($RelatedDataProvider->data);
		
		$firms = ShopFirms::model()->getFirmsForProductList($connection, $finded_product_ids);
		
		foreach($RelatedDataProvider->data as $row)	{
			$is_universal_product = ShopProductsModelsAuto::model()->isUniversalroduct($row->product_id);
			if($is_universal_products == 1) {
				$prod_params = array(
					'uni' => 'uni',
					'product'=> $row->product_id
				);					
			}	else	{
				$prod_params = array(
					'marka' => $url_params['marka'],
					'model' => $url_params['model'],
					'year' => $url_params['year'],
					'year' => $url_params['year'],
					'product'=> $row->product_id
				);
			}
			
			$row->product_url = $this->createUrl('shopproducts/detail', $prod_params);
			$row->product_image = $app->params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.jpg');
			$row->firm_name = $firms[$row->firm_id]['name'];
		}
		
		//$breadcrumbs = $this->createBreadcrumbs($category_path, $model);
		$breadcrumbs = array($model->product_name);
		
		// сохраняем в сессию, что мы смотрели данный товар
		$shopProductsIds = isset($app->session['shopProducts.ids']) ? $app->session['shopProducts.ids'] : array() ;
		if(is_null($url_params['marka']) && is_null($url_params['model']) && is_null($url_params['year'])) $is_uni = 1;
			else $is_uni = 0;
		
		$last_viewed_item = array(
			'id' => $model->product_id,
			'marka' => $url_params['marka'],
			'model' => $url_params['model'],
			'year' => $url_params['year'],
			'uni' => $is_uni,
		);
		
		foreach($shopProductsIds as $k=>$i) {
			if($i['id'] == $model->product_id) unset($shopProductsIds[$k]);
		}
		
		array_unshift($shopProductsIds, $last_viewed_item);
		
		if(count($shopProductsIds) > $app->params['count_last_viewed_in_page'])
			unset($shopProductsIds[$app->params['count_last_viewed_in_page']]);
		
		$app->session['shopProducts.ids'] = $shopProductsIds;
		
		$currency_info = Currencies::model()->loadCurrenciesList();
		
		$modelinfoTxt = $this->buildModelInfo($app, $connection, $url_params);
		
		if($model->prepayment != 'без предоплаты')	{
			$prepayment_text = Pages::model()->getPageText($app->params['prepayment_text_id']);
		}	else	{
			$prepayment_text = '';
		}
		
		$free_delivery_limit = Delivery::model()->getFreeDeliveryLimit();
		
		$installation_page = Pages::model()->getPageText($app->params['installation_page']);
		
		$model_pages_cat = PagesCategories::model()->findByPk($app->params['cat_our_id']);
		$ourWorkDataProvider = Pages::model()->loadPages($app->params['cat_our_id']);

		$delivery_list = Delivery::model()->loadCalculatedDeliveryList(array($model), $currency_info, true);

		$model->setMetaInfo($modelinfoTxt);
		
		$this->render('view',array(
			'model'=>$model,
			'RelatedDataProvider'=>$RelatedDataProvider,
			'breadcrumbs' => $breadcrumbs,
			'currency_info' => $currency_info,
			'modelinfoTxt' => $modelinfoTxt,
			'prepayment_text' => $prepayment_text,
			'free_delivery_limit' => $free_delivery_limit,
			'installation_page' => $installation_page,
			'ourWorkDataProvider' => $ourWorkDataProvider,
			'url_path' => $model_pages_cat->alias,
			'delivery_list'=>$delivery_list,
		));
		
	}
	
	/**
	 * метод загружает последние просмотренные товары
	 */
	public function actionLastviewed()
	{
		$app = Yii::app();
		$connection = $app->db;

		$shopProductsIds = isset($app->session['shopProducts.ids']) ? $app->session['shopProducts.ids'] : array() ;
		
		$shopProductsIds_m = array();
		
		if(!count($shopProductsIds))	{
			$product_ids = array(0);
		}	else	{
			foreach($shopProductsIds as $i) {
				$product_ids[] = $i['id'];
				$shopProductsIds_m[$i['id']] = $i;
			}
		}
		
		$criteria = new CDbCriteria();
		$criteria->select = "t.*";
		$criteria->condition = 'product_id IN ('.implode(',', $product_ids).')';
		$criteria->order = 'FIELD(product_id, '.implode(',', $product_ids).')';
		
        $dataProvider = new CActiveDataProvider('ShopProducts', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$app->params['count_last_viewed_in_page'],
				'pageVar' =>'page',
            ),
        ));
		
		$finded_product_ids = ShopProducts::model()->getProductIds($dataProvider->data);

		$firms = ShopFirms::model()->getFirmsForProductList($connection, $finded_product_ids);
		
		$selected_auto = UrlHelper::getSelectedAuto($app);	//это то что храниться в сессии
		//echo'<pre>';print_r($selected_auto);echo'</pre>';//die;
		if($selected_auto['marka'] > 0 && $selected_auto['model'] > 0 && $selected_auto['year'] > 0 && $selected_auto['engine'] > 0) {
			//если фильруем по какой-то модели - то получаем ИД этих моделей
			$model_ids = ShopModelsAuto::model()->getModelIds($app, $selected_auto);
		}	else	{
			$model_ids = array();
		}
		//echo'<pre>';print_r($model_ids);echo'</pre>';die;
		if(count($model_ids)) {
			if(count($model_ids) == 2 && $model_ids[1] == $app->params['universal_products'])	{
				$this->show_models = false;
			}	else	{
				$this->show_models = true;
			}
		}	else	{
			$this->show_models = false;
		}
		
		
		foreach($dataProvider->data as $row)	{
			if($shopProductsIds_m[$model->product_id]['uni'] == 1) {
				$prod_params = array(
					'uni' => 'uni',
					'product'=> $row->product_id,
				);					
			}	else	{
				$prod_params = array(
					'marka' => $shopProductsIds_m[$row->product_id]['marka'],
					'model' => $shopProductsIds_m[$row->product_id]['model'],
					'year' => $shopProductsIds_m[$row->product_id]['year'],
					'year' => $shopProductsIds_m[$row->product_id]['year'],
					'product'=> $row->product_id,
				);
			}
			
			$row->product_url = $this->createUrl('shopproducts/detail', $prod_params);
			$row->product_image = $app->params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.jpg');
			$row->firm_name = $firms[$row->firm_id]['name'];
		}
		
		$data = array(
			'dataProvider' => $dataProvider,
		);
		
		$this->render('lastViewed', $data);
	}

	
	public function actionBuyoneclick()
	{
		echo 'ok';
	}
	
	public function actionDelivery($id)
	{
		$app = Yii::app();
		$connection = $app->db;
		$model = $this->loadModel($id);
		$currency_info = Currencies::model()->loadCurrenciesList();
		$delivery_list = Delivery::model()->loadCalculatedDeliveryList(array($model), $currency_info, true);
		$modelinfoTxt = $this->buildModelInfo($app, $connection, $url_params);
		
		$this->renderPartial('delivery',array(
			'app'=>$app,
			'model'=>$model,
			'delivery_list'=>$delivery_list,
			'modelinfoTxt' => $modelinfoTxt,
			'currency_info' => $currency_info,
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
			throw new CHttpException(404,'Запрашиваемая страница не найдена.');
		return $model;
	}
	
	public function loadModelbySlug($slug)
	{
		$model = ShopProducts::model()->findBySlug($slug);
		if($model===null)
			throw new CHttpException(404,'Запрашиваемая страница не найдена.');
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
	
	//метод собирает хлебную крошку
	public function createBreadcrumbs($path, $model)
	{
		$category = ShopCategories::model()->findByPath($path);
		$ancestors = $category->ancestors()->findAll();
		unset($ancestors[0]);	//удаляем из масива главную категорию "Автомобили".
		$breadcrumb = array();
		foreach($ancestors as $row)	{
			$breadcrumb[$row->name] = array('/shopcategories/show/', 'id'=>$row->id);
			
		}
		$breadcrumb[$category->name] = array('/shopcategories/show/', 'id'=>$category->id);;
		$breadcrumb[] = $model->product_name;
		return $breadcrumb;
	}
	
	/**
	 * строит модельный ряд
	 * @return string
	 */
	private function buildModelInfo(&$app, &$connection, $url_params)
	{
		if(isset($url_params['marka']) && isset($url_params['model']) && isset($url_params['year'])) {
			$select_marka = $url_params['marka'] ? $url_params['marka'] : -1;
			$select_model = $url_params['model'] ? $url_params['model'] : -1;
			$select_year = $url_params['year'] ? $url_params['year'] : -1;

			if($select_marka != -1 && $select_model != -1 && $select_year != -1) {
				$modelinfo = ShopModelsAuto::model()->getModelInfo($connection, $select_marka, $select_model, $select_year);
			}	else	{
				$modelinfo = array();
			}
			
		}	elseif(isset($app->session['autofilter.modelinfo']))	{
			$modelinfo = json_decode($app->session['autofilter.modelinfo'], 1);
		}	else	{
			$modelinfo = array();
		}
		
		$modelinfoTxt = '';
		
		if(count($modelinfo)) {
			$modelinfoTxt .= ' для';
			foreach($modelinfo as $k=>$i) {
				if(isset($modelinfo[$k+1])) {
					//бывает что часть названия попадает в двух частях, поэтому отлавливаем этот момент
					$findme = $i['name'];
					$mystring = $modelinfo[$k+1]['name'];
					$pos = strpos($mystring, $findme);
					if ($pos === false) $modelinfoTxt .= ' ' . $i['name'];
				}	else	{
					$modelinfoTxt .= ' ' . $i['name'];
				}
			}
			
		}
		return $modelinfoTxt;
	}
	
    protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }	

}
