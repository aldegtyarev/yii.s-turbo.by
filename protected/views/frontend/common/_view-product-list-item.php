<div class="product-item product-list-item">
	<div class="product-item-wr">
		<a href="<?=$data->product_url?>" class="product-title"><?=$data->product_name?></a>

		<div class="product-image" style="background-image: url(<?=$data->product_image ?>)"></div>

		<p class="small">
			<span class="grey"><? echo $data->getAttributeLabel('firm_id');?>:</span> <span><?=$data->firm_name?></span><br />
			<span class="grey"><? echo $data->getAttributeLabel('product_sku');?>:</span> <span><?=$data->product_sku?></span>
		</p>

		<? if($data->product_availability > 0)	{	?>
		<? 
			if($data->product_availability == 2) {
				$status_class = 'status-available';
			}	else	{
				$status_class = 'status-on-request';
			}
		?>
		<p class="status <?=$status_class?>"><?=$data->ProductAvailabilityArray[$data->product_availability]['name'] ?></p>
		<?	}	?>
		<div class="product-bottom clearfix">
			<div class="product-prices">
				<?//if($data->product_override_price != 0) {	?>
					<p class="price"><?=number_format($data->product_price, 1, '.', ' ')?> у.е.</p>
					<p class="price-byr"><?=number_format(($data->product_price * Yii::app()->params->usd_rate), 0, '.', ' ')?> бел.руб</p>
				<?	//}	else	{	?>
					<? /*<p class="price"><?=number_format($data->product_price, 0, '.', ' ')?> у.е.</p> */ ?>
				<?	//}	?>
			</div>
			<a href="<?=$data->product_url?>" class="button product-detail">Подробнее</a>
		</div>

	</div>
</div>