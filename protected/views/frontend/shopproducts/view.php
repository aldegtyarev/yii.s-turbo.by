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
					<?	echo CHtml::link(CHtml::image($params->product_images_liveUrl . 'full_'.$model->product_image, "", array('class' => "medium-image")), $params->product_images_liveUrl . 'full_'.$model->product_image, array('class' => "fancybox", "rel" => "group"));	?>
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
								echo CHtml::openTag('li');
								$thumb_image_url = $params->product_images_liveUrl . 'thumb_'.$media_item->image_file;
								$image_url = $params->product_images_liveUrl . 'full_'.$media_item->image_file;
								echo CHtml::link(CHtml::image($thumb_image_url), $image_url, array('class' => "fancybox", "rel" => "group"));
								echo CHtml::closeTag('li');
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
							<span class="label">Цена:</span>
							<div class="value" id="productPrice<?=$model->product_id?>">
								<p class="price"><?=number_format($model->product_price, 0, '.', ' ')?> у.е.</p>
								<p class="price-byr"><?=number_format(($model->product_price * 16300), 0, '.', ' ')?> бел.руб</p>
							</div>
						</div>

						<?if(!empty($model->manuf))	{	?>
						<p class="row clearfix">
							<span class="label">Производитель:</span>
							<span class="value"><?=$model->manuf?></span>
						</p>
						<?	}	?>

						<?if(!empty($model->material))	{	?>
						<p class="row clearfix">
							<span class="label">Материал:</span>
							<span class="value"><?=$model->material?></span>
						</p>
						<?	}	?>

						<?if(!empty($model->code))	{	?>
						<p class="row clearfix">
							<span class="label">Код товара:</span>
							<span class="value"><?=$model->product_sku?></span>
						</p>
						<?	}	?>

						<? if(!empty($model->product_availability))	{	?>
							<? 
								if($model->product_availability == 2) {
									$status_class = 'status-available';
								}	else	{
									$status_class = 'status-on-request';
								}
							?>

						<p class="row clearfix">
							<span class="label">Наличие:</span>
							<span class="value <?=$status_class?>"><?=$model->ProductAvailabilityArray[$model->product_availability]['name'] ?></span>
						</p>
						<?	}	?>

						<?if(!empty($model->delivery))	{	?>
						<p class="row clearfix">
							<span class="label">Доставка:</span>
							<span class="value"><?=$model->delivery?></span>
						</p>
						<?	}	?>

						<?if(!empty($model->prepayment))	{	?>
						<p class="row clearfix">
							<span class="label">Предоплата:</span>
							<span class="value"><?=$model->prepayment?></span>
						</p>
						<?	}	?>
					</div>


					<form method="post" class="productview-tocart js-recalculate" action="index.php">
						<input type="hidden" name="quantity" id="quantity" value="1">
						<input type="submit" name="addtocart" id="addtocart" class="addtocart-button add button" title="Добавить этот товар в корзину" value="Купить">
						<input type="hidden" name="product_id" id="product_id" value="<?=$model->product_id?>">
					</form>
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
	
<?
	$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Описание товара"));
	echo $model->product_desc;
	$this->endWidget();				

	$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Отзывы покупателей<sup>5</sup>"));
	echo "Отзывы покупателей";
	$this->endWidget();

	$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Установка"));
	echo "Установка";
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
				<ul class="jcarousel products-list">
					<? include(Yii::getPathOfAlias('webroot')."/protected/views/frontend/common/product-list.php");	?>
				</ul>
			</div>
			<a href="#" class="jcarousel-control-prev jcarousel-new-positions-control-prev">‹</a> <a href="#" class="jcarousel-control-next jcarousel-new-positions-control-next">›</a>
		</div>
	</div>
<?	}	?>






	
</div>
