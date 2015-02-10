<?php
// виджет выводит блок "НОВЫЕ ПОСТУПЛЕНИЯ"
class NewProductsWidget extends CWidget {
    public function run() {
		
		$app = Yii::app();

		$cs = $app->getClientScript();
		$cs->registerCoreScript('jcarousel-new-positions');
		
		$rows = ShopProducts::model()->getLastAddedProducts();
		
		$data = array(
			'rows' => $rows,
		);
		
		
		$this->render('NewProductsWidget', $data);
    }
}
?>