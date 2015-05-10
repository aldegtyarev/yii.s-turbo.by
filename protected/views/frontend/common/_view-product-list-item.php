<div class="product-item product-list-item fLeft pos-rel">
	<div class="product-item-wr">
		<a href="<?=$data->product_url?>" class="product-title db bold text_c font-16 mt-15"><?=$data->product_name?></a>

		<div class="product-image mb-10" style="background-image: url(<?=$data->product_image ?>)"></div>

		<p class="small bold font-13">
			<span class="grey c_999"><? echo $data->getAttributeLabel('firm_id');?>:</span> <span class="c_fff"><?=$data->firm_name?></span><br />
			<span class="grey c_999"><? echo $data->getAttributeLabel('product_sku');?>:</span> <span class="c_fff"><?=$data->product_sku?></span>
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
					<p class="c_d70000 bold font-20"><?=number_format(($data->product_price * Yii::app()->params->usd_rate), 0, '.', ' ')?> бел.руб</p>
					<p class="c_000 bold font-16 mt-10"><?=number_format($data->product_price, 1, '.', ' ')?> у.е.</p>
				<?	//}	else	{	?>
					<? /*<p class="price"><?=number_format($data->product_price, 0, '.', ' ')?> у.е.</p> */ ?>
				<?	//}	?>
			<a href="<?=$data->product_url?>" class="button-red product-detail-tile pos-abs">Подробнее</a>
		</div>

	</div>
</div>