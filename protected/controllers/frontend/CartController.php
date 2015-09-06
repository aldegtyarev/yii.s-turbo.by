<?php

class CartController extends Controller
{
	
	public $layout='//layouts/column2l';
	
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
				$message = '<span style="color:green;">Количество товара обновлено.</span>';
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
		$positions = $app->shoppingCart->getPositions();
		
		$params = $app->params;
		
		/*
		foreach($positions as $position) {
			echo'<pre>';print_r($position);echo'</pre>';
		}
		*/
		$data = array(
			'app' => $app,
			'positions' => $positions,
			'params' => $params,
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
		$NumberFormatter = $app->NumberFormatter;
		
		$positions = $app->shoppingCart->getPositions();
		$params = $app->params;
		
		$data = array(
			'app' => $app,
			'positions' => $positions,
			'params' => $params,
		);
		
		$total_cost = $app->shoppingCart->getCost();
		$data = array(
			'cost_usd' => $NumberFormatter->formatDecimal($total_cost).' у.е.',
			'cost_byr' => $NumberFormatter->formatDecimal($total_cost * $params->usd_rate).' бел.руб',
		);
		//$this->renderPartial('_cart-list', $data);
		echo json_encode($data);
		$app->end();
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
	
	public function actionCheckout()
	{
		$app = Yii::app();
		$positions = $app->shoppingCart->getPositions();
		
		$params = $app->params;
		
		$model = new CheckoutForm;
		
		if(isset($_POST['CheckoutForm']))
		{
			$model->attributes=$_POST['CheckoutForm'];

			if($model->validate())
				$this->redirect(array('orderdone'));
		}

		
		$data = array(
			'app' => $app,
			'params' => $params,
			'positions' => $positions,
			'model' => $model,
		);
		$this->render('checkout', $data);
		
	}
	
	public function actionOrderdone()
	{
		$app = Yii::app();
		$params = $app->params;
		
		$data = array(
			'app' => $app,
			'params' => $params,
			//'positions' => $positions,
			//'model' => $model,
		);
		
		$this->render('orderdone', $data);
	}
}