<?php if($count_products)	{	?>
	<div class="cartBlock pos-rel floatRight pr-15">
		<a href="<?=$this->controller->createUrl('/cart/showcart')?>" class="to-cart db hide-text underline_n_n pos-abs">В корзину</a>
		<p class="cart-row cart-row-1 pos-abs">
			<span class="cart-row-left db text_r floatLeft font-12 c_777">Количество товара:</span>
			<span class="cart-row-right db text_r floatLeft font-12 c_d70000"><span id="products-count"><?=$count_products?></span>шт.</span>

		</p>
		<p class="cart-row cart-row-2 pos-abs">
			<span class="cart-row-left db text_r floatLeft font-12 c_777">Сумма товара:</span>
			<span class="cart-row-right db text_r floatLeft font-12 c_d70000"><span id="cart-total"><?=Yii::app()->NumberFormatter->formatDecimal($total_summ); ?></span> у.е.</span>

		</p>
	</div>
<?php	}	else	{	?>
	<div class="cartBlock cartBlockEmpty pos-rel floatRight pr-15">
		<a href="<?=$this->controller->createUrl('/cart/showcart')?>" class="to-cart db hide-text underline_n_n pos-abs">В корзину</a>
		<span>Корзина пуста</span>
	</div>
<?php	}	?>