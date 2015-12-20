<?php
/* @var $this DeliveryController */
/* @var $model Delivery */

$this->breadcrumbs=array(
	'Виды доставки'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Виды доставки', 'url'=>array('admin')),
	array('label'=>'Добавить', 'url'=>array('create')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>