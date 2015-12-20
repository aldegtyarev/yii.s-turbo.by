<?php
/* @var $this DeliveryController */
/* @var $model Delivery */

$this->breadcrumbs=array(
	'Виды доставки'=>array('admin'),
	'Добавить',
);

$this->menu=array(
	array('label'=>'Виды доставки', 'url'=>array('admin')),
);
?>

<h1>Добавить</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>