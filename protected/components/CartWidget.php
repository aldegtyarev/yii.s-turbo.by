<?php
class CartWidget extends CWidget {
    public function run() {
		$app = Yii::app();
		$count_products = $app->shoppingCart->getCount();
		$total_summ = $app->shoppingCart->getCost();
		$data = array(
			'count_products' => $count_products,
			'total_summ' => $total_summ,
			'show_cart_url' => $this->controller->createUrl('/cart/showcart'),
		);
		
		$this->render('CartWidget', $data);
    }
}
?>