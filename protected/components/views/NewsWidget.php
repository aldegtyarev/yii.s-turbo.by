<?
	//$params = Yii::app()->params;
	//$images_live_url = ->images_live_url;
	//$webroot = Yii::getPathOfAlias('webroot');
	//$product_classes = "";
	//$isWidget = true;
	$app = Yii::app();
	$cs = $app->getClientScript();

	$cs->registerCoreScript('jcarousel-products-on-auto');
?>


<?/*
<div class="new-positions news-block">
	<div class="header-wr">
		<h3>Новости магазина</h3>
		<a href="#" class="all-items">Все новости магазина</a>
	</div>
	<div class="jcarousel-wrapper">
		<div class="jcarousel jcarousel-new-positions">
			<?php $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'_view-news-page',
				'ajaxUpdate'=>false,
				'template'=>"{items}",
				'itemsCssClass' => 'jcarousel products-list',
			)); ?>
		</div>
		<a href="#" class="jcarousel-control-prev jcarousel-new-positions-control-prev">‹</a> <a href="#" class="jcarousel-control-next jcarousel-new-positions-control-next">›</a>
	</div>
	
</div>
*/?>

<div class="products-on-auto news-block <?= $url_path . '-list'?>">
	<div class="header-wr">
		<h3><?= $block_title ?></h3>
		<a href="<?= $this->controller->createUrl('pages/'.$url_path); ?>" class="all-items"><?= $url_title ?></a>
	</div>
	
	<div class="jcarousel-wrapper">
		<div class="jcarousel jcarousel-products-on-auto">
			<ul class="jcarousel products-on-auto-list">
				<?php foreach($dataProvider->data as $data) $this->render('_view-news-page', array('data' => $data, 'url_path'=>$url_path)) ?>
			</ul>
		</div>
		<a href="#" class="jcarousel-control-prev jcarousel-products-on-auto-control-prev sprite">‹</a> <a href="#" class="jcarousel-control-next jcarousel-products-on-auto-control-next sprite">›</a>
	</div>
</div>
