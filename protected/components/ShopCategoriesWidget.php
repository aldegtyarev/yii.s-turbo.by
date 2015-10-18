<?php
class ShopCategoriesWidget extends CWidget {
    public function run() {
		
		//echo'<pre>';print_r(Yii::app()->session['autofilter.year']);echo'</pre>';//die;
		if(isset(Yii::app()->session['autofilter.year']))
			$engines_info = Engines::model()->getEnginesInfo(Yii::app()->session['autofilter.year']);
		
		$caregories_tree = ShopCategories::model()->getTreeCategories(0);
		//echo'<pre>';print_r($engines_info);echo'</pre>';die;
		//echo'<pre>$caregories_tree ';print_r($caregories_tree);echo'</pre>';//die;
		
		if(isset($caregories_tree[4622]) && isset(Yii::app()->session['autofilter.year'])) {
			//$items = $caregories_tree[4622];
			if(isset($caregories_tree[4622]['items'][4623])) {
				$active = false;
				$items_ = array();
				foreach($engines_info as $engine) {
					$item = array();
					$item['label'] = CHtml::encode($engine['name']);
					$item['parent_id'] = 4623;
					$item['url'] = array('/shopcategories/show/', 'id'=>4623, 'engine'=>$engine['id']);
					$item['active'] = $active;
					$item['itemOptions'] = array('class'=>'eng-'.$engine['id']);
					$items_[$engine['id']] = $item;
				}
				$caregories_tree[4622]['items'][4623]['items'] = $items_;
			}
		}
		
		//echo'<pre>';print_r($caregories_tree);echo'</pre>';die;
		
		$this->render('ShopCategoriesWidget', array('caregories_tree' => $caregories_tree));
    }
}
?>