<?php
class ShopCategoriesWidget extends CWidget {
    public function run() {
		$caregories_tree = ShopCategories::model()->getTreeCategories(0);
		//echo'<pre>$caregories_tree ';print_r($caregories_tree);echo'</pre>';die;
		$this->render('ShopCategoriesWidget', array('caregories_tree' => $caregories_tree));
    }
}
?>