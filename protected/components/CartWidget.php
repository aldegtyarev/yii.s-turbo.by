<?php
class CartWidget extends CWidget {
	
    public function run() {
		$app = Yii::app();
		$count_products = $app->shoppingCart->getCount();
		$positions = $app->shoppingCart->getPositions();
		//$total_summ = $app->shoppingCart->getCost();
		$currency_info = Currencies::model()->loadCurrenciesList();
		
		$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
		$total_summ = $total_in_cart['summ'];
		//$count_products = $total_in_cart['qtyTotal'];
		
		$data = array(
			'currency_info' => $currency_info,
			'count_products' => $count_products,
			'total_summ' => $total_summ,
			'show_cart_url' => $this->controller->createUrl('/cart/showcart'),
		);
		
		$this->render('CartWidget', $data);
    }
}
?>