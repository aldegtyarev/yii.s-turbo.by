<?php

$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
$total_summ = $total_in_cart['summ'] + $delivery_cost;

?>
<h3 class="c_d70000 pl-20">Список товаров</h3>

<table class="cart-summary width100">

	<thead>
		<tr>
			<th></th>
			<th>Описание товара</th>
			<th class="text_c">Количество</th>
			<th class="text_c">Сумма</th>
			<th class="text_c" style="width:60px;">Удалить</th>
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
					<? echo CHtml::link($product->product_name, $product_url, array('title' => $product->product_name, 'class'=>'prod-name')); ?>
					
					<? if($product->product_availability > 0)	{	?>
						<?
						if($product->product_availability == 2) {
							$status_class = 'status-available';
						}	else	{
							$status_class = 'status-on-request';
						}

						$product_availability_text = $product->ProductAvailabilityArray[$product->product_availability]['name']. ' ' .$product->delivery;
						?>

						<span class="status list-item-row-status <?=$status_class?>"><?= $product_availability_text ?></span>
					<?	}	?>
					
					<p class="cart-model-info"><?php echo $product->cart_model_info ?></p>
				</td>

				<td class="cart-prod-qty-cell">
					<div class="cart-qty-block">
						<?php echo CHtml::beginForm($this->createUrl('cart/updatecart')); ?>
							<button class="cart-qty cart-qty-dec">-</button>
							<?php echo CHtml::hiddenField('product_id', $product->product_id, array('id'=>false)); ?>
							<div class="inputbox-qty-cnt">
								<?php echo CHtml::textField('quantity', $product->getQuantity(), array( 'name'=>"quantity", 'maxlength'=>"4", 'size'=>"3", 'class'=>"inputbox11 inputbox-qty", 'id'=>"quantity-".$product->product_id, 'title'=>"Обновить количество в корзине")); ?>
							</div>
							<button class="cart-qty cart-qty-inc">+</button>
						<?php echo CHtml::endForm(); ?>
					</div>
				</td>

				<td align="center">
					<? $product_price = $product->getSumPrice(); ?>
					<p id="cart-price-<?= $product->product_id ?>" class="cart-price"><?= PriceHelper::formatPrice((PriceHelper::calculateSummOfPosition($product, $currency_info)), 3, 3, $currency_info, true)?></p>
				</td>

				<td align="center" class="remove-td">
					<? echo CHtml::link('×', $this->createUrl('cart/removefromcart', array('product_id'=> $product->product_id)), array('class' => 'cart-remove db c-fff', 'title' => "Удалить из корзины")); ?>
				</td>
			</tr>

		<?	}	?>
		<tr class="cart-total-row">
			<td colspan="3"></td>
			<td class="cart-total">
				<p id="total-cost-txt" class="bold mb-10"><?= $delivery_cost ? 'Итого c доставкой' : 'Итого'?></p>
				<? //$product_price = $app->shoppingCart->getCost(); ?>
				<p id="total-cost-byr" class="cart-price"><?=PriceHelper::formatPrice($total_summ, 3, 3, $currency_info, true)?></p>				
			</td>
			<td></td>
		</tr>

	</tbody>
</table>