<div class="product-item product-list-item product-list-item-row <?php if($data->side == 2) echo 'product-list-item-right-side' ?>">
	<div class="product-item-wr clearfix">
		<? 
			if($data->product_availability == 2) {
				$status_class = 'status-available';
			}	else	{
				$status_class = 'status-on-request';
			}
		?>
		<div id="product-image-cnt-<?= $data->product_id ?>" class="product-list-item-row-image-block">
			<img id="product-image-<?= $data->product_id ?>" class="product-image<?php if($data->featured == 1) echo ' product-image-featured' ?>" src="<?=$data->product_image ?>" alt="<?=$data->product_name?>">
			<div class="popup-prod-img">
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
							$thumb_image_url = Yii::app()->params->product_images_liveUrl . 'thumb_'.$img['image_file'];
							$image_url = Yii::app()->params->product_images_liveUrl . 'full_'.$img['image_file'];
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

		<div class="product-list-item-row-info-block">
			<a href="<?=$data->product_url?>" class="product-title db bold text_c font-12 mt-15"><?=$data->product_name?></a>

			<? if($data->product_availability > 0)	{	?>
				<?
				if($data->product_availability == 2) {
					$status_class = 'status-available';
				}	else	{
					$status_class = 'status-on-request';
				}

				$product_availability_text = $data->ProductAvailabilityArray[$data->product_availability]['name']. ' ' .$data->delivery;
				?>

				<span class="status list-item-row-status <?=$status_class?>"><?= $product_availability_text ?></span>
			<?	}	?>

			<ul class="prod-list-char-list prod-list-char-list-p1">
				<li class="prod-list-char-item arial font-10"><span class="c_777"><? echo $data->getAttributeLabel('firm_id');?>:</span> <?=$data->firm_name?></li>
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

				<? if($this->show_models && $data->modelsList != 'Универсальные товары' && $data->modelsList != '')	{	?>
					<li class="prod-list-char-item arial font-11 dtr"><span class="dtc pr-5 pb-5 bold nowrap">Подходит для: </span><span class="dtc pb-5"><?=$data->modelsList?></span></li>
				<?	}	?>

			</ul>
		</div>
		<div class="product-list-item-row-price-block">
			<? if($data->percent_discount < 0)	{	?>
				<p class="product-list-item-row-price-override-cnt"><span class="product-list-item-row-price-override"><?= PriceHelper::formatPrice($data->product_price, $data->currency_id, 3, $currency_info, true)?></span><span class="percent_discount"><?= $data->percent_discount ?>%</span></p>
				<p class="product-list-item-row-price-byr"><?= PriceHelper::formatPrice($data->product_override_price, $data->currency_id, 3, $currency_info, true)?></p>
				<p class="product-list-item-row-price-usd"><?= PriceHelper::formatPrice($data->product_override_price, $data->currency_id, 0, $currency_info)?></p>
			<?	}	else	{	?>
				<p class="product-list-item-row-price-byr"><?= PriceHelper::formatPrice($data->product_price, $data->currency_id, 3, $currency_info, true)?></p>
				<p class="product-list-item-row-price-usd"><?= PriceHelper::formatPrice($data->product_price, $data->currency_id, 0, $currency_info)?></p>
			<?	}	?>


			<?php echo CHtml::beginForm($this->createUrl('/cart/addtocart')); ?>
				<? if($data->free_delivery != 0)	{	?>
					<p class="product-list-item-row-free-delivery">+ бесплатная доставка</p>
				<?	}	else	{	?>
					<p class="product-list-item-row-delivery-cost">
						<a class="fancybox-delivery" href="#delivery-<?= $data->product_id ?>" rel="nofollow">стоимость доставки</a>
						<img src="/img/question_ico.gif" alt="стоимость доставки" class="product-list-item-row-delivery-cost-ico">

					</p>
				<?	}	?>

			<?php
				echo Chtml::hiddenField('quantity', '1', array('class'=>'quantity', 'id'=>false));
				echo Chtml::hiddenField('product_id', $data->product_id, array('class'=>'product_id', 'id'=>false));
				echo CHtml::submitButton('В корзину', array('name'=>'addtocart','class'=>'addtocart addtocart-button prod-list-addtocart-button add button-green','title'=>'Добавить этот товар в корзину'));
			?>
				<p class="to-cart-process pt-5 hidden">
					<span class="ajax-loading font-10"><img class="v-middle" src="/img/loading.gif" alt="Обработка" /> Обработка...</span>
				</p>
				<p class="cart-msg hidden font-10"></p>

				<a href="<?=$data->product_url?>" class="button-red product-detail">Подробнее</a>
			<?php echo CHtml::endForm(); ?>


		</div>
	</div>

	<?php if(isset($deliveries_list[$data->product_id]))	{	?>
		<div id="delivery-<?= $data->product_id ?>" class="delivery-popup hidden" >
			<?php $this->renderPartial('../shopproducts/delivery', array(
				'app'=>$app,
				'product_images_liveUrl'=>'',
				'model'=>$data,
				'delivery_list'=>$deliveries_list[$data->product_id],
				'modelinfoTxt' => $modelinfoTxt,
				'currency_info' => $currency_info,
			));?>
		</div>
	<?php	}	?>
</div>

<?php $this->renderPartial('../shopproducts/_questions-cnt', array(
	'app'=>$app,
	'model'=>$data,
    'arQuestionsCount'=>$arQuestionsCount,
	'formTitle'=>'Задать вопрос',
));?>
