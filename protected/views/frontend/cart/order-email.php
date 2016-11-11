<?php

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="ru" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Заказ с сайта s-turbo.by</title>
        <style type="text/css">
 			
        /* стили для письма */
 
        </style>
    </head>
    
    <body>

		<h3 style="">Список товаров</h3>

		<table>
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
							<?php echo CHtml::textField('quantity', $product->getQuantity(), array( 'name'=>"quantity", 'maxlength'=>"4", 'size'=>"3", 'class'=>"inputbox11 inputbox-qty", 'id'=>"quantity-".$product->product_id, 'title'=>"Обновить количество в корзине")); ?>
						</td>

						<td align="center">
							<? $product_price = $product->getSumPrice(); ?>
							<p class="cart-price"><?=PriceHelper::formatPrice($product->product_price, $product->currency_id, 3)?></p>
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
		</div>
	</body>

</html>