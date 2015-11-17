<div class="product-item product-list-item product-list-item-row <?php if($data->side == 2) echo 'product-list-item-right-side' ?>">
		<div class="product-item-wr clearfix">
			<? 
				if($data->product_availability == 2) {
					$status_class = 'status-available';
				}	else	{
					$status_class = 'status-on-request';
				}
								 
			?>
			<div class="product-list-item-row-image-block fLeft">
				<div class="product-image<?php if($data->featured == 1) echo ' product-image-featured' ?>" style="background-image: url(<?=$data->product_image ?>)"></div>
				<?php/* 
					if(count($data->AdditionalImages))	{
						echo CHtml::OpenTag('ul', array('class'=>'additional-images-list'));
						$i = 0;
						foreach($data->AdditionalImages as $img)	{
							$thumb_image_url = Yii::app()->params->product_images_liveUrl . 'thumb_'.$img['image_file'];
							$image_url = Yii::app()->params->product_images_liveUrl . 'full_'.$img['image_file'];
							echo CHtml::OpenTag('li', array('class'=>'additional-images-list-item'));
							echo CHtml::link(CHtml::image($thumb_image_url), $image_url, array('class' => "fancybox add-prod-img", "rel" => "group", 'data-fullsrc'=>$image_url));
							echo CHtml::CloseTag('li');
							$i++;
							if($i > 2) break;
						}
						echo CHtml::CloseTag('ul');
					}*/
				?>
				
				<div class="popup-prod-img hidden">
					<?php 
						$full_image_url = str_replace('thumb_', 'full_', $data->product_image);
						echo CHtml::image('#', '', array('data-fullsrc'=>$full_image_url, 'class'=>'popup-full-img db'));

						if(count($data->AdditionalImages))	{
							
							echo CHtml::OpenTag('div', array('class'=>'additional-images-wr'));
							echo CHtml::OpenTag('ul', array('class'=>'popup-add-images'));

							echo CHtml::OpenTag('li', array('class'=>'additional-images-list-item'));
							echo CHtml::image('#', '', array('data-thmbsrc'=>$data->product_image, 'data-fullsrc'=>$full_image_url, 'class'=>'popup-thmb-img'));
							echo CHtml::CloseTag('li');

							foreach($data->AdditionalImages as $img)	{
								//echo'<pre>';print_r($img);echo'</pre>';
								//$thumb_image_url = Yii::app()->params->product_images_liveUrl . 'thumb_'.$img['image_file'];
								$thumb_image_url = Yii::app()->params->product_images_liveUrl . 'thumb_'.$img;
								//$image_url = Yii::app()->params->product_images_liveUrl . 'full_'.$img['image_file'];
								$image_url = Yii::app()->params->product_images_liveUrl . 'full_'.$img;
								echo CHtml::OpenTag('li', array('class'=>'additional-images-list-item'));
								echo CHtml::image('#', '', array('data-thmbsrc'=>$thumb_image_url, 'data-fullsrc'=>$image_url, 'class'=>'popup-thmb-img'));
								echo CHtml::CloseTag('li');
								$i++;
							}
							echo CHtml::CloseTag('ul');
							echo CHtml::CloseTag('div');
						}
					?>
				</div>
				
			</div>
			<div class="product-list-item-row-info-block fLeft">
				<a href="<?=$data->product_url?>" class="product-title  db bold text_c font-12 mt-15"><?=$data->product_name?></a>

				<ul class="prod-list-char-list prod-list-char-list-p1">
					<li class="prod-list-char-item arial font-10"><span class="c_777"><? echo $data->getAttributeLabel('firm_id');?>:</span> <?=$data->firm_name?></li>
					
					<?/*
					<?php if($data->manufacturer_sku)	{	?>
						<li class="prod-list-char-item arial font-10"><span class="c_999"><? echo $data->getAttributeLabel('manufacturer_sku');?>:</span> <?=$data->manufacturer_sku?></li>
					<?php	}	?>
					*/?>
					
					<li class="prod-list-char-item arial font-10"><span class="c_777"><? echo $data->getAttributeLabel('product_sku');?>:</span> <?=$data->product_sku?></li>
					
				</ul>
				
				<ul class="prod-list-char-list dt">
					
					<? if(!empty($data->side))	{	?>
						<li class="prod-list-char-item arial font-11 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('side');?>: </span><span class="dtc pb-5"><?=$data->ProductSideArray[$data->side]['name']?></span></li>
					<?	}	?>
					
					<? if(!empty($data->lamps))	{	?>
						<li class="prod-list-char-item arial font-11 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('lamps');?>: </span><span class="dtc pb-5"><?=nl2br($data->lamps)?></span></li>
					<?	}	?>
					
					<? if(!empty($data->adjustment))	{	?>
						<li class="prod-list-char-item arial font-11 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('adjustment');?>: </span><span class="dtc pb-5"><?=$data->adjustment?></span></li>
					<?	}	?>
					
					<? if(!empty($data->material))	{	?>
						<li class="prod-list-char-item arial font-11 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('material');?>: </span><span class="dtc pb-5"><?=$data->material?></span></li>
					<?	}	?>
					
					<? if(!empty($data->product_s_desc))	{	?>
						<li class="prod-list-char-item arial font-11 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('product_s_desc');?>: </span><span class="dtc pb-5"><?=nl2br($data->product_s_desc)?></span></li>
					<?	}	?>
					
					<? //if($this->show_models === false)	{	?>
					<? if($this->show_models && $data->modelsList != 'Универсальные товары' && $data->modelsList != '')	{	?>
						<li class="prod-list-char-item arial font-11 dtr"><span class="dtc pr-5 pb-5 bold nowrap">Подходит для: </span><span class="dtc pb-5"><?=$data->modelsList?></span></li>
					<?	}	?>
					
				</ul>
			</div>
			<div class="product-list-item-row-price-block fLeft pl-20 text_c mt-5">
				<p class="c_d70000 bold font-16 text_c nowrap"><?=PriceHelper::formatPrice($data->product_price, $data->currency_id, 3)?></p>
				<p class="c_000 bold font-12 mt-10 text_c"><?=PriceHelper::formatPrice($data->product_price, $data->currency_id)?></p>
				
				<? if($data->product_availability > 0)	{	?>
					<?
					if($data->product_availability == 2) {
						$status_class = 'status-available';
					}	else	{
						$status_class = 'status-on-request';
					}
					?>
				
					<p class="status list-item-row-status <?=$status_class?>"><?=$data->ProductAvailabilityArray[$data->product_availability]['name'] ?></p>
				<?	}	?>
				

				
				<?php 
					echo CHtml::beginForm($this->createUrl('/cart/addtocart'));
					echo Chtml::hiddenField('quantity', '1', array('class'=>'quantity', 'id'=>false));
					echo Chtml::hiddenField('product_id', $data->product_id, array('class'=>'product_id', 'id'=>false));
					echo CHtml::submitButton('В корзину', array('name'=>'addtocart','class'=>'addtocart addtocart-button prod-list-addtocart-button add button-green mt-5 pointer','title'=>'Добавить этот товар в корзину'));
					
				?>
					<p class="to-cart-process pt-5 hidden">
						<span class="ajax-loading font-10"><img class="v-middle" src="/img/loading.gif" /> Обработка...</span>
					</p>
					<p class="cart-msg hidden font-10"></p>
				<?php echo CHtml::endForm(); ?>
				
				<a href="<?=$data->product_url?>" class="button-red product-detail mt-10 mb-5">Подробнее</a>				
				
			</div>
			

		</div>
</div>