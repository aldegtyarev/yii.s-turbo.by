<?php
/* @var $this ShopProductsController */
/* @var $model ShopProducts */

$this->breadcrumbs = $breadcrumbs;

$app = Yii::app();
$baseUrl = $app->getBaseUrl(true).'/';

$clientScript = $app->clientScript;

$clientScript->registerCoreScript('phone-input');
$clientScript->registerCoreScript('fancybox');

//$product_name = $model->product_name;

//$model->product_name .= $modelinfoTxt;

MetaHelper::setMeta($this, $model, 'product_name');
/*

if ($model->metatitle) $this->pageTitle = $model->metatitle;
	else	$this->pageTitle = $model->product_name;

//$this->pageTitle .= ' | '.$app->name;

if ($model->metakey)	
	$clientScript->registerMetaTag($model->metakey, 'keywords');

if ($model->metadesc)		
	$clientScript->registerMetaTag($model->metadesc, 'description');
*/

$params = $app->params;

$image_url = $app->getBaseUrl(true) . $params->product_images_liveUrl . 'full_'.$model->product_image;
$current_url = $app->getBaseUrl(true).$app->getRequest()->getUrl();

$product_desc = $model->metadesc;
/*
$product_desc = '';
if(!empty($model->side)) $product_desc .= $model->getAttributeLabel('side') . ': '.$model->ProductSideArray[$model->side]['name'].' ';
if(!empty($model->lamps)) $product_desc .= $model->getAttributeLabel('lamps') . ': '.nl2br($model->lamps).' ';
if(!empty($model->adjustment)) $product_desc .= $model->getAttributeLabel('adjustment') . ': '.$model->adjustment.' ';
if(!empty($model->material)) $product_desc .= $model->getAttributeLabel('material') . ': '.$model->material.' ';
if(!empty($model->product_s_desc)) $product_desc .= $model->getAttributeLabel('product_s_desc') . ': '.$model->product_s_desc.' ';
$product_desc .= strip_tags($model->product_desc);
*/

if($product_desc != '') {
	mb_internal_encoding('UTF-8');
	$product_desc = mb_substr($product_desc, 0, 297).'...';
}	else	{
	$product_desc = 'Описание товара';
}

if (!$app->request->isAjaxRequest) {
	$clientScript->registerMetaTag($image_url, 'og:image');
	$clientScript->registerMetaTag('article', 'og:type');
	$clientScript->registerMetaTag($current_url, 'og:url');
	$clientScript->registerMetaTag($model->metatitle, 'og:title');
	$clientScript->registerMetaTag($product_desc, 'og:description');
}

$product_classes = '';

$model_images = $model->Images;


if($model->product_override_price == 0) {
	$prod_price = $model->product_price;
}	else	{
	$prod_price = $model->product_override_price;
}
$product_price = PriceHelper::formatPrice($prod_price, $model->currency_id, 3, $currency_info, true, true);
if($product_price >= $free_delivery_limit) $model->free_delivery = 1;

?>

<div class="productdetails-view">
	<?php 
		if ($app->request->isAjaxRequest) {
			$tag = 'og_image';
			echo CHtml::hiddenField($tag, $image_url, array ('id'=>$tag));
			
			$tag = 'og_type';
			echo CHtml::hiddenField($tag, 'article', array ('id'=>$tag));
			
			$tag = 'og_url';
			echo CHtml::hiddenField($tag, $current_url, array ('id'=>$tag));
			
			$tag = 'og_title';
			echo CHtml::hiddenField($tag, $model->metatitle, array ('id'=>$tag));
			
			$tag = 'og_description';
			echo CHtml::hiddenField($tag, $product_desc, array ('id'=>$tag));
		}
	?>
	
	<h1><?php echo $model->product_name; ?>
		<?php if($modelinfoTxt != '')	{	?>
			<span class="productdetails-modelinfo"><?= $modelinfoTxt ?></span>
		<?php	}	?>
	</h1>
	<div class="head clearfix">
		<div class="productdetails-view-image-part">
			<div id="product-image-cnt-<?= $model->product_id ?>" class="productdetails-main-image">
				<? if ($model->product_image) {?>
					<?	echo CHtml::link(CHtml::image($params->product_images_liveUrl . 'full_'.$model->product_image, "", array('class' => "medium-image", 'id'=>'product-image-'.$model->product_id)), $params->product_images_liveUrl . 'full_'.$model->product_image, array('class' => "fancybox", "data-fancybox-group" => "gallery"));	?>
				<?	}	else	{	?>
				<?	echo CHtml::image($params->product_images_liveUrl . 'noimage.jpg', "", array('class' => "medium-image"));	?>
				<?	}	?>
			</div>
			
			<? if(count($model_images))	{	?>
			
			<div class="productdetails-wrapper-slider">		
				<div class="productdetails-slider-images">
					<ul class="clearfix">
						<? 
							foreach($model_images as $media_item)	{
								if($media_item->image_file != $model->product_image)	{
									echo CHtml::openTag('li');
									$thumb_image_url = $params->product_images_liveUrl . 'thumb_'.$media_item->image_file;
									$image_url = $params->product_images_liveUrl . 'full_'.$media_item->image_file;
									//echo CHtml::link(CHtml::image($thumb_image_url), $image_url, array('class' => "fancybox", "data-fancybox-group" => "gallery"));
									echo CHtml::link('', $image_url, array('class' => "fancybox productdetails-slider-images-tmb", "data-fancybox-group" => "gallery", 'style'=>'background-image:url("'.$thumb_image_url.'")'));
									echo CHtml::closeTag('li');
								}
							}	
						?>
					</ul>
				</div>
			</div>
			<?	}	?>
		</div>
		
		<div class="productdetails-view-main-info-part-wr">
			<div class="productdetails-view-main-info-part">
					<div class="fields">
						<div class="productdetails-price-row clearfix">
							<span class="label"><? echo $model->getAttributeLabel('product_price');?>:</span>
							<div class="value" id="productPrice<?=$model->product_id?>">
								<? if($model->percent_discount < 0)	{	?>


									<p><span class="price-override"><?= PriceHelper::formatPrice($model->product_price, $data->currency_id, 3, $currency_info, true)?></span><span class="percent_discount"><?= $model->percent_discount ?>%</span></p>

									<p class="price-byr"><?=PriceHelper::formatPrice($model->product_override_price, $model->currency_id, 3, $currency_info, true)?></p>
									<p class="price"><?=PriceHelper::formatPrice($model->product_override_price, $model->currency_id, 0, $currency_info)?></p>
								<?	}	else	{	?>
									<p class="price-byr"><?=PriceHelper::formatPrice($model->product_price, $model->currency_id, 3, $currency_info, true)?></p>
									<p class="price"><?=PriceHelper::formatPrice($model->product_price, $model->currency_id, 0, $currency_info)?></p>
								<?	}	?>
							</div>
						</div>
						
						<p class="row clearfix">
							<span class="label"><? echo $model->getAttributeLabel('manuf');?>:</span>
							<span class="value"><?=$model->firm->firm_name?></span>
						</p>
						
						<p class="row clearfix">
							<span class="label"><? echo $model->getAttributeLabel('product_sku');?>:</span>
							<span class="value"><?=$model->product_sku?></span>
						</p>
						
						<?php if($model->manufacturer_sku)	{	?>
							<p class="row clearfix">
								<span class="label"><? echo $model->getAttributeLabel('manufacturer_sku');?>:</span>
								<span class="value"><?=$model->manufacturer_sku?></span>
							</p>
						<?php	}	?>
						
						<? if($model->product_availability != 0)	{	?>
							<? 
								if($model->product_availability == 2) {
									$status_class = 'status-available';
								}	else	{
									$status_class = 'status-on-request';
								}
							?>

							<p class="row clearfix">
								<span class="label"><? echo $model->getAttributeLabel('product_availability');?>:</span>
								<span class="value <?=$status_class?>"><?=$model->ProductAvailabilityArray[$model->product_availability]['name'] ?></span>
							</p>

							<? if(!empty($model->delivery))	{	?>
							<p class="row clearfix">
								<span class="label"><? echo $model->getAttributeLabel('delivery');?>:</span>
								<span class="value"><?=$model->delivery?></span>
							</p>
							<?	}	?>

							<? if(!empty($model->prepayment))	{	?>
							<p class="row clearfix">
								<span class="label"><? echo $model->getAttributeLabel('prepayment');?>:</span>
								<span class="value">
									
									<?= $model->prepayment ?>
									<?php if($model->prepayment != 'без предоплаты')	{	?>
										<a href="#prepayment" class="fancybox1" rel="nofollow"><img src="/img/question_ico.gif" alt="предоплата" class="productdetails-prepayment-ico"></a>
									<?php	}	?>
								</span>
								
							</p>
							<?	}	?>
						
						<?	}	?>						
					</div>
					<?php echo CHtml::beginForm($this->createUrl('/cart/addtocart')); ?>
						<?php echo Chtml::hiddenField('quantity', '1', array('class'=>'quantity', 'id'=>false)); ?>
						<?php echo Chtml::hiddenField('product_id', $model->product_id, array('class'=>'product_id', 'id'=>false)); ?>
						<?php if($model->free_delivery != 0)	{	?>
							<p class="productdetails-free-delivery">+ бесплатная доставка</p>
						<?	}	else	{	?>
							<p class="productdetails-delivery-cost">
								<a class="fancybox-delivery" href="#delivery-<?= $model->product_id ?>" rel="nofollow">стоимость доставки</a>
								<img src="/img/question_ico.gif" alt="стоимость доставки">
							</p>
						<?	}	?>

						<?php  ?>
						<p class="to-cart-process pt-5 hidden">
							<span class="ajax-loading font-10"><img class="v-middle" src="/img/loading.gif" /> Обработка...</span>
						</p>
						
						<p class="cart-msg hidden pb-5 font-10"></p>
					
						<?php echo CHtml::submitButton('В корзину', array('name'=>'addtocart', 'class'=>'addtocart addtocart-button add button-green','title'=>'Добавить этот товар в корзину'));?>
					<?php echo CHtml::endForm(); ?>
										
					<?/*<div class="productview-ask-question"><a href="#">Задать вопрос</a></div>*/?>

					<div class="cart-popup-wr hidden">
						<div id="cart-popup" class="cart-popup" >
							<div id="cart-popup-info" class="cart-popup-info">Количество товара было обновлено.</div>
							<a class="continue close" href="javascript:void(0)" onclick="ClosePopUp();">Продолжить покупки</a>
							<?php echo CHtml::link('Оформить заказ', $this->createUrl('/cart/showcart', array()), array('class'=>'showcart floatright')); ?>

						</div>
					</div>
					<? echo CHtml::link('Сообщение корзины', '#cart-popup', array('id'=>'cart-message', 'class'=>'fancybox cart-message hidden')); ?>
					<?/*
					<div class="buy-in-one-click">
						<a href="#" id="buy-in-one-click-btn" class="buy-in-one-click-btn">Купить в 1 клик</a>
						<input type="text" id="buy-in-one-click-input" class="inputbox phone-input" placeholder="+375 (XX) XXX-XX-XX"/>
						<img id="buy-in-one-click-sending" class="v-middle" src="/img/loading.gif" />
						<p id="buy-in-one-click-err" class="buy-in-one-click-err">Укажите номер своего телефона</p>
						<p id="buy-in-one-click-ok" class="buy-in-one-click-ok">Ваша заявка отправлена.</p>
					</div>
					*/?>

			</div>
			<div class="productdetails-client-info">
				<p class="title">Информация для клиента</p>
				<div class="productdetails-client-info-wr clearfix">
					<p class="delivery"><a href="<?= $this->createUrl('pages/dostavka')?>" class="modal-url fancybox1 fancybox.ajax" title="Доставка по всей Беларуси"><img src="/img/advantages-2.png" alt="Доставка"><br>Доставка</a></p>
					<p class="payment"><a href="<?= $this->createUrl('pages/oplata')?>" class="advantages-item-detail modal-url fancybox1 fancybox.ajax" title="Удобная оплата"><img src="/img/advantages-3.png" alt="Оплата"><br>Оплата</a></p>
					<p class="guarantie"><a href="<?= $this->createUrl('pages/garantiya')?>" class="advantages-item-detail modal-url fancybox1 fancybox.ajax" title="Гарантия и возврат"><img src="/img/advantages-4.png" alt="Гарантия"><br>Гарантия / возврат</a></p>
				</div>
			</div>
		</div>		
	</div>
	
<?  $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Описание товара")); ?> 
    <? if($model->hide_s_desc == 0)	{	?>
    	<p class="product-ttl-descr"><?php echo $model->product_name; ?><br></p>
		<ul class="product_short_description small dt">
			<? if(!empty($model->side))	{	?>
				<li class="dtr"><span class="dtc pr-5 pb-5"><? echo $model->getAttributeLabel('side');?>: </span><span class="dtc pb-5 bold"><?=$model->ProductSideArray[$model->side]['name']?></span></li>
			<?	}	?>

			<? if(!empty($model->lamps))	{	?>
				<li class="dtr mb-5"><span class="dtc pr-5 pb-5"><? echo $model->getAttributeLabel('lamps');?>: </span><span class="dtc pb-5 bold"><?=nl2br($model->lamps)?></span></li>
			<?	}	?>

			<? if(!empty($model->adjustment))	{	?>
				<li class="dtr"><span class="dtc pr-5 pb-5"><? echo $model->getAttributeLabel('adjustment');?>: </span><span class="dtc pb-5 bold"><?=$model->adjustment?></span></li>
			<?	}	?>

			<? if(!empty($model->material))	{	?>
				<li class="dtr"><span class="dtc pr-5 pb-5"><? echo $model->getAttributeLabel('material');?>: </span><span class="dtc pb-5 bold"><?=$model->material?></span></li>
			<?	}	?>

			<? if(!empty($model->product_s_desc))	{	?>
				<li class="dtr"><span class="dtc pr-5 pb-5"><? echo $model->getAttributeLabel('product_s_desc');?>: </span><span class="dtc pb-5 bold"><?=nl2br($model->product_s_desc)?></span></li>
			<?	}	?>
		</ul>
	<?	}	?>    
    <? if($model->product_desc) { ?>
        <div class="product_description"><? echo $model->product_desc; ?></div>
    <? } ?>
    
	<div id="likes-block" class="likes-block">
		<div id="my-share" class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,lj"></div>
	</div>
    
    <?php $this->endWidget(); ?>

	<?php if($model->free_delivery == 0)	{	?>
		<div id="delivery-<?= $model->product_id ?>" class="delivery-popup hidden" >
			<?php $this->renderPartial('delivery', array(
				'app'=>$app,
				'product_images_liveUrl'=>$app->params->product_images_liveUrl,
				'model'=>$model,
				'delivery_list'=>$delivery_list,
				'modelinfoTxt' => $modelinfoTxt,
				'currency_info' => $currency_info,
			));?>
		</div>
	<? } ?>

	<?php

	//if($model->installation != '') {
		$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Установка"));
		echo $model->installation;
		?>
		<div class="page-cnt">
		<?php
		echo $installation_page;
		?>
		</div>
		<?php
		
		$this->renderPartial('_our-work', array(
			'app'=>$app,
			'dataProvider' => $ourWorkDataProvider,
			'url_path' => $url_path,
		));						 
		

		$this->endWidget();
	//}

	$tabParameters = array();

	$i = 0;
	foreach($this->clips as $key=>$clip)	{
		$tabParameters['tab_'.$i] = array('title'=>$key, 'content'=>$clip);
		$i++;
	}

	$this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters, 'htmlOptions'=>array('class'=>'productdetails-view-tab clearfix', 'id'=>'productdetails-view-tab'), 'activeTab'=>"0"));
	?>

	<?php if(count($RelatedDataProvider->data))	{	?>
		<div class="related-products new-positions clearfix">
			<h3>Сопутствущие товары</h3>
			<div class="jcarousel-wrapper">
				<?php //тут карусель не нужна. просто классы используем от нее ?>
				<div class="jcarousel jcarousel-new-positions">
					<?php $this->widget('zii.widgets.CListView', array(
						'dataProvider'=>$RelatedDataProvider,
						'itemView'=>'_view-related',
						'ajaxUpdate'=>false,
						'template'=>"{items}",
						'itemsCssClass' => 'jcarousel products-list',
					)); ?>
				</div>
			</div>
		</div>
	<?	}	?>

	<?php	if($prepayment_text != '')	{	?>
		<div id="prepayment" class="page-cnt" style="width:600px;display:none;">
			<?= $prepayment_text ?>
		</div>
	<?php	}	?>
	
</div>

<?php $this->widget('application.components.HowItWorkWidget'); ?>
