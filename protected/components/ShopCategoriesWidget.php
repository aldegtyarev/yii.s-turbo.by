<?php
class ShopCategoriesWidget extends CWidget {
    public function run() {
		
		$id1 = 4622;	// ИД "Выхлопная система"
		$id2 = 4623;	// ИД "Штатные глушители"
		
		//echo'<pre>';print_r($_GET);echo'</pre>';//die;
		if(isset(Yii::app()->session['autofilter.year']))
			$engines_info = Engines::model()->getEnginesInfo(Yii::app()->session['autofilter.year']);
		
		$caregories_tree = ShopCategories::model()->getTreeCategories(0);
		//echo'<pre>';print_r($engines_info);echo'</pre>';die;
		//echo'<pre>$caregories_tree ';print_r($caregories_tree);echo'</pre>';//die;
		
		//если выбран марка модель код кузов то в менюшку подставляем объемы двигателей
		if(isset($caregories_tree[$id1]) && isset(Yii::app()->session['autofilter.year'])) {
			//$items = $caregories_tree[4622];
			if(isset($caregories_tree[$id1]['items'][$id2])) {
				$engine_id = Yii::app()->request->getParam('engine', array());
				$active = false;
				$items_ = array();
				foreach($engines_info as $engine) {
					if($engine_id == $engine['id']) $active = true;
						else $active = false;
					
					$item = array();
					$item['label'] = CHtml::encode($engine['name']);
					$item['parent_id'] = $id2;
					$item['url'] = array('/shopcategories/show/', 'id'=>$id2, 'engine'=>$engine['id']);
					$item['active'] = $active;
					$item['itemOptions'] = array('class'=>'eng-'.$engine['id']);
					$items_[$engine['id']] = $item;
				}
				$caregories_tree[$id1]['items'][$id2]['items'] = $items_;
			}
		}
		
		//echo'<pre>';print_r($caregories_tree);echo'</pre>';die;
		
		$this->render('ShopCategoriesWidget', array('caregories_tree' => $caregories_tree));
    }
}
?>