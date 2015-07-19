<?php
/* @var $this ShopProductsController */
/* @var $model ShopProducts */

$this->breadcrumbs = $breadcrumbs;
/*
$this->breadcrumbs=array(
	'Shop Products'=>array('index'),
	$model->product_id,
);
*/

$app = Yii::app();
$baseUrl = $app->getBaseUrl(true).'/';

$cs = $app->clientScript;
$cs->registerCoreScript('fancybox');

$clientScript = $app->clientScript;


if ($model->metatitle)	{
  $this->pageTitle = $model->metatitle;
}	else	{
	$this->pageTitle = $model->product_name;
}

$this->pageTitle .= ' | '.$app->name;

if ($model->metakey)	
	$clientScript->registerMetaTag($model->metakey, 'keywords');

if ($model->metadesc)		
	$clientScript->registerMetaTag($model->metadesc, 'description');



//echo'<pre>';print_r($baseUrl);echo'</pre>';
//echo'<pre>';print_r($model->shopProductsMediases);echo'</pre>';
//echo'<pre>';print_r($model->shopProductPrices);echo'</pre>';
$params = $app->params;

$product_classes = '';

//$model_images = $model->shopProductsMediases;
$model_images = $model->Images;
?>


<div class="productdetails-view">
	<h1><?php echo $model->product_name; ?></h1>
	<div class="head clearfix">
		<div class="productdetails-view-image-part">
			<div class="productdetails-main-image">
				<? if ($model->product_image) {?>
					<?	echo CHtml::link(CHtml::image($params->product_images_liveUrl . 'full_'.$model->product_image, "", array('class' => "medium-image")), $params->product_images_liveUrl . 'full_'.$model->product_image, array('class' => "fancybox", "data-fancybox-group" => "gallery"));	?>
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
									echo CHtml::link(CHtml::image($thumb_image_url), $image_url, array('class' => "fancybox", "data-fancybox-group" => "gallery"));
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
						<div class="row productdetails-price-row clearfix">
							<span class="label"><? echo $model->getAttributeLabel('product_price');?>:</span>
							<div class="value" id="productPrice<?=$model->product_id?>">
								<p class="price"><?=number_format(($model->product_price * Yii::app()->params->usd_rate), 0, '.', ' ')?> руб.</p>
								<p class="price-byr"><?=number_format($model->product_price, 1, '.', ' ')?> у.е.</p>
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
								<span class="value"><?=$model->prepayment?></span>
							</p>
							<?	}	?>
						
						<?	}	?>						
					</div>
					<?php echo CHtml::beginForm($this->createUrl('/cart/addtocart')); ?>
						<p class="to-cart-process pt-5 hidden">
							<span class="ajax-loading font-10"><img class="v-middle" src="/img/loading.gif" /> Обработка...</span>
						</p>
						<p class="cart-msg hidden pb-5 font-10"></p>
					
					<?php 
						echo Chtml::hiddenField('quantity', '1', array('class'=>'quantity', 'id'=>false));
						echo Chtml::hiddenField('product_id', $model->product_id, array('class'=>'product_id', 'id'=>false));
						echo CHtml::submitButton('Купить', array('name'=>'addtocart','id'=>false,'class'=>'addtocart addtocart-button add button','title'=>'Добавить этот товар в корзину'));
						echo CHtml::endForm(); 
					?>
										
					<div class="productview-ask-question"><a href="#">Задать вопрос</a></div>



					<div class="cart-popup-wr hidden">
						<div id="cart-popup" class="cart-popup" >
							<div id="cart-popup-info" class="cart-popup-info">Количество товара было обновлено.</div>
							<a class="continue close" href="javascript:void(0)" onclick="ClosePopUp();">Продолжить покупки</a>
							<? /*<a class="showcart floatright" href="/magazin-tyuninga/cart.html">Оформить заказ</a> */ ?>
							<?echo CHtml::link('Оформить заказ', $this->createUrl('/cart/showcart', array()), array('class'=>'showcart floatright')); ?>

						</div>
					</div>
					<? echo CHtml::link('Сообщение корзины', '#cart-popup', array('id'=>'cart-message', 'class'=>'fancybox cart-message hidden')); ?>

			</div>
			<div class="productdetails-view-main-info-part productdetails-client-info">
				<p class="title">Информация для клиента</p>
				<div class="clearfix">
					<p class="payment"><a href="#">Вопросы оплаты</a></p>
					<p class="delivery"><a href="#">Информация по доствке</a></p>
				</div>
			</div>
		</div>		
	</div>
	
<?  $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Описание товара")); ?> 
    <? if($model->hide_s_desc == 0)	{	?>
		<ul class="product_short_description small dt">
			<? if(!empty($model->side))	{	?>
				<li class="dtr"><span class="dtc pr-5 pb-5"><? echo $model->getAttributeLabel('side');?>: </span><span class="dtc pb-5"><?=$model->ProductSideArray[$model->side]['name']?></span></li>
			<?	}	?>

			<? if(!empty($model->lamps))	{	?>
				<li class="dtr mb-5"><span class="dtc pr-5 pb-5"><? echo $model->getAttributeLabel('lamps');?>: </span><span class="dtc pb-5"><?=nl2br($model->lamps)?></span></li>
			<?	}	?>

			<? if(!empty($model->adjustment))	{	?>
				<li class="dtr"><span class="dtc pr-5 pb-5"><? echo $model->getAttributeLabel('adjustment');?>: </span><span class="dtc pb-5"><?=$model->adjustment?></span></li>
			<?	}	?>

			<? if(!empty($model->material))	{	?>
				<li class="dtr"><span class="dtc pr-5 pb-5"><? echo $model->getAttributeLabel('material');?>: </span><span class="dtc pb-5"><?=$model->material?></span></li>
			<?	}	?>

			<? if(!empty($model->product_s_desc))	{	?>
				<li class="dtr"><span class="dtc pr-5 pb-5"><? echo $model->getAttributeLabel('product_s_desc');?>: </span><span class="dtc pb-5"><?=nl2br($model->product_s_desc)?></span></li>
			<?	}	?>
		</ul>
	<?	}	?>    
    <? if($model->product_desc) { ?>
        <div class="product_description"><? echo $model->product_desc; ?></div>
    <? } ?>
    <?

	
	$this->endWidget();				

	$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Отзывы покупателей<sup>5</sup>"));
	echo "Отзывы покупателей";
	$this->endWidget();

	$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Установка"));
	echo $model->installation;
	$this->endWidget();

	$tabParameters = array();

	$i = 0;
	foreach($this->clips as $key=>$clip)	{
		$tabParameters['tab_'.$i] = array('title'=>$key, 'content'=>$clip);
		$i++;
	}

	$this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters, /*'cssFile'=>"/css/gorizontal_tab.css",*/ 'htmlOptions'=>array('class'=>'productdetails-view-tab clearfix', 'id'=>'productdetails-view-tab'), 'activeTab'=>"0"));				

?>


<? if(count($rows))	{	?>
	<div class="related-products new-positions">
		<h3>Сопутствущие товары</h3>
		<div class="jcarousel-wrapper">
			<div class="jcarousel jcarousel-new-positions">
				<?php $this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$RelatedDataProvider,
					'itemView'=>'_view-related',
					'ajaxUpdate'=>false,
					'template'=>"{items}",
					'itemsCssClass' => 'jcarousel products-list',
				)); ?>
				<?/*
				<ul class="jcarousel products-list">
					<? include(Yii::getPathOfAlias('webroot')."/protected/views/frontend/common/product-list.php");	?>
				</ul>
				*/?>
			</div>
			<a href="#" class="jcarousel-control-prev jcarousel-new-positions-control-prev">‹</a> <a href="#" class="jcarousel-control-next jcarousel-new-positions-control-next">›</a>
		</div>
	</div>
<?	}	?>






	
</div>
