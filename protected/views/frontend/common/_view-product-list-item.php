<div class="product-item product-list-item fLeft">
	<div id="product-image-cnt-<?= $data->product_id ?>" class="product-item-wr">
		<a href="<?=$data->product_url?>" class="product-title" title="<?=$data->product_name?>">
			<span class="product-title-name"><?=$data->product_name?></span>
			<?/*<span id="product-image-<?= $data->product_id ?>" class="product-image<?php if($data->featured == 1) echo ' product-image-featured' ?>" style="background-image: url(<?=$data->product_image ?>)"></span>*/?>
			<span class="product-image-cnt">
				<img id="product-image-<?= $data->product_id ?>" class="product-image<?php if($data->featured == 1) echo ' product-image-featured' ?>" src="<?=$data->product_image ?>" alt="<?=$data->product_name?>">
			</span>
		</a>
		<p class="small font-13">
			<span class="c_777"><? echo $data->getAttributeLabel('firm_id');?>:</span> <span class="c_0001"><?=$data->firm_name?></span><br />
			<span class="c_777"><? echo $data->getAttributeLabel('product_sku');?>:</span> <span class="c_0001"><?=$data->product_sku?></span>
		</p>
		
		<div class="product-list-item-bottom-cnt">
			<div class="product-list-item-bottom">
					<? if($data->percent_discount < 0)	{	?>
						<p class="product-list-item-row-price-byr"><?=PriceHelper::formatPrice($data->product_override_price, $data->currency_id, 3, $currency_info, true)?></p>
						<p class="product-list-item-row-price-usd"><?=PriceHelper::formatPrice($data->product_override_price, $data->currency_id, 0, $currency_info)?></p>
					<?	}	else	{	?>
						<p class="product-list-item-row-price-byr"><?=PriceHelper::formatPrice($data->product_price, $data->currency_id, 3, $currency_info, true)?></p>
						<p class="product-list-item-row-price-usd"><?=PriceHelper::formatPrice($data->product_price, $data->currency_id, 0, $currency_info)?></p>
					<?	}	?>
					<?php echo CHtml::beginForm('/addtocart.html'); ?>
						<p class="to-cart-process pt-5 hidden">
							<span class="ajax-loading font-10"><img class="v-middle" src="/img/loading.gif" alt="Обработка" /> Обработка...</span>
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
</div>