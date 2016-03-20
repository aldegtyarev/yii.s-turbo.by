<?php

class UrlHelper
{
    public static function getUrlParams(&$app)
    {
		$params = array(
			'id' => $app->request->getParam('id', null),
			'marka' => $app->request->getParam('marka', null),
			'model' => $app->request->getParam('model', null),
			'year' => $app->request->getParam('year', null),
			'type' => $app->request->getParam('type', null),
			'engine' => $app->request->getParam('engine', null),
			
			'current_action' => $app->getController()->getAction()->getId(),
			'current_controller' =>  $app->getController()->getId(),
			
		);
		
		return $params;
    }
	
    /**
	 *	получает из сесси выбранную модель авто
	 */
	public static function getSelectedAuto(&$app)
	{
		$params = array(
			'marka' => isset($app->session['autofilter.marka']) ? $app->session['autofilter.marka'] : -1,
			'model' => isset($app->session['autofilter.model']) ? $app->session['autofilter.model'] : -1,
			'year' => isset($app->session['autofilter.year']) ? $app->session['autofilter.year'] : -1,
			'engine' => isset($app->session['autofilter.engine']) ? $app->session['autofilter.engine'] : -1,
			
		);
		
		if($params['marka'] == -1 || $params['model'] == -1 || $params['year'] == -1) {
			$url_parms = self::getUrlParams($app);
			if(!is_null($url_parms['marka'])) $params['marka'] = $url_parms['marka'];
			if(!is_null($url_parms['model'])) $params['model'] = $url_parms['model'];
			if(!is_null($url_parms['year'])) $params['year'] = $url_parms['year'];
		}
		
		return $params;
	}
	
    /**
	 *	собирает параметры для урла на основании текущего выбранного авто, категории и т.п.
	 */
	public static function buildUrlParams($input_params, $cat_id = 0, $category_is_universal = 0)
	{
		
		if($cat_id != 0) {
			$url_params = array(
				'shopcategories/show',
				'id'=>$cat_id,						
			);
		}	else	{
			$url_params = array(
				'shopcategories/index',
			);
		}
		
		if($category_is_universal == 0) {
			if($input_params['marka'] > -1) $url_params['marka'] = $input_params['marka'];
			if($input_params['model'] > -1) $url_params['model'] = $input_params['model'];
			if($input_params['year'] > -1) $url_params['year'] = $input_params['year'];
			if($input_params['engine'] > -1) $url_params['engine'] = $input_params['engine'];
			if($input_params['bodyset'] > -1) $url_params['bodyset'] = $input_params['bodyset'];
			if($input_params['type'] > -1) $url_params['type'] = $input_params['type'];
		}
		
		return $url_params;
	}
	
    /**
	 *	собирает параметры для урла на основании текущего выбранного авто, категории и т.п.
	 */
	public static function checkChangeAuto(&$app)
	{
		$url_params = self::getUrlParams($app);	// это забирается из GET параметров
		$do_redirect = false;
		$autoChanged = false;
		
		$select_marka = $app->request->getParam('select-marka', null);
		$select_model = $app->request->getParam('select-model', null);
		$select_year = $app->request->getParam('select-year', null);
		$clear_search_auto = $app->request->getParam('clear-search-auto', 0);
		$return_url = $app->request->getParam('return', '');
		
		if($clear_search_auto) {
			unset($app->session['autofilter.marka']);
			unset($app->session['autofilter.model']);
			unset($app->session['autofilter.year']);
			unset($app->session['autofilter.modelinfo']);
			
			$do_redirect = true;
			$return_url = '/';
		}	else	{
			if(!is_null($select_marka) && !is_null($select_model) && !is_null($select_year)) $autoChanged = true;
				else $autoChanged = false;
		}
				
		if($autoChanged === true) {
			$do_redirect = true;
			
			$app->session['autofilter.marka'] = $selected_auto['marka'] = $select_marka;
			$app->session['autofilter.model'] = $selected_auto['model'] = $select_model;
			$app->session['autofilter.year'] = $selected_auto['year'] = $select_year;
			
			unset($app->session['autofilter.modelinfo']);
			
			$selected_auto = array(
				'marka' => $select_marka,
				'model' => $select_model,
				'year' => $select_year,
				'engine' => $app->request->getParam('engine', -1),
				'type' => $app->request->getParam('type', -1),
			);
			
			if(!is_null($url_params['id'])) {
				$url_params = self::buildUrlParams($selected_auto, $url_params['id']);
				$url = $url_params[0];
				unset($url_params[0]);
				$return_url = $app->getController()->createUrl($url, $url_params);
			}	else	{
				$return_url = self::getReturnUrlForNewAuto($app, $selected_auto);
			}
		}
		
		if($do_redirect) {
			if ($app->request->isAjaxRequest){
				echo $return_url;
				$app->end();
			}
			
			if($return_url != '') $app->getController()->redirect($return_url);
		}
	}
	
	public static function getReturnUrlForNewAuto(&$app, $selected_auto)
	{
		$return_url = '';
		//если фильруем по какой-то модели - то получаем ИД этих моделей
		$model_ids = ShopModelsAuto::model()->getModelIds($app, $selected_auto);

		$connection = $app->db;
		$categories = ShopCategories::model()->getCategoriesList(0, $model_ids);
		foreach($categories as $category) {
			$criteria = new CDbCriteria();
			$criteria->select = "t.product_id";
			$criteria->join = 'INNER JOIN {{shop_products_categories}} AS pc USING (`product_id`) ';

			$condition_arr = array();
			$condition_arr[] = "pc.`category_id` = ".$category->id;

			if(count($model_ids))	{
				$product_ids = ShopProductsModelsAuto::model()->getProductIdFromModels($connection, $model_ids);

				$product_ids = ProductsModelsDisabled::model()->checkForExcludedProducts($connection, $product_ids, $model_ids);

				if(count($product_ids))
					$condition_arr[] = "t.`product_id` IN (".implode(', ', $product_ids).")";
			}

			$criteria->condition = implode(' AND ', $condition_arr);		

			$rows = ShopProducts::model()->findAll($criteria);
			if(count($rows) > 0) {
				$url_params = self::buildUrlParams($selected_auto, $category->id);
				$url = $url_params[0];
				unset($url_params[0]);
				$return_url = $app->getController()->createUrl($url, $url_params);
				break;
			}
		}
		return $return_url;
	}
}

