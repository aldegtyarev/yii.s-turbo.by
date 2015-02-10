<?
	$params = Yii::app()->params;
	//$images_live_url = ->images_live_url;
	$webroot = Yii::getPathOfAlias('webroot');
	$product_classes = "";
	$isWidget = true;
?>



<div class="new-positions news-block">
	<div class="header-wr">
		<h3>Новые поступления</h3>
		<a href="#" class="all-items">Все новые товары</a>
	</div>
	<div class="jcarousel-wrapper">
		<div class="jcarousel jcarousel-new-positions">
			<ul class="jcarousel products-list">
				<? include("$webroot/protected/views/frontend/common/product-list.php");	?>
			</ul>
		</div>
		<a href="#" class="jcarousel-control-prev jcarousel-new-positions-control-prev">‹</a> <a href="#" class="jcarousel-control-next jcarousel-new-positions-control-next">›</a>
	</div>
	
</div>