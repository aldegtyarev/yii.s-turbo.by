<div class="product-item product-list-item fLeft pos-rel">
	<div class="product-item-wr">
		<a href="<?=$data->product_url?>" class="product-title db bold text_c font-12"><?=$data->product_name?></a>

		<div class="product-image mb-10" style="background-image: url(<?=$data->product_image ?>)"></div>

		<p class="small font-13">
			<span class="grey c_999"><? echo $data->getAttributeLabel('firm_id');?>:</span> <span class="c_fff"><?=$data->firm_name?></span><br />
			<span class="grey c_999"><? echo $data->getAttributeLabel('product_sku');?>:</span> <span class="c_fff"><?=$data->product_sku?></span>
			<?php if($data->manufacturer_sku)	{	?>
				<br /><span class="grey c_999"><? echo $data->getAttributeLabel('manufacturer_sku');?>:</span> <span class="c_fff"><?=$data->manufacturer_sku?></span>
			<?php	}	?>
		</p>
		

		<?	if($data->product_availability > 0)	{
				if($data->product_availability == 2) {
					$status_class = 'status-available';
				}	else	{
					$status_class = 'status-on-request';
				}
		?>
		<p class="status <?=$status_class?>"><?=$data->ProductAvailabilityArray[$data->product_availability]['name'] ?></p>
		<?	}	?>
		<div class="product-list-item-bottom pos-abs">
				<?//if($data->product_override_price != 0) {	?>
					<p class="c_d70000 bold font-16"><?=PriceHelper::formatPrice($data->product_price, $data->currency_id, 3)?></p>
					<p class="c_000 bold font-12 mt-10"><?=PriceHelper::formatPrice($data->product_price, $data->currency_id)?></p>
				<?	//}	else	{	?>
					<? /*<p class="price"><?=number_format($data->product_price, 0, '.', ' ')?> у.е.</p> */ ?>
				<?	//}	?>
				<?php echo CHtml::beginForm('/addtocart.html'); ?>
					<p class="to-cart-process pt-5 hidden">
						<span class="ajax-loading font-10"><img class="v-middle" src="/img/loading.gif" /> Обработка...</span>
					</p>
					<p class="cart-msg hidden pb-5 font-10"></p>

				
				<?php 
					echo Chtml::hiddenField('quantity', '1', array('class'=>'quantity', 'id'=>false));
					echo Chtml::hiddenField('product_id', $data->product_id, array('class'=>'product_id', 'id'=>false));
					echo CHtml::submitButton('В корзину', array('name'=>'addtocart','id'=>false,'class'=>'db addtocart addtocart-button add-tocart-btn hide-text pointer pos-abs','title'=>'Добавить этот товар в корзину'));
					echo CHtml::endForm(); 
				?>
				
			<a href="<?=$data->product_url?>" class="sprite product-detail-tile pos-abs hide-text" title="<?=$data->product_name?>">Подробнее</a>
		</div>

	</div>
</div>