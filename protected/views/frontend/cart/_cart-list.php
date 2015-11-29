<h3 class="c_d70000 pl-20">Список товаров</h3>

<table class="cart-summary width100">

	<thead>
		<tr>
			<th></th>
			<th>Описание товара</th>
			<th class="text_c">Количество</th>
			<th class="text_c">Цена</th>
			<th class="text_c">Удалить</th>
		</tr>
	</thead>

	<tbody>
		<?	foreach($positions as $product) {	?>
			<? 				//echo'$modelinfo<pre>';print_r($product);echo'</pre>';die;?>
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
					<p class="cart-model-info"><?php echo $product->cart_model_info ?></p>
				</td>

				<td class="cart-prod-qty-cell">
					<div class="cart-qty-block">
						<?php echo CHtml::beginForm($this->createUrl('cart/updatecart')); ?>
							<button class="cart-qty cart-qty-dec">-</button>
							<?php echo CHtml::hiddenField('product_id', $product->product_id); ?>
							<div class="inputbox-qty-cnt">
								<?php echo CHtml::textField('quantity', $product->getQuantity(), array( 'name'=>"quantity", 'maxlength'=>"4", 'size'=>"3", 'class'=>"inputbox11 inputbox-qty", 'id'=>"quantity-".$product->product_id, 'title'=>"Обновить количество в корзине")); ?>
							</div>
							<button class="cart-qty cart-qty-inc">+</button>
						<?php echo CHtml::endForm(); ?>
					</div>
				</td>

				<td align="center">
					<? $product_price = $product->getSumPrice(); ?>
					<p class="cart-price"><?=PriceHelper::formatPrice($product->product_price, $product->currency_id, 3)?></p>
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
		<p id="total-cost-usd" class="cart-price"><?=PriceHelper::formatPrice($product_price, $product->currency_id, 3)?></p>
	</div>
	<?/*
	<div class="cart-btns1-cnt clearfix">
		<? echo CHtml::link('Вернуться к товарам', '/category/index.html', array('title' => 'Вернуться к товарам', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-continue')); ?>
		<? echo CHtml::link('Оформить заказ', $this->createUrl('/cart/checkout'), array('title' => 'Оформить заказ', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-checkout')); ?>
	</div>
	*/?>


</div>