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
	
    /*
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
		
		//echo'<pre>';print_r($app->session);echo'</pre>';
		
		if($params['marka'] == -1 || $params['model'] == -1 || $params['year'] == -1) {
			$url_parms = self::getUrlParams($app);
			if(!is_null($url_parms['marka'])) $params['marka'] = $url_parms['marka'];
			if(!is_null($url_parms['model'])) $params['model'] = $url_parms['model'];
			if(!is_null($url_parms['year'])) $params['year'] = $url_parms['year'];
		}
			
		
		return $params;
	}
	
    /*
	*	собирает параметры для урла на основании текущего выбранного авто, категории и т.п.
	*/
	public static function buildUrlParams($input_params, $cat_id)
	{
		
		$url_params = array(
			'/shopcategories/show/',
			'id'=>$cat_id,						
		);

		if($input_params['marka'] > -1) $url_params['marka'] = $input_params['marka'];
		if($input_params['model'] > -1) $url_params['model'] = $input_params['model'];
		if($input_params['year'] > -1) $url_params['year'] = $input_params['year'];
		if($input_params['engine'] > -1) $url_params['engine'] = $input_params['engine'];
		if($input_params['bodyset'] > -1) $url_params['bodyset'] = $input_params['bodyset'];
		if($input_params['type'] > -1) $url_params['type'] = $input_params['type'];
		
		
		return $url_params;
	}
}

