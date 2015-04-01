
<?
// http://yii.s-turbo.by/category/3470.html

//echo'<pre>';print_r($firms);echo'</pre>';

?>

<? foreach($rows as $key=>$row) {	?>
	<li class="product-item product-list-item product-list-item-row <?=$product_classes?>">
		<div class="product-item-wr clearfix">
			<? 
				if($key == 1 || $key == 3) {
					echo '<span class="product-label new-product">Новинка</span>';
				}
								 
				$product_url = $this->createUrl('shopproducts/detail', array('product'=> $row->product_id)); 
				$product_image = $params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.jpg');

				if($row->product_availability == 2) {
					$status_class = 'status-available';
				}	else	{
					$status_class = 'status-on-request';
				}
								 
			?>
			<div class="product-list-item-row-image-block">
				<div class="product-image" style="background-image: url(<?=$product_image ?>)"></div>
				<? 
					if(count($row->AdditionalImages))	{
						echo CHtml::OpenTag('ul', array('class'=>'additional-images-list'));
						$i = 0;
						foreach($row->AdditionalImages as $img)	{
							$thumb_image_url = $params->product_images_liveUrl . 'thumb_'.$img;
							$image_url = $params->product_images_liveUrl . 'full_'.$img;
							echo CHtml::OpenTag('li', array('class'=>'additional-images-list-item'));
							echo CHtml::link(CHtml::image($thumb_image_url), $image_url, array('class' => "fancybox", "rel" => "group"));
							echo CHtml::CloseTag('li');
							$i++;
							if($i > 2) break;
						}
						echo CHtml::CloseTag('ul');
					}
				?>
				
			</div>
			<div class="product-list-item-row-info-block">
				<a href="<?=$product_url?>" class="product-title"><?=$row->product_name?></a>

				<ul class="prod-list-char-list">
					<li class="prod-list-char-item arial font-10"><strong>Производитель:</strong> <?=$firms[$row->firm_id]['name']?></li>
					
					<li class="prod-list-char-item arial font-10"><strong>Артикул:</strong> <?=$row->product_sku?><br /><br /></li>
					
					<? if(!empty($row->side))	{	?>
						<li class="prod-list-char-item arial font-13"><strong>Сторона:</strong> <?=$row->ProductSideArray[$row->side]['name']?></li>
					<?	}	?>
					
					<? if(!empty($row->lamps))	{	?>
						<li class="prod-list-char-item arial font-13"><strong>Лампочки:</strong> <?=$row->lamps?></li>
					<?	}	?>
					
					<? if(!empty($row->adjustment))	{	?>
						<li class="prod-list-char-item arial font-13"><strong>Регулировка:</strong> <?=$row->adjustment?></li>
					<?	}	?>
					
					<? if(!empty($row->material))	{	?>
						<li class="prod-list-char-item arial font-13"><strong>Материал:</strong> <?=$row->material?></li>
					<?	}	?>
					
					<? if(!empty($row->product_s_desc))	{	?>
						<li class="prod-list-char-item arial font-13"><strong>Описание:</strong> <?=$row->product_s_desc?></li>
					<?	}	?>
					
				</p>
				
			</div>
			<div class="product-list-item-row-price-block">
				<div class="product-prices">
					<p class="price"><?=number_format($row->product_price, 0, '.', ' ')?> у.е.</p>
					<p class="price-byr"><?=number_format(($row->product_price * 16300), 0, '.', ' ')?> бел.руб</p>
				</div>
				
				<a href="<?=$product_url?>" class="button product-detail">Подробнее</a>
				
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
				
			</div>
			

		</div>
	</li>
						
<?	}	?>



