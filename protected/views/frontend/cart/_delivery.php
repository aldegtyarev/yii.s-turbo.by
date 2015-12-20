<?php
//echo'<pre>';print_r($_POST);echo'</pre>';//die;
?>

<div id="delivery-list-cnt" class="delivery-list-cnt cart-view item-page mb-40 p-20 bg-fff">
	<h3 class="c_d70000">Выберите способ доставки вашего заказа</h3>
	
	<p id="delivery-error" class="delivery-error">Выберите способ доставки</p>
	
	<div class="delivery-list">
	
		<?php echo CHtml::hiddenField('delivery_id', $delivery_id, array ('id'=>'delivery_id'))?>
		<?php echo CHtml::hiddenField('deliveryQuick', $delivery_quick, array ('id'=>'delivery_quick'))?>
		
		<div id="delivery-list">
			<? $this->renderPartial('_delivery-list', array('rows'=>$rows, 'currency_info' => $currency_info, 'delivery_id'=>$delivery_id, 'delivery_quick'=>$delivery_quick)) ?>
		</div>
		
	</div>
</div>