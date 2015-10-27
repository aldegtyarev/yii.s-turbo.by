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
			
			$return_url = $app->request->getParam('return', '');
			if($return_url != '')	$return_url = base64_decode($return_url);
			
			if($select_marka != null) {
				$do_redirect = true;
				$app->session['autofilter.marka'] = $select_marka;
			} elseif(isset($app->session['autofilter.marka'])) {
				$select_marka = $app->session['autofilter.marka'];
			}

			if($select_model != null) {
				$do_redirect = true;
				$app->session['autofilter.model'] = $select_model;
			} elseif(isset($app->session['autofilter.model'])) {
				$select_model = $app->session['autofilter.model'];
			}

			if($select_year != null) {
				$do_redirect = true;
				$app->session['autofilter.year'] = $select_year;
			} elseif(isset($app->session['autofilter.year'])) {
				$select_year = $app->session['autofilter.year'];
			}
			
			
		}
		
		if($do_redirect) {
		//echo'<pre>';print_r($app->homeUrl);echo'</pre>';
		//echo'<pre>';var_dump($return_url);echo'</pre>';
		//die;
			if($return_url != '' && $return_url != '/')
				$this->owner->redirect($return_url);
			
			//$this->owner->redirect($app->homeUrl);
			$this->owner->redirect($this->controller->createUrl('shopcategories/index'));
		}
		
		
		//echo'<pre>';var_dump($select_year);echo'</pre>';
		
		$markaDropDown = ShopModelsAuto::model()->getModelsLevel1($connection);
		
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