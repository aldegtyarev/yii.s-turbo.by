<?php


?>


<?php if($count_products)	{	?>
	<div id="cartBlock" class="cartBlock">
		<a href="<?= $show_cart_url ?>" class="to-cart">
			<span class="cart-row cart-row-1">
				<span class="cart-row-left">В корзине</span>
				<span class="cart-row-right"><span id="products-count"><?=$count_products .' '. Yii::t('app', 'товар|товара|товаров', $count_products)?></span></span>
			</span>
			<span class="cart-row cart-row-2">
				<span class="cart-row-left">На сумму</span>
				<span class="cart-row-right"><span id="cart-total"><?=PriceHelper::formatPrice($total_summ, 3, 3, $currency_info, true)?></span></span>
			</span>
		</a>		
	</div>
<?php	}	else	{	?>
	<div id="cartBlock" class="cartBlock cartBlockEmpty">
		<a href="<?= $show_cart_url ?>" class="to-cart">
			<span>Корзина пуста</span>
		</a>
	</div>
<?php	}	?>