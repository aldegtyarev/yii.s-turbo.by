<?php
class ShopCategoriesWidget extends CWidget {
	
    public function run() {
		$app = Yii::app();
		
		$id1 = $app->params['vihlopnaya_sistema_id'];	// ИД "Выхлопная система"
		$id2 = $app->params['shtatnie_glushiteli_id'];	// ИД "Штатные глушители"
		
		$caregories_tree = ShopCategories::model()->getTreeCategories(0);
		
		//если выбран марка модель код кузов то в менюшку подставляем объемы двигателей
		if(isset($caregories_tree[$id1]) && isset($app->session['autofilter.marka']) && isset($app->session['autofilter.model']) && isset($app->session['autofilter.year'])) {	
			
			
			//$items = $caregories_tree[4622];
			if(isset($caregories_tree[$id1]['items'][$id2])) {
				
				$engines_info = Engines::model()->getEnginesInfo($app->session['autofilter.year']);
				
				//$model_ids = ShopModelsAuto::model()->getModelIds($app);
				//echo'<pre>';var_dump($engines_info);echo'</pre>';//die;
				
					
				$selected_auto = UrlHelper::getSelectedAuto($app);

				if(count($engines_info) > 0) {
					$engine_id = $app->request->getParam('engine', array());
					$active = false;
					$items_ = array();
					foreach($engines_info as $engine) {
						if($engine_id == $engine['id']) $active = true;
							else $active = false;

						$selected_auto_ = $selected_auto;
						$selected_auto_['engine'] = $engine['id'];

						$url_params = UrlHelper::buildUrlParams($selected_auto_, $id2);
						
						$item = array();
						$item['label'] = CHtml::encode($engine['name']);
						$item['parent_id'] = $id2;
						$item['url'] = $url_params;
						$item['active'] = $active;
						$item['itemOptions'] = array('class'=>'eng-'.$engine['id']);
						$items_[$engine['id']] = $item;
					}
					
					$caregories_tree[$id1]['items'][$id2]['items'] = $items_;
					
				}	else	{
					$model = ShopModelsAuto::model()->findByPk($app->session['autofilter.year']);
					$descendants = $model->descendants()->findAll();
					$active = false;
					$items_ = array();
					foreach($descendants as $c){
						
						$selected_auto_ = $selected_auto;
						$selected_auto_['bodyset'] = $c->id;
						$url_params = UrlHelper::buildUrlParams($selected_auto_, $id2);
						
						$item = array(
							'label' => CHtml::encode($c->name),
							'parent_id' => $id2,
							'url' => $url_params,
							'active' => $active,
							'itemOptions' => array('class'=>'bodyset eng-'.$c->id, 'data-body_id'=>$c->id),
						);

						$items_[$c->id] = $item;
						$caregories_tree[$id1]['items'][$id2]['items'] = $items_;
					}
				}
			}
		}
		
		
		
		//echo'<pre>';print_r($caregories_tree);echo'</pre>';die;
		
		$this->render('ShopCategoriesWidget', array('caregories_tree' => $caregories_tree));
    }
}
?>