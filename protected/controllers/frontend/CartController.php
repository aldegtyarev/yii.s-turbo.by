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
			
			$model->cart_model_info = '';
			
			if($model->isUniversalProduct()) $model->cart_model_info = 'УНИВЕРСАЛЬНЫЕ ТОВАРЫ';
			
			//echo'<pre>';print_r($app->session);echo'</pre>';//die;
			//echo'<pre>';var_dump($model->ProductsModelsAutos);echo'</pre>';//die;
//			foreach($model->ProductsModelsAutos as $cat) {
//				if($cat->model_id == (int) $app->params['universal_products']) {
//					//$model->cart_model_info = $cat->model->name;
//					$model->cart_model_info = 'Universal';
//					//break;
//				}
//			}
//			//echo'$model->cart_model_info = <pre>';var_dump($model->cart_model_info);echo'</pre>';
			if($model->cart_model_info == '') {
				$modelinfo = json_decode($app->session['autofilter.modelinfo_cart'], 1);
				//echo'$modelinfo<pre>';print_r($modelinfo);echo'</pre>';die;
				if(count($modelinfo)) {
					foreach($modelinfo as $i) $model->cart_model_info .= $i['name'] . ' ';
				}
				
			}
			
			//echo'<pre>';print_r($model->cart_model_info);echo'</pre>';//die;
			
			$app->shoppingCart->put($model, $quantity);
			$msg = array(
				'res'		=>	'ok',
				'total'		=>	$app->shoppingCart->getCount(),
				'summ'		=>	PriceHelper::formatPrice($app->shoppingCart->getCost(), 1, 3),
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
		
		$modelFiz = new CheckoutFizForm;
		$modelUr = new CheckoutUrForm;
		
		$checkoutType = $app->request->getParam('checkoutType', 'checkout-fiz');
		
		//echo'<pre>';print_r($modelFiz);echo'</pre>';die;
		if(isset($_POST['checkoutType'])) {
			switch($checkoutType) {
				case 'checkout-fiz':
					$this->checkoutFiz($_POST, $modelFiz);
					break;
					
				case 'checkout-ur':
					$this->checkoutUr($_POST, $modelUr);
					break;
					
			}
		}
		
		$data = array(
			'app' => $app,
			'positions' => $positions,
			'params' => $params,
			'modelFiz' => $modelFiz,
			'modelUr' => $modelUr,
			'checkoutType' => $checkoutType,
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
		
		$positions = $app->shoppingCart->getPositions();
		$params = $app->params;
		
		$data = array(
			'app' => $app,
			'positions' => $positions,
			'params' => $params,
		);
		
		$total_cost = $app->shoppingCart->getCost();
		$data = array(
			'cost_usd' => PriceHelper::formatPrice($total_cost, 1),
			'cost_byr' => PriceHelper::formatPrice($total_cost, 1, 3),
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
		
		$modelFiz = new CheckoutFizForm;
		$modelUr = new CheckoutUrForm;
		
		$checkoutType = $app->request->getParam('checkoutType', 'checkout-fiz');
		
		//echo'<pre>';print_r($modelFiz);echo'</pre>';die;
		if(isset($_POST['checkoutType'])) {
			switch($checkoutType) {
				case 'checkout-fiz':
					$this->checkoutFiz($_POST, $modelFiz);
					break;
					
				case 'checkout-ur':
					$this->checkoutUr($_POST, $modelUr);
					break;
					
			}
		}
		

		
		$data = array(
			'app' => $app,
			'params' => $params,
			'positions' => $positions,
			'modelFiz' => $modelFiz,
			'modelUr' => $modelUr,
			'checkoutType' => $checkoutType,
		);
		
		$this->render('checkout', $data);
		
	}
	
	public function actionOrderdone()
	{
		$app = Yii::app();
		$params = $app->params;
		
		$app->shoppingCart->clear();
		
		$data = array(
			'app' => $app,
			'params' => $params,
			//'positions' => $positions,
			//'model' => $model,
		);
		
		$this->render('orderdone', $data);
	}
	
	public function checkoutFiz($post, $model)
	{
		if(isset($_POST['CheckoutFizForm'])) {
			$model->attributes=$_POST['CheckoutFizForm'];

			if($model->validate())
				$this->redirect(array('orderdone'));
		}
		
	}
	
	public function checkoutUr($post, $model)
	{
		if(isset($_POST['CheckoutUrForm'])) {
			$model->attributes=$_POST['CheckoutUrForm'];
			
			switch($model->na_osnovanii) {
				case 2:
					$model->scenario = 'na_osnovanii_doverennosti';
					break;
				case 3:
					$model->scenario = 'na_osnovanii_svidetelstva';
					break;
				default:


			}

			if($model->validate())
				$this->redirect(array('orderdone'));
		}
		
	}
}