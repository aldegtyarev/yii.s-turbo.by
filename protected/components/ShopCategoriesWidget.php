<?php
class ShopCategoriesWidget extends CWidget {
    public function run() {
		$caregories_tree = ShopCategories::model()->getTreeCategories(1);
		//echo'<pre>';print_r($caregories_tree);echo'</pre>';
		$this->render('ShopCategoriesWidget', array('caregories_tree' => $caregories_tree));
    }
}
?>