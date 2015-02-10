<?php
/* @var $this ShopModelsAutoController */
/* @var $model ShopModelsAuto */

$this->breadcrumbs=array(
	'Модельный ряд'=>array('admin'),
	'Новый',
);

$this->menu=array(
	array('label'=>'Модельный ряд', 'url'=>array('admin')),
);
?>

<h1>Новый</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>