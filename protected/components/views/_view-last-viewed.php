<div class="last-viewed-item">
	<div class="last-viewed-item-wr" style="background-image: url(<?=$data->file_url_thumb ?>)">
		<div class="last-viewed-item-pattern"></div>
		<a href="<?=$data->product_url?>" class="last-viewed-title"><?=$data->product_name?></a>

		<p class="last-viewed-status status status-available"><?=$data->in_stock?></p>

		<div class="last-viewed-item-prices">
			<p class="price-byr"><?=number_format(($data->product_price * Yii::app()->params['usd_rate']), 0, '.', ' ')?> бел.руб</p>
			<p class="price"><?=number_format($data->product_price, 0, '.', ' ')?> у.е.</p>
		</div>
	</div>
</div>
