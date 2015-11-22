<table class="cart-summary width100">
	<? /*
	<thead>
		<tr>
			<th align="center" colspan="2">Название</th>
			<th align="center" width="150px">Количество</th>
			<th align="center" width="150px">Стоимость</th>
			<th align="center" width="150">Удаление</th>
		</tr>
	</thead>
	*/ ?>
	<tbody>
		<?	foreach($positions as $product) {	?>
			<? $product_url = $this->createUrl('shopproducts/detail', array('product'=> $product->product_id)); ?>
			<tr>
				<td class="cart-prod-img-cell">
					<? 
						if ($product->product_image) {
							echo CHtml::link(CHtml::image($params->product_images_liveUrl . 'thumb_'.$product->product_image, $product->product_name, array('class' => "cart-image radius-4")), $product_url, array('class' => "db", 'title'=>$product->product_name));
						}	else	{
							echo CHtml::link(CHtml::image($params->product_images_liveUrl . 'noimage.jpg', "", array('class' => "cart-image radius-4")), $product_url, array('class' => "db"));											
						}	
					?>									
				</td>
				<td class="cart-prod-name-cell">
					<? echo CHtml::link($product->product_name, $product_url, array('title' => $product->product_name, 'class'=>'bold')); ?>
				</td>

				<td class="cart-prod-qty-cell">
					<div class="cart-qty-block pos-rel">
						<?php echo CHtml::beginForm($this->createUrl('cart/updatecart')); ?>
							<?php echo CHtml::hiddenField('product_id', $product->product_id); ?>
							<?php echo CHtml::textField('quantity', $product->getQuantity(), array( 'name'=>"quantity", 'maxlength'=>"4", 'size'=>"3", 'class'=>"inputbox inputbox-qty", 'id'=>"quantity-".$product->product_id, 'title'=>"Обновить количество в корзине")); ?>						
							<button class="cart-qty cart-qty-dec db pos-abs">-</button>
							<button class="cart-qty cart-qty-inc db pos-abs">+</button>
						<?php echo CHtml::endForm(); ?>
					</div>
				</td>

				<td align="center">
					<? $product_price = $product->getSumPrice(); ?>
					<p class="c_d70000 bold font-20 text_c"><?=PriceHelper::formatPrice($product->product_price, $product->currency_id, 3)?></p>
				</td>

				<td align="center" class="remove-td">
					<? echo CHtml::link('×', $this->createUrl('cart/removefromcart', array('product_id'=> $product->product_id)), array('class' => 'cart-remove db c-fff', 'title' => "Удалить из корзины")); ?>
				</td>
			</tr>

		<?	}	?>

	</tbody>
</table>


<div class="p-10 fRight">

	<div class="cart-total">
		<p class="bold mb-10">Итого</p>
		<? $product_price = $app->shoppingCart->getCost(); ?>
		<p id="total-cost-usd" class="c_d70000 bold font-20"><?=PriceHelper::formatPrice($product_price, $product->currency_id, 3)?></p>
	</div>
	
	<div class="cart-btns1-cnt">
		<? echo CHtml::link('Продолжать покупки', '/', array('title' => 'Продолжать покупки', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-continue')); ?>
		<? echo CHtml::link('Оформить заказ', $this->createUrl('/cart/checkout'), array('title' => 'Оформить заказ', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-checkout')); ?>
	</div>


</div>