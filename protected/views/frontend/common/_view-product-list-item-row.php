<div class="product-item product-list-item product-list-item-row">
		<div class="product-item-wr clearfix">
			<? 
				if($data->product_availability == 2) {
					$status_class = 'status-available';
				}	else	{
					$status_class = 'status-on-request';
				}
								 
			?>
			<div class="product-list-item-row-image-block fLeft">
				<div class="product-image" style="background-image: url(<?=$data->product_image ?>)"></div>
				<? 
					if(count($data->AdditionalImages))	{
						echo CHtml::OpenTag('ul', array('class'=>'additional-images-list'));
						$i = 0;
						foreach($data->AdditionalImages as $img)	{
							$thumb_image_url = Yii::app()->params->product_images_liveUrl . 'thumb_'.$img;
							$image_url = Yii::app()->params->product_images_liveUrl . 'full_'.$img;
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
			<div class="product-list-item-row-info-block fLeft">
				<a href="<?=$data->product_url?>" class="product-title  db bold text_c font-16 mt-15"><?=$data->product_name?></a>

				<ul class="prod-list-char-list">
					<li class="prod-list-char-item arial font-10"><strong><? echo $data->getAttributeLabel('firm_id');?>:</strong> <?=$data->firm_name?></li>
					
					<li class="prod-list-char-item arial font-10"><strong><? echo $data->getAttributeLabel('product_sku');?>:</strong> <?=$data->product_sku?><br /><br /></li>
				</ul>
				
				<ul class="prod-list-char-list dt">
					
					<? if(!empty($data->side))	{	?>
						<li class="prod-list-char-item arial font-13 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('side');?>: </span><span class="dtc pb-5"><?=$data->ProductSideArray[$data->side]['name']?></span></li>
					<?	}	?>
					
					<? if(!empty($data->lamps))	{	?>
						<li class="prod-list-char-item arial font-13 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('lamps');?>: </span><span class="dtc pb-5"><?=nl2br($data->lamps)?></span></li>
					<?	}	?>
					
					<? if(!empty($data->adjustment))	{	?>
						<li class="prod-list-char-item arial font-13 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('adjustment');?>: </span><span class="dtc pb-5"><?=$data->adjustment?></span></li>
					<?	}	?>
					
					<? if(!empty($data->material))	{	?>
						<li class="prod-list-char-item arial font-13 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('material');?>: </span><span class="dtc pb-5"><?=$data->material?></span></li>
					<?	}	?>
					
					<? if(!empty($data->product_s_desc))	{	?>
						<li class="prod-list-char-item arial font-13 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('product_s_desc');?>: </span><span class="dtc pb-5"><?=nl2br($data->product_s_desc)?></span></li>
					<?	}	?>
					
					<? //if($this->show_models === false)	{	?>
					<? if($this->show_models)	{	?>
						<li class="prod-list-char-item arial font-13 dtr"><span class="dtc pr-5 pb-5 bold"><? echo $data->getAttributeLabel('model_ids');?>: </span><span class="dtc pb-5"><?=$data->modelsList?></span></li>
					<?	}	?>
					
				</ul>
			</div>
			<div class="product-list-item-row-price-block fLeft pl-20 text_c mt-10">
					<p class="c_d70000 bold font-20 text_c nowrap"><?=number_format(($data->product_price * Yii::app()->params->usd_rate), 0, '.', ' ')?> бел.руб</p>
					<p class="c_000 bold font-16 mt-10 text_c"><?=number_format($data->product_price, 1, '.', ' ')?> у.е.</p>
				
				<a href="<?=$data->product_url?>" class="button-red product-detail mt-10 mb-5">Подробнее</a>
				
				<? if($data->product_availability > 0)	{	?>
					<?
					if($data->product_availability == 2) {
						$status_class = 'status-available';
					}	else	{
						$status_class = 'status-on-request';
					}
					?>
				
					<p class="status product-list-item-row-status <?=$status_class?>"><?=$data->ProductAvailabilityArray[$data->product_availability]['name'] ?></p>
				<?	}	?>
				

				<?php 
					echo CHtml::beginForm($this->createUrl('/cart/addtocart'));
					echo Chtml::hiddenField('quantity', '1');
					echo Chtml::hiddenField('product_id', $data->product_id, array('id'=>'product_id'));
					echo CHtml::submitButton('Купить', array('name'=>'addtocart','id'=>'addtocart','class'=>'addtocart-button prod-list-addtocart-button add button-green mt-5 pointer','title'=>'Добавить этот товар в корзину'));
					echo CHtml::endForm(); 
				?>
				<p id="to-cart-process" class="to-cart-process pt-5 hidden">
					<span id="ajax-loading font-10"><img class="v-middle" src="/img/loading.gif" /> Обработка...</span>
				</p>
				<p id="cart-msg" class="cart-msg hidden pb-5 font-10"></p>
				
				
			</div>
			

		</div>
</div>