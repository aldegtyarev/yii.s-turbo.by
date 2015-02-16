<?php
// виджет выводит блок "ВЫ НЕДАВНО ПРОСМАТРИВАЛИ"
class LastViewedProductsWidget extends CWidget {
    public function run() {
		
		$app = Yii::app();

		$cs = $app->getClientScript();
		$cs->registerCoreScript('jcarousel-new-positions');
		
		$rows = ShopProducts::model()->getLastViewedProducts();
		
		$data = array(
			'rows' => $rows,
		);
		
		
		$this->render('LastViewedProductsWidget', $data);
    }
}
?>