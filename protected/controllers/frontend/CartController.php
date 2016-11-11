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

		//print_r($_SERVER);die;
		//$app->end();
		
		$message = '<span style="color:green;">Товар был добавлен в корзину.</span>';
		
		$positions = $app->shoppingCart->getPositions();
		
		foreach($positions as $position) {
			if($position->product_id == $product_id) {
				$message = '<span style="color:green;">Количество товара обновлено.</span>';
			}
		}
		
		if($product_id && $quantity) {
			$model = ShopProducts::model()->findByPk($product_id);
            $model->loadAddInfoForCart($this, $app);

//			$fp = fopen(Yii::getPathOfAlias('webroot') . "/cart.log", "a"); // Открываем файл в режиме записи
//
//			$mytext = date('d-m-Y H:i:s')."\r\n"; // Исходная строка
//			$mytext .= 'REMOTE_ADDR = ' . $_SERVER['REMOTE_ADDR'] . "\r\n";
//			$mytext .= 'HTTP_USER_AGENT = ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
//			$mytext .= 'HTTP_USER_AGENT = ' . $_SERVER['HTTP_REFERER'] . "\r\n";
//			$mytext .= 'product_name = ' . $model->product_name . "\r\n";
//			$mytext .= 'product_url = ' . $model->product_url . "\r\n";
//			$mytext .= 'cart_model_info = ' . $model->cart_model_info . "\r\n";
//			$mytext .= "\r\n";
//			$mytext .= "\r\n";
//
//			fwrite($fp, $mytext); // Запись в файл
//			fclose($fp); //Закрытие файла

			$app->shoppingCart->put($model, $quantity);
			//$total = $app->shoppingCart->getCount();
			
			$positions = $app->shoppingCart->getPositions();
            //echo'<pre>';print_r($positions);echo'</pre>';//die;
			$currency_info = Currencies::model()->loadCurrenciesList();
			
			$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
			$summ = $total_in_cart['summ'];
			$total = $total_in_cart['qtyTotal'];
			
			//$html = '';
			$html = $this->renderPartial( 'add-to-cart', array(
				'count_products' => $total,
				'total_summ' => $summ,
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
//        echo'<pre>';print_r($positions);echo'</pre>';//die;

		$params = $app->params;
		
		$modelFiz = new CheckoutFizForm;
		$modelUr = new CheckoutUrForm;
		
		$checkoutType = $app->request->getParam('checkoutType', 'checkout-fiz');
		
		$currency_info = Currencies::model()->loadCurrenciesList();

        foreach($positions as $product) {
            $pr = PriceHelper::formatPrice((PriceHelper::calculateSummOfPosition($product, $currency_info)), 3, 3, $currency_info, true);
            $pr = PriceHelper::calculateSummOfPosition($product, $currency_info);
            //echo'<pre>';print_r($pr);echo'</pre>';//die;

        }

		
		$delivery_list = Delivery::model()->loadCalculatedDeliveryList($positions, $currency_info);
		
		$payment_list = Payment::model()->loadPaymentList();
		
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
		
		$delivery_id = $app->request->getParam('delivery_id', 0);
		$delivery_quick = $app->request->getParam('deliveryQuick', 0);
		
		$delivery_cost = 0;
		if($delivery_id > 0) {
			$modelDelivery = Delivery::model()->loadDelivery($delivery_id);
			$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
			$modelDelivery = Delivery::model()->calculateDelivery($modelDelivery, $positions, $currency_info, $total_in_cart['summ_for_delivery'], $total_in_cart['qtyTotal_for_delivery']);
			//подставляем стоимость доставки к цене
			if($modelDelivery->delivery_free != true) {
				if($delivery_quick == 0) $delivery_cost = $modelDelivery->delivery_normal;
					else $delivery_cost = $modelDelivery->delivery_quick;
			}
		}
		
		//print_r($delivery_quick);die;
		
		$payment_id = $app->request->getParam('payment_id', 0);
		
		$data = array(
			'app' => $app,
			'positions' => $positions,
			'params' => $params,
			'modelFiz' => $modelFiz,
			'modelUr' => $modelUr,
			'checkoutType' => $checkoutType,
			'currency_info' => $currency_info,
			'delivery_list' => $delivery_list,
			'delivery_id' => $delivery_id,
			'delivery_quick' => $delivery_quick,
			'payment_list' => $payment_list,
			'payment_id' => $payment_id,
			'delivery_cost' => $delivery_cost,
			
		);
		
		$this->render('showcart', $data);
	}
	
	public function actionUpdatecart()
	{
		$app = Yii::app();

		$product_id = $app->request->getParam('product_id', 0);
		$quantity = $app->request->getParam('quantity', 0);
		
		$model = ShopProducts::model()->findByPk($product_id);
        $model->loadAddInfoForCart($this, $app);



		$app->shoppingCart->update($model, $quantity);
		
		$positions = $app->shoppingCart->getPositions();
		$params = $app->params;
		
		$product_price = 0;
		$product_currency = 1;
		
		$currency_info = Currencies::model()->loadCurrenciesList();		
			
		foreach($positions as $product)
			if($product->product_id == $product_id) {
				$product_summ = PriceHelper::calculateSummOfPosition($product, $currency_info);
				break;
			}

		$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
		
		$total_cost = $total_in_cart['summ'];
		$total = $app->shoppingCart->getCount();

		$html = $this->renderPartial( 'add-to-cart', array(
			'count_products' => $total,
			'total_summ' => $total_cost,
			'show_cart_url' => $this->createUrl('/cart/showcart'),
		),true);
		
		$payment_list = Payment::model()->loadPaymentList();
		
		$htmlPayment = $this->renderPartial( '_payment-list', array(
			'rows' => $payment_list,
			'delivery_id' => 0,
		),true);
		
		
		$delivery_list = Delivery::model()->loadCalculatedDeliveryList($positions, $currency_info);
		
		$htmlDelivery = $this->renderPartial( '_delivery-list', array(
			'rows' => $delivery_list,
			'currency_info' => $currency_info,
		),true);
		
		$data = array(
			//'cost_usd' => PriceHelper::formatPrice($total_cost, 3, 1, $currency_info),
			'cost_byr' => PriceHelper::formatPrice($total_cost, 3, 3, $currency_info, true),
			'product_summ' => PriceHelper::formatPrice($product_summ, 3, 3, $currency_info, true),
			'html' => $html,
			'delivery' => $htmlDelivery,
			'payment' => $htmlPayment,
		);
		//$this->renderPartial('_cart-list', $data);
		echo json_encode($data);
		$app->end();
	}
	
	public function actionSetcostdelivery()
	{
		$app = Yii::app();

		$delivery_id = $app->request->getParam('delivery_id', -1);
		$delivery_quick = $app->request->getParam('delivery_quick', -1);
		
		if($delivery_id == -1 || $delivery_quick == -1) $app->end();
		
		$modelDelivery = Delivery::model()->loadDelivery($delivery_id);
		
		$positions = $app->shoppingCart->getPositions();
		$params = $app->params;
		
		$product_price = 0;
		$product_currency = 1;
			
		$currency_info = Currencies::model()->loadCurrenciesList();

		$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
		
		$total_cost = $total_in_cart['summ'];
		
		$modelDelivery = Delivery::model()->calculateDelivery($modelDelivery, $positions, $currency_info, $total_in_cart['summ_for_delivery'], $total_in_cart['qtyTotal_for_delivery']);		
		
		$payment_list = Payment::model()->loadPaymentList();
		
		$payment_html = $this->renderPartial( '_payment-list', array(
			'rows' => $payment_list,
			'delivery_id' => $delivery_id,
		),true);
		
		//подставляем стоимость доставки к цене
		if($modelDelivery->delivery_free != true) {
			if($delivery_quick == 0) $total_cost += $modelDelivery->delivery_normal;
				else $total_cost += $modelDelivery->delivery_quick;
		}
			
		
		$data = array(
			//'cost_usd' => PriceHelper::formatPrice($total_cost, 3, 1, $currency_info),
			'cost_byr' => PriceHelper::formatPrice($total_cost, 3, 3, $currency_info, true),
//			'product_summ' => PriceHelper::formatPrice($product_summ, 3, 3, $currency_info, true),
			'payment_html' => $payment_html,
		);
		//$this->renderPartial('_cart-list', $data);
		echo json_encode($data);
		$app->end();
	}
	
	/**
	 * удаление позиции товара из корзины
	 */
	public function actionRemovefromcart()
	{
		$app = Yii::app();
		$product_id = $app->request->getParam('product_id', 0);

		if ($product_id) {
			$model = ShopProducts::model()->findByPk($product_id);
			$app->shoppingCart->remove($model->getId()); //no items
		}
		$this->redirect('showcart');
	}

	//полная очистка содержимого корзинымого корзины
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
		
		$delivery_id = $model->delivery_id;
		$delivery_quick = $model->delivery_quick;
		$positions = $app->shoppingCart->getPositions();
		$currency_info = Currencies::model()->loadCurrenciesList();
		
		
		$delivery_cost = 0;
		if($delivery_id > 0) {
			$modelDelivery = Delivery::model()->loadDelivery($delivery_id);
			$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
			$modelDelivery = Delivery::model()->calculateDelivery($modelDelivery, $positions, $currency_info, $total_in_cart['summ_for_delivery'], $total_in_cart['qtyTotal_for_delivery']);
			//подставляем стоимость доставки к цене
			if($modelDelivery->delivery_free != true) {
				if($delivery_quick == 0) $delivery_cost = $modelDelivery->delivery_normal;
					else $delivery_cost = $modelDelivery->delivery_quick;
			}
		}
		
		$app->shoppingCart->clear();
		$data = array(
			'app' => $app,
			'params' => $params,
			'model' => $model,
			'delivery_cost' => $delivery_cost,
		);
		$this->render('orderdone', $data);
	}
	
	public function checkoutFiz($post, $model)
	{
        $app = Yii::app();

		if(isset($_POST['CheckoutFizForm'])) {
			$model->attributes = $_POST['CheckoutFizForm'];

            $delivery_id = $app->request->getParam('delivery_id', 0);
//            if ($delivery_id == 2) $model->scenario = 'delivery_by_post';

//            echo'<pre>';print_r($_POST);echo'</pre>';die;
            //echo'<pre>';print_r($model->attributes);echo'</pre>';die;

            $positions = $app->shoppingCart->getPositions();
//            $positions = '';

            if(is_array($positions) && count($positions) > 0) $model->positions = 1;
//            $model->positions = 1;

            if($model->validate()) {
				$app = Yii::app();

				$currency_info = Currencies::model()->loadCurrenciesList();
				
				$total = $this->calculateTotalSumm($positions, $currency_info);

				$customer = array('type' => Orders::CUSTOMER_TYPE_FIZ);
				
				foreach($model->attributes as $attr=>$val) $customer[$attr] = $val;
				
				$delivery_id = $app->request->getParam('delivery_id', 1);
				$delivery_quick = $app->request->getParam('deliveryQuick', 0);
				$payment_id = $app->request->getParam('payment_id', 1);
				
				$deliveryName = Delivery::model()->getDeliveryNameForEmail($delivery_id, $delivery_quick);
				$paymentName = Payment::model()->getPaymentNameForEmail($payment_id);
				
				$order = $this->addOrder($positions, $total, $customer, $delivery_id, $delivery_quick, $payment_id);
				
				$delivery_cost = 0;
				if($delivery_id > 0) {
					$modelDelivery = Delivery::model()->loadDelivery($delivery_id);
					$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
					$modelDelivery = Delivery::model()->calculateDelivery($modelDelivery, $positions, $currency_info, $total_in_cart['summ_for_delivery'], $total_in_cart['qtyTotal_for_delivery']);
					
					//подставляем стоимость доставки к цене
					if($modelDelivery->delivery_free != true) {
						if($delivery_quick == 0) $delivery_cost = $modelDelivery->delivery_normal;
							else $delivery_cost = $modelDelivery->delivery_quick;
					}
				}
				
				$data = array(
					'positions' => $positions,
					'model' => $model,
					'app' => $app,
					'order' => $order,
					'total_summ' => $total['byr'],
					'customer_type' => Orders::CUSTOMER_TYPE_FIZ,
					'customer' => $customer,
					'currency_info' => $currency_info,
					'delivery_name' => $deliveryName,
					'payment_name' => $paymentName,
					'delivery_cost' => $delivery_cost,
					
				);
				
				$to = array(Yii::app()->params['adminEmail']);
				
				if($model->email != '') $to[] = $model->email;
				
				Yii::app()->dpsMailer->sendByView(
					$to, // определяем кому отправляется письмо
//					array('aldegtyarev@yandex.ru'), // определяем кому отправляется письмо
					'emailOrder', // view шаблона письма
					$data
				);
				$this->redirect(array('orderdone', 'order'=>$order->id));
			}
//            echo'<pre>';print_r($model->errors);echo'</pre>';die;

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

            $app = Yii::app();
            $positions = $app->shoppingCart->getPositions();
            if(is_array($positions) && count($positions) > 0) $model->positions = 1;
			
			if($model->validate()) {
				$currency_info = Currencies::model()->loadCurrenciesList();
				
				$total = $this->calculateTotalSumm($positions, $currency_info);
				
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
				
				$delivery_id = $app->request->getParam('delivery_id', 1);
				$delivery_quick = $app->request->getParam('deliveryQuick', 0);
				$payment_id = $app->request->getParam('delivery_id', 1);
				
				$deliveryName = Delivery::model()->getDeliveryNameForEmail($delivery_id, $delivery_quick);
				$paymentName = Payment::model()->getPaymentNameForEmail($payment_id);				
				
				$order = $this->addOrder($positions, $total, $customer, $delivery_id, $delivery_quick, $payment_id);
				
				$delivery_cost = 0;
				if($delivery_id > 0) {
					$modelDelivery = Delivery::model()->loadDelivery($delivery_id);
					$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
					$modelDelivery = Delivery::model()->calculateDelivery($modelDelivery, $positions, $currency_info, $total_in_cart['summ_for_delivery'], $total_in_cart['qtyTotal_for_delivery']);
					
					//подставляем стоимость доставки к цене
					if($modelDelivery->delivery_free != true) {
						if($delivery_quick == 0) $delivery_cost = $modelDelivery->delivery_normal;
							else $delivery_cost = $modelDelivery->delivery_quick;
					}
				}
				
				$data = array(
					'positions' => $positions,
					'model' => $model,
					'app' => $app,
					'order' => $order,
					'total_summ' => $total['byr'],
					'customer_type' => Orders::CUSTOMER_TYPE_UR,
					'customer' => $customer,
					'currency_info' => $currency_info,
					'delivery_name' => $deliveryName,
					'payment_name' => $paymentName,
					'delivery_cost' => $delivery_cost,
				);
				
				$to = array(Yii::app()->params['adminEmail']);
				
				if($model->email != '') $to[] = $model->email;
				
				Yii::app()->dpsMailer->sendByView(
					$to, // определяем кому отправляется письмо
					//array('aldegtyarev@yandex.ru'), // определяем кому отправляется письмо
					'emailOrder', // view шаблона письма
					$data
				);
				$this->redirect(array('orderdone', 'order'=>$order->id));
			}
		}
	}
	
	/**
	 * считает полную сумму заказа в usd, byr
	 * @return array
	 */
	public function calculateTotalSumm($positions, $currency_info)
	{
		$currency_info = Currencies::model()->loadCurrenciesList();

		$summ_usd = 0;
		$summ_byr = 0;

		foreach($positions as $product) {
			$summ_usd += PriceHelper::calculateSummOfPosition($product, $currency_info, 1);
			$summ_byr += PriceHelper::calculateSummOfPosition($product, $currency_info, 3);
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
	public function addOrder($positions, $total, $customer, $delivery_id, $delivery_quick, $payment_id)
	{
		$order = new Orders();
		$order->created = time();
		$order->summ_usd = $total['usd'];
		$order->summ_byr = $total['byr'];
		$order->delivery_id = $delivery_id;
		$order->delivery_quick = $delivery_quick;
		$order->payment_id = $payment_id;
		$order->customer = json_encode($customer);
		
		if($order->validate()) {
			$order->save();
		}	else	{
			$errors = $order->getErrors();
			$webroot = Yii::getPathOfAlias('webroot');
			
			$fp = fopen($webroot . "/order-err.log", "a"); // Открываем файл в режиме записи 
			$mytext = date('d-m-Y H:i:s')."\r\n"; // Исходная строка
			
			foreach($errors as $err)
				$mytext .= $err[0] ."\r\n";
			
			$mytext .= "\r\n";
			
			$test = fwrite($fp, iconv('UTF-8', 'windows-1251', $mytext)); // Запись в файл
			
			fclose($fp); //Закрытие файла
		}

        $currency_info = Currencies::model()->loadCurrenciesList();

        foreach($positions as $product) {
			$order_product = new OrdersProducts();
			$order_product->order_id = $order->id;
			$order_product->product_id = $product->product_id;
			$order_product->quantity = $product->getQuantity();
			$order_product->summ = ($order_product->quantity * PriceHelper::getPricePosition($product));
			$order_product->summ_byr = PriceHelper::calculateSummOfPosition($product, $currency_info);
            $order_product->product_url = $product->product_url;
            $order_product->model_info = $product->cart_model_info;
			$order_product->save();

            //$price = self::getPricePosition($position);
            //PriceHelper::formatPrice((PriceHelper::calculateSummOfPosition($product, $currency_info)), 3, 3, $currency_info, true)

            //$product_summ = PriceHelper::calculateSummOfPosition($product, $currency_info);

        }
		return $order;
	}
		
}