<?php
/* @var $this ShopManufacturersController */
/* @var $model ShopManufacturers */

$this->breadcrumbs=array(
	'Производители'=>array('admin'),
	'Новый',
);

$this->menu=array(
	//array('label'=>'List ShopManufacturers', 'url'=>array('index')),
	array('label'=>'Производители', 'url'=>array('admin')),
);
?>

<h1>Новый</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>