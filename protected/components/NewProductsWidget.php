<?php
// виджет выводит блок "НОВЫЕ ПОСТУПЛЕНИЯ"
class NewProductsWidget extends CWidget {
    public function run() {
		
		$app = Yii::app();
		$connection = $app->db;

		$cs = $app->getClientScript();
		$cs->registerCoreScript('jcarousel-new-positions');
		
		$rows = ShopProducts::model()->getLastAddedProducts();
		$product_ids = ShopProducts::model()->getProductIds($rows);

		$firms = ShopFirms::model()->getFirmsForProductList($connection, $product_ids);
		
		$data = array(
			'rows' => $rows,
			'firms' => $firms,
		);
		
		
		$this->render('NewProductsWidget', $data);
    }
}
?>