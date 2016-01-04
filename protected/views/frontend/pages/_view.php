<?php
/* @var $this PagesController */
/* @var $data Pages */

$url = $this->createUrl('pages/'.$url_path, array('alias'=>$data->alias));
?>

<div class="product-item product-list-item product-list-item-row">
	<div class="product-item-wr clearfix">

		<div class="product-list-item-row-image-block fLeft">
			<a href="<?= $url ?>" class="db product-image page-image" style="background-image: url(<?=$data->foto ?>)"></a>
		</div>

		<div class="page-row-info">
			<p class="page-item-created"><?= Yii::app()->dateFormatter->format("dd MMMM yyyy", $data->created) ?></p>
			<a href="<?= $url ?>" class="page-title"><?=$data->name?></a>
			<div class="page-intro"><?= $data->intro ?></div>				
			<a href="<?= $url ?>" class="page-readmode">Подробнее</a>
		</div>
	</div>
</div>