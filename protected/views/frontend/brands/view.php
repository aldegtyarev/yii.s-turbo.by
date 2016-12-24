<?php
/* @var $this ShopFirmsController */
/* @var $model ShopFirms */
/* @var $params array */

$this->breadcrumbs=array(
	'Бренды'=>array('index'),
	$model->firm_name,
);

?>

<div class="page-cnt page-body page-body--brand">
	<?
    if($model->firm_logo != '') {
        echo CHtml::image($params->brands_images_liveUrl . 'thumb_' . $model->firm_logo, $model->firm_name, array('class' => 'brand-page__img'));
    }
    ?>

    <div class="brand-page__head">
        <h1><?php echo $model->firm_name; ?></h1>
        <?
        if($model->url != '') {
            echo CHtml::link('Ссылка на сайт', $model->url, array ('target'=>'_blank', 'rel'=>'nofollow'));
        }
        ?>
    </div>

    <div class="brand-page__descr"><?= $model->firm_description ?></div>
</div>

