<?php
class SearchAutoWidget extends CWidget {
	
    public function run() {
		$app = Yii::app();
		
		$connection = $app->db;
				
		$clear_search_auto = $app->request->getParam('clear-search-auto', 0);
		
		$do_redirect = false;
		
		if($clear_search_auto) {
			unset($app->session['autofilter.marka']);
			unset($app->session['autofilter.model']);
			unset($app->session['autofilter.year']);
			unset($app->session['autofilter.modelinfo']);
			
			$select_marka = null;
			$select_model = null;
			$select_year = null;
			
			$do_redirect = true;
			
			$return_url = '';
		}	else	{
			
			$select_marka = $app->request->getParam('select-marka', null);
			$select_model = $app->request->getParam('select-model', null);
			$select_year = $app->request->getParam('select-year', null);
			
			if(!is_null($select_marka) && !is_null($select_model) && !is_null($select_year)) $autoChanged = true;
				else $autoChanged = false;
			
			$url_params = UrlHelper::getUrlParams($app);
			//echo'<pre>';print_r($url_params);echo'</pre>';
			
			$return_url = $app->request->getParam('return', '');
			//echo'<pre>';print_r($return_url);echo'</pre>';
			if($return_url != '')	$return_url = base64_decode($return_url);
			
			if($select_marka != null) {
				$app->session['autofilter.marka'] = $select_marka;
				unset($app->session['autofilter.modelinfo']);
			} elseif(isset($app->session['autofilter.marka'])) {
				$select_marka = $app->session['autofilter.marka'];
			} elseif(isset($url_params['marka'])) {
				$select_marka = $url_params['marka'];
				$app->session['autofilter.marka'] = $select_marka;
			}

			if($select_model != null) {
				$app->session['autofilter.model'] = $select_model;
				unset($app->session['autofilter.modelinfo']);
			} elseif(isset($app->session['autofilter.model'])) {
				$select_model = $app->session['autofilter.model'];
			} elseif(isset($url_params['model'])) {
				$select_model = $url_params['model'];
				$app->session['autofilter.model'] = $select_model;
			}


			if($select_year != null) {
				$app->session['autofilter.year'] = $select_year;
				unset($app->session['autofilter.modelinfo']);
			} elseif(isset($app->session['autofilter.year'])) {
				$select_year = $app->session['autofilter.year'];
			} elseif(isset($url_params['year'])) {
				$select_year = $url_params['year'];
				$app->session['autofilter.year'] = $select_year;
			}
			
			
			if($autoChanged === true) {
				$do_redirect = true;
				
				if(!is_null($url_params['id'])) {

					$selected_auto = array(
						'marka' => $select_marka,
						'model' => $select_model,
						'year' => $select_year,
						'engine' => $app->request->getParam('engine', -1),
						'type' => $app->request->getParam('type', -1),
					);

					//echo'<pre>';print_r($url_params);echo'</pre>';//die;
					$url_params = UrlHelper::buildUrlParams($selected_auto, $url_params['id']);
					//echo'<pre>';print_r($url_params);echo'</pre>';die;
					$url = $url_params[0];
					unset($url_params[0]);
					$return_url = $this->owner->createUrl($url, $url_params);
					//echo'<pre>$return_url ';print_r($return_url);echo'</pre>';
				}	else	{
					$return_url = $this->owner->createUrl('shopcategories/index');
				}
			}
			
			
		}
		
		if($do_redirect) {
			//echo'<pre>';var_dump($return_url);echo'</pre>';die;
			//if($return_url != '' && $return_url != '/')
			if($return_url != '')
				$this->owner->redirect($return_url);
			
			if($clear_search_auto) $this->owner->redirect('/');
						
			//$this->owner->redirect($this->controller->createUrl('shopcategories/index'));
		}
		
		
		//echo'<pre>';var_dump($select_year);echo'</pre>';
		
		$markaDropDown = ShopModelsAuto::model()->getModelsLevel1($connection, false);
		
		if($select_model != null || $select_marka != null) {
			$model = ShopModelsAuto::model()->findByPk($select_marka);
			$descendants = $model->children()->findAll();
			$modelDropDown = CHtml::listData($descendants, 'id','name');
		} else {
			$modelDropDown = array();
		}
		
		if($select_year != null || $select_model != null) {
			$model = ShopModelsAuto::model()->findByPk($select_model);
			//$descendants = $model->children()->findAll();
			$descendants = $model->descendants()->findAll();
			foreach($descendants as $c){
				$separator = '';
				for ($x=3; $x++ < $c->level;) $separator .= '- ';
				$c->name = ' '.$separator.$c->name;
			}
			
			$yearDropDown = CHtml::listData($descendants, 'id','name');
		} else {
			$yearDropDown = array();
		}
		
		$return_url = base64_encode($app->request->requestUri);
		
		$this->render('SearchAutoWidget', array(
			'markaDropDown' => $markaDropDown,
			'modelDropDown' => $modelDropDown,
			'yearDropDown' => $yearDropDown,
			
			'select_marka' => $select_marka,
			'select_model' => $select_model,
			'select_year' => $select_year,
			'return_url' => $return_url,
		));
    }
}
?>