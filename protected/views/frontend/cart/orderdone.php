<?
$this->breadcrumbs = array(
	'Заказ завершен'
);

$clientScript = $app->clientScript;


$this->pageTitle = "Заказ завершен | ".$app->name;
$clientScript->registerMetaTag("Заказ завершен,".$app->name, 'keywords');
$clientScript->registerMetaTag("Заказ завершен на ".$app->name, 'description');

$js = "$('#orderdone-popup').click();";
$js1 = '$(".fb-orderdone").fancybox({modal : true,padding : 0,helpers: {overlay: {locked: false}}});';
$css = ".fancybox-skin .fancybox-close {display:none !important;}";

$app->clientScript->registerScript('order-done', $js, CClientScript::POS_LOAD);
$app->clientScript->registerScript('fb-order-done', $js1, CClientScript::POS_READY);
$app->clientScript->registerCss('order-done', $css);

?>
<div class="cart-view item-page">
	<?php if($model === null ) 	{	?>
		<h1>Неизвестный заказ</h1>
	<?php }	else	{	?>
	
		<h1>Заказ завершен</h1>

		<div class="cart-list bg-fff p-30" style="visibility:hidden;">
			<div class="cart-empty">Ваш заказ <span>№<?= $model->id ?></span> от <?= Yii::app()->dateFormatter->format('d MMMM yyyy', $model->created);?> на сумму <span><?=PriceHelper::formatPrice($model->summ_byr, 3, 3, null, true)?></span> принят в обработку</div>

			<a href="#order-done-popup" id="orderdone-popup" class="fb-orderdone" style="color:#fff;font-size:2px;"><span>Подробнее</span></a>
		</div>

		<div id="order-done-popup" class="order-done-popup" style="width: 550px; display: none;">
			<div class="order-done-hdr">
				<img src="/img/logo-top.png" alt="магазин автомобильных запчастей">
				<a href="/">Закрыть</a>
			</div>
			<div class="order-done-info">
				<p class="r1">Ваш заказ <span>№<?= $model->id ?></span> от <?= Yii::app()->dateFormatter->format('d MMMM yyyy', $model->created);?> на сумму <span><?=PriceHelper::formatPrice(($model->summ_byr + $delivery_cost), 3, 3, null, true)?></span></p>
				<p class="r2">Принят в обработку!</p>
				<p class="r3">В ближайшее время с Вами свяжется наш менеджер</p>
				<p class="r4">Спасибо!</p>
			</div>

		</div>

	<?php }	?>
</div>