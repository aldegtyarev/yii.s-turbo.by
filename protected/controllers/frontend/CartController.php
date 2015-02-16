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
		
		$message = 'Товар был добавлен в корзину.';
		
		$positions = $app->shoppingCart->getPositions();
		
		foreach($positions as $position) {
			if($position->product_id == $product_id) {
				$message = 'Количество товара было обновлено.';
				
			}
		}
		
		if($product_id && $quantity) {
			$model = ShopProducts::model()->findByPk($product_id);
			$app->shoppingCart->put($model, $quantity);
			$msg = array(
				'res'		=>	'ok',
				'total'		=>	'<span class="left">Товаров в корзине:</span> <span class="right">'.$app->shoppingCart->getCount().' шт</span>',
				'summ'		=>	'<span class="left">На сумму:</span> <span class="right">'.number_format($app->shoppingCart->getCost(), 0, '.', ' ').'$</span>',
				'message'	=>	$message,
			);
		}	else	{
			$msg = array('res' => 'err');
		}
		echo json_encode($msg);
		//$this->render('index');
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
	
	

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}