<?
$images_live_url = Yii::app()->params->images_live_url;
$webroot = Yii::getPathOfAlias('webroot');
$product_classes = "";
$isWidget = true;
?>

<div class="last-viewed-block">
	<div class="header-wr">
		<h3>Вы недавно просматривали</h3>
	</div>
	<ul class="last-viewed-list">
		<?	foreach($rows as $key=>$row) {	?>
			<? 
				if($isWidget)	{
					$product_url = $this->controller->createUrl('shopproducts/detail', array('product'=> $row->product_id)); 
				}	else	{
					$product_url = $this->createUrl('shopproducts/detail', array('product'=> $row->product_id)); 
				}
			?>

			<li class="last-viewed-item <?=$product_classes?>">
				<div class="last-viewed-item-wr" style="background-image: url(<?=$images_live_url.$row->file_url_thumb ?>)">
					<div class="last-viewed-item-pattern"></div>
					<a href="<?=$product_url?>" class="product-title"><?=$row->product_name?></a>

					<p class="status status-available"><?=$row->in_stock?></p>

					<div class="last-viewed-item-prices">
						<?//if($row->product_override_price != 0) {	?>
							<p class="price"><?=number_format($row->product_price, 0, '.', ' ')?> у.е.</p>
							<p class="price-byr"><?=number_format(($row->product_price * 16300), 0, '.', ' ')?> бел.руб</p>
						<?	//}	else	{	?>
							<? /*<div class="price"><?=number_format($row->product_price, 0, '.', ' ')?> у.е.</div> */ ?>
						<?	//}	?>
					</div>
				</div>


			</li>

		<?	}	?>





	</ul>
	<a href="#" class="all-items">Что еще смотрели?</a>
</div>