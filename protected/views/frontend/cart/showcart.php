<?
$app = Yii::app();
?>
<div class="cart-view item-page">
	
	<h1>Корзина</h1>

	<?if(count($positions) != 0) {?>
		<div class="cart-list">
			<table class="cart-summary" cellspacing="0" cellpadding="0" width="100%" border="0">
				<thead>
					<tr>
						<th align="center">Название</th>
						<th align="center" width="150px">Количество</th>
						<th align="center" width="150px">Стоимость</th>
						<th align="center" width="150">Удаление</th>
					</tr>
				</thead>
				<tbody>
					<?	foreach($positions as $product) {	?>
						<? $product_url = $this->createUrl('shopproducts/detail', array('path'=> $category->path.'/'.$product->slug.'-detail')); ?>
						<tr valign="top" class="sectiontableentry1">
							<td valign="middle" align="left">

								<span class="cart-images">
									
									<?	
										if(isset($product->shopProductsMediases[0]))	{
											$image_url = $app->homeUrl . DIRECTORY_SEPARATOR . $product->shopProductsMediases[0]->media->file_url_thumb;
										}	else	{
											$image_url = $app->homeUrl . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'noimage.gif';
										}
										//echo CHtml::image($image_url, $product->product_name);
										echo CHtml::link(CHtml::image($image_url, $product->product_name), $product_url, array('title' => $product->product_name));
									?>
									<? /*<img alt="<?=$position->product_name?>" src="/images/stories/virtuemart/product/resized/dd_215x215.jpg"> */ ?>
								</span>
								<?
								//echo'<pre>';print_r($product,0);echo'</pre>';
								?>
								<?echo CHtml::link($product->product_name, $product_url, array('title' => $product->product_name)); ?>
								<? /*<a href="/tyuning-alfa-romeo/gtv-spider/aksessuary/led-ramka-nomera-s-podsvetkoj-nadpisi-ram001-detail.html">LED рамка номера с подсветкой надписи</a>	*/ ?>
							</td>
							
							<td valign="middle" align="center">
								<form class="inline" method="post" action="<?=$this->createUrl('cart/updatecart')?>">
									<input type="hidden" value="<?=$product->product_id?>" name="product_id">
									<input type="text" value="<?=$product->getQuantity()?>" name="quantity" maxlength="4" size="3" class="inputbox" title="Обновить количество в корзине">
									<input type="hidden" value="update" name="task">
									<input type="submit" align="middle" value="Обновить" title="Обновить количество в корзине" name="update" class="vmicon vm2-add_quantity_cart">
								</form>
							</td>

							<td valign="middle" align="center" colspan="1">
								<div class="PricesalesPrice"><span class="PricesalesPrice"><?=$product->getSumPrice()?>$</span></div>
							</td>

							<td valign="middle" align="center" class="remove-td">
								<?echo CHtml::link('Удалить товар', $this->createUrl('cart/removefromcart', array('product_id'=> $product->product_id)), array('title' => "Удаление товаров из корзины")); ?>
								<? /*<a href="/magazin-tyuninga/cart/delete.html?cart_virtuemart_product_id=8001" align="middle" title="Удаление товаров из корзины" class="vmicon vm2-remove_from_cart">Удалить товар</a>*/ ?>
							</td>
						</tr>
						
					<?	}	?>

				</tbody>
			</table>
		</div>
		
		<div class="total-block">
			<div class="row clearfix">
				<div class="label">Общая стоимость товаров:  </div>
				<div class="value">
					<div class="PricesalesPrice"><span class="PricesalesPrice"><?=$app->shoppingCart->getCost()?>$</span></div>
				</div>
			</div>
			<?
			/*
			<div class="row clearfix">
				<div class="label">Стоимость товаров со скидкой 10%:  </div>
				<div class="value">
					<div style="display : block;" class="PricesalesPrice"><span class="PricesalesPrice">131$</span></div>
				</div>
			</div>
			*/
			?>
		</div>
    		
	<? } else {?>
		<div class="cart-empty">Ваша корзина пуста</div>
	<? }?>

</div>

<div class="cart-view item-page">

	<div>

	
</div>

	<form action="/magazin-tyuninga/cart/checkout.html" name="checkoutForm" id="checkoutForm" method="post">

		
		
		<div class="checkout-button-top">



			<a href="/" class="vm-button-continue">Продолжить покупки</a><a href="javascript:document.checkoutForm.submit();" class="vm-button-correct"><span>Оформить заказ</span></a>
		</div>

		


		<input type="hidden" value="checkout" name="task">

		<input type="hidden" value="com_virtuemart" name="option">

		<input type="hidden" value="cart" name="view">

	</form>

    
</div>


				  					                     
				  			</div>