<? foreach($rows as $key=>$row) {	?>
	<li class="product-item product-list-item <?=$product_classes?>">
		<div class="product-item-wr">
			<? 
				if($key == 1 || $key == 3) {
					echo '<span class="product-label new-product">Новинка</span>';
				}
				if($isWidget)	{
					//$product_url = $this->controller->createUrl('shopproducts/detail', array('path'=> 'product/'.$row->product_id)); 
					$product_url = $this->controller->createUrl('shopproducts/detail', array('product'=> $row->product_id)); 
				}	else	{
					//$product_url = $this->createUrl('shopproducts/detail', array('path'=> 'product/'.$row->product_id)); 
					$product_url = $this->createUrl('shopproducts/detail', array('product'=> $row->product_id)); 
				}
			?>
			<a href="<?=$product_url?>" class="product-title"><?=$row->product_name?></a>
			<?
				//var_dump($row->product_image);
				//if($row->product_image)	{
					$product_image = $params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.jpg');
				//}
			?>
			<div class="product-image" style="background-image: url(<?=$product_image ?>)"></div>
			<p class="small">Производитель: <span><?=$row->manuf?></span><br />Артикул: <span><?=$row->product_sku?></span></p>
			
			<? if($row->product_availability > 0)	{	?>
			<? 
				if($row->product_availability == 2) {
					$status_class = 'status-available';
				}	else	{
					$status_class = 'status-on-request';
				}
			?>
			<p class="status <?=$status_class?>"><?=$row->ProductAvailabilityArray[$row->product_availability]['name'] ?></p>
			<?	}	?>
			<div class="product-bottom clearfix">
				<div class="product-prices">
					<?//if($row->product_override_price != 0) {	?>
						<p class="price"><?=number_format($row->product_price, 0, '.', ' ')?> у.е.</p>
						<p class="price-byr"><?=number_format(($row->product_price * 16300), 0, '.', ' ')?> бел.руб</p>
					<?	//}	else	{	?>
						<? /*<p class="price"><?=number_format($row->product_price, 0, '.', ' ')?> у.е.</p> */ ?>
					<?	//}	?>
				</div>
				<a href="<?=$product_url?>" class="button product-detail">Подробнее</a>
			</div>

		</div>
	</li>
						
<?	}	?>



