<?php
/* @var $this PagesController */
/* @var $data Pages */

$url = $this->createUrl('pages/'.$url_path, array('alias'=>$data->alias));
?>

<div class="product-item product-list-item product-list-item-row">
		<div class="product-item-wr clearfix">
			<div class="product-list-item-row-image-block fLeft">
			
				<div class="product-image page-image" style="background-image: url(<?=$data->foto ?>)"></div>
				
				
			</div>
			<div class="product-list-item-row-info-block fLeft">
				<p class="page-item-created"><?= Yii::app()->dateFormatter->format("dd MMMM yyyy", $data->created) ?></p>
				<a href="<?= $url ?>" class="product-title db bold text_c font-14"><?=$data->name?></a>
				<div class="page-intro"><?= $data->intro ?></div>
				
			</div>
			<div class="product-list-item-row-price-block fLeft pl-20 text_c">
				<a href="<?= $url ?>" class="button-red product-detail">Подробнее</a>
			</div>
			

		</div>
</div>