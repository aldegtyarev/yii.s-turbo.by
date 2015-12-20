<?php

?>

<div id="payment-list-cnt" class="payment-list-cnt cart-view item-page mb-40 p-20 bg-fff">
	<h3 class="c_d70000">Выберите способ оплаты вашего заказа</h3>
	
	<p id="payment-error" class="payment-error">Выберите способ оплаты</p>
	
	<div class="payment-list">
	
		<?php echo CHtml::hiddenField('payment_id', $payment_id, array ('id'=>'payment_id'))?>
		
		<div id="payment-list" class="clearfix">
			<? $this->renderPartial('_payment-list', array('rows'=>$rows, 'currency_info' => $currency_info, 'payment_id'=>$payment_id, 'delivery_id' => $delivery_id)) ?>
		</div>
		
	</div>
</div>