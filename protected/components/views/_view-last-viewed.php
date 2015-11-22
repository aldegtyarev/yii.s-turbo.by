<div class="last-viewed-item">
	<div class="last-viewed-item-wr" style="background-image: url(<?=$data->file_url_thumb ?>)">
		<div class="last-viewed-item-pattern"></div>
		<a href="<?=$data->product_url?>" class="last-viewed-title"><?=$data->product_name?></a>

		<p class="last-viewed-status status status-available"><?=$data->in_stock?></p>

		<div class="last-viewed-item-prices">
			<p class="price-byr"><?=PriceHelper::formatPrice($data->product_price, $data->currency_id, 3)?></p>
			<?/*<p class="price"><?=PriceHelper::formatPrice($data->product_price)?></p>*/?>
		</div>
	</div>
</div>
