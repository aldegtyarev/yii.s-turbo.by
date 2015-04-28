<?php

class CartController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionAddtocart()
	{
		$app = Yii::app();
		$product_id = $app->request->getParam('product_id', 0);
		$quantity = $app->request->getParam('quantity', 0);
		
		$message = '<span style="color:green;">Товар был добавлен в корзину.</span>';
		
		$positions = $app->shoppingCart->getPositions();
		
		foreach($positions as $position) {
			if($position->product_id == $product_id) {
				$message = '<span style="color:green;">Количество товара было обновлено.</span>';
				
			}
		}
		
		if($product_id && $quantity) {
			$model = ShopProducts::model()->findByPk($product_id);
			$app->shoppingCart->put($model, $quantity);
			$msg = array(
				'res'		=>	'ok',
				'total'		=>	$app->shoppingCart->getCount(),
				'summ'		=>	Yii::app()->NumberFormatter->formatDecimal($app->shoppingCart->getCost(), 0, '.', ' '),
				'message'	=>	$message,
			);
		}	else	{
			$msg = array('res' => 'err');
		}
		echo json_encode($msg);
		
		$app->end();
	}
	
	public function actionShowcart()
	{
		$app = Yii::app();
		$positions = Yii::app()->shoppingCart->getPositions();
		
		/*
		foreach($positions as $position) {
			echo'<pre>';print_r($position);echo'</pre>';
		}
		*/
		$data = array(
			'positions' => $positions,
		);
		$this->render('showcart', $data);
	}
	
	public function actionUpdatecart()
	{
		$app = Yii::app();
		//$positions = Yii::app()->shoppingCart->getPositions();

		$product_id = $app->request->getParam('product_id', 0);
		$quantity = $app->request->getParam('quantity', 0);
		//echo'<pre>';print_r($product_id);echo'</pre>';
		//echo'<pre>';print_r($quantity);echo'</pre>';
		
		$model = ShopProducts::model()->findByPk($product_id);
		$app->shoppingCart->update($model, $quantity);
		$this->redirect('showcart');
		
		/*
		$data = array(
			'positions' => $positions,
		);
		
		$this->render('showcart', $data);
		*/
	}
	
	
	//удаление позиции товара из корзины
	public function actionRemovefromcart()
	{
		$app = Yii::app();
		$product_id = $app->request->getParam('product_id', 0);
		
		if($product_id)	{
			$model = ShopProducts::model()->findByPk($product_id);
			//echo'<pre>';print_r($product_id);echo'</pre>';
			$app->shoppingCart->remove($model->getId()); //no items
		}	else	{
			
		}
		
		$this->redirect('showcart');
	}
	
	//полная очистка содержимого корзины
	public function actionClearcart()
	{
		Yii::app()->shoppingCart->clear();
		
		$this->redirect('showcart');
	}
}