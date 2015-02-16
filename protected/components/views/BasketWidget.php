<div class="basket floatRight">
	<div class="sprite CartModule <? if($count_products == 0) { echo 'empty-cart'; }?>" id="CartModule">
	<div class="total_products">
		<? 
		if($count_products == 0) { 
			echo 'Корзина пуста'; 
		}	else	{
			echo '<span class="left">Товаров в корзине:</span> <span class="right">'.$count_products.' шт</span>';
		}
		?>
	</div>
	<div class="clr"></div>
	<div class="total">
		<? 
		if($count_products == 0) { 
			echo ''; 
		}	else	{
			echo '<span class="left">На сумму:</span> <span class="right">'.number_format($total_summ, 0, '.', ' ').'$</span>';
		}
		?>	
	</div>
	<div class="clr"></div>
	<div class="show_cart <? if($count_products == 0) { echo 'hidden'; }?>">
		<a href="/showcart.html">Показать корзину</a>
	</div>
	<div class="clr"></div>
	<noscript>Пожалуйста, подождите</noscript>
</div>
</div>
<?
/*
<div class="custom currier">
	<p><a href="/info/oplata-i-dostavka.html">Доставка "до дверей" по всей Беларуси</a> от 80.000 рублей</p></div>
</div>
*/
?>