<?php
header('Content-Type: text/html; charset=utf-8');

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
			$total = $app->shoppingCart->getCount();
			$summ = PriceHelper::formatPrice($app->shoppingCart->getCost(), 1, 3);
			
			$html = '';
			$html = $this->renderPartial( 'add-to-cart', array(
				'count_products' => $total,
				'total_summ' => $total,
				'show_cart_url' => $this->createUrl('/cart/showcart'),
			),true);
			
			$msg = array(
				'res'		=>	'ok',
				'total'		=>	$total . ' ' . Yii::t('app', 'товар|товара|товаров', $total),
				'summ'		=>	$summ,
				'message'	=>	$message,
				'html'	=>	$html,
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
		
		$currency_info = Currencies::model()->loadCurrenciesList();
		
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
			'currency_info' => $currency_info,
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
		
		$product_price = 0;
		$product_currency = 1;
			
		foreach($positions as $product)
			if($product->product_id == $product_id) {
				$product_price = $product->getSumPrice();
				$product_currency = $product->currency_id;
				break;
			}
		
		$data = array(
			'app' => $app,
			'positions' => $positions,
			'params' => $params,
		);
		
		$total_cost = $app->shoppingCart->getCost();
		$data = array(
			'cost_usd' => PriceHelper::formatPrice($total_cost, 1),
			'cost_byr' => PriceHelper::formatPrice($total_cost, 1, 3),
			'product_summ' => PriceHelper::formatPrice($product_price, $product_currency, 3),
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
		
		$order = $app->request->getParam('order', 0);
		
		$model = Orders::model()->findByPk($order);
		
		//echo'<pre>';print_r($_POST);echo'</pre>';die;
		
		//$app->shoppingCart->clear();
		
		$data = array(
			'app' => $app,
			'params' => $params,
			//'positions' => $positions,
			'model' => $model,
		);
		
		$this->render('orderdone', $data);
	}
	
	public function checkoutFiz($post, $model)
	{
		if(isset($_POST['CheckoutFizForm'])) {
			$model->attributes = $_POST['CheckoutFizForm'];

			if($model->validate()) {
				$app = Yii::app();
				$positions = $app->shoppingCart->getPositions();
				
				$total = $this->calculateTotalSumm($positions);
				
				$customer = array('type' => Orders::CUSTOMER_TYPE_FIZ);
				
				foreach($model->attributes as $attr=>$val) $customer[$attr] = $val;
				
				$order = $this->addOrder($positions, $total, $customer);
				//echo'<pre>';print_r($order);echo'</pre>';die;
				$currency_info = Currencies::model()->loadCurrenciesList();
				
				$data = array(
					'positions' => $positions,
					'model' => $model,
					'app' => $app,
					'order' => $order,
					'total_summ' => $total['byr'],
					'customer_type' => Orders::CUSTOMER_TYPE_FIZ,
					'customer' => $customer,
					'currency_info' => $currency_info,
					
				);
				
				$to = array(Yii::app()->params['adminEmail']);
				
				if($model->email != '') $to[] = $model->email;
				
				Yii::app()->dpsMailer->sendByView(
					$to, // определяем кому отправляется письмо
					//array('aldegtyarev1980@mail.ru'), // определяем кому отправляется письмо
					'emailOrder', // view шаблона письма
					$data
				);
				
				//echo'<pre>';print_r($positions);echo'</pre>';//die;
				
				$this->redirect(array('orderdone', 'order'=>$order->id));
			}
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
			
			if($model->validate()) {
				$app = Yii::app();
				$positions = $app->shoppingCart->getPositions();
				
				$total = $this->calculateTotalSumm($positions);
				
				$customer = array('type' => Orders::CUSTOMER_TYPE_UR);
				
				foreach($model->attributes as $attr=>$val) {
					if($attr == 'na_osnovanii') {
						$CheckoutUrForm = new CheckoutUrForm();
						$variants = $CheckoutUrForm->getNaOsnovaniiRadioList();
						$customer[$attr] = $variants[$val];
					}	else	{
						$customer[$attr] = $val;
					}
				}
				
				$order = $this->addOrder($positions, $total, $customer);
				
				$currency_info = Currencies::model()->loadCurrenciesList();
				
				$data = array(
					'positions' => $positions,
					'model' => $model,
					'app' => $app,
					'order' => $order,
					'total_summ' => $total['byr'],
					'customer_type' => Orders::CUSTOMER_TYPE_UR,
					'customer' => $customer,
					'currency_info' => $currency_info,
				);
				
				$to = array(Yii::app()->params['adminEmail']);
				
				if($model->email != '') $to[] = $model->email;
				
				Yii::app()->dpsMailer->sendByView(
					$to, // определяем кому отправляется письмо
					//array('aldegtyarev1980@mail.ru'), // определяем кому отправляется письмо
					'emailOrder', // view шаблона письма
					$data
				);
				//echo'<pre>';print_r($positions);echo'</pre>';//die;				
				
				$this->redirect(array('orderdone', 'order'=>$order->id));
			}
		}
	}
	
	/**
	 * считает полную сумму заказа в usd, byr
	 * @return array
	 */
	public function calculateTotalSumm($positions)
	{
		$currency_info = Currencies::model()->loadCurrenciesList();

		$summ_usd = 0;
		$summ_byr = 0;

		foreach($positions as $product) {
			$summ_usd += PriceHelper::formatPrice(($product->product_price * $product->getQuantity()), $product->currency_id, 1, $currency_info, false, true);
			$summ_byr += PriceHelper::formatPrice(($product->product_price * $product->getQuantity()), $product->currency_id, 3, $currency_info, false, true);
		}
		
		return array(
			'usd' => $summ_usd,
			'byr' => $summ_byr,
		);
		
	}
		
	/**
	 * добавляет в базу новый заказ
	 * @return model
	 */
	public function addOrder($positions, $total, $customer)
	{
		$order = new Orders();
		$order->created = time();
		$order->summ_usd = $total['usd'];
		$order->summ_byr = $total['byr'];
		$order->customer = json_encode($customer);
		$order->save();

		foreach($positions as $product) {
			$order_product = new OrdersProducts();
			$order_product->order_id = $order->id;
			$order_product->product_id = $product->product_id;
			$order_product->save();
		}
		
		return $order;
	}
		
}