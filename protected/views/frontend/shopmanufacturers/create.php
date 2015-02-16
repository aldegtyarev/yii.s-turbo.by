<?php
/* @var $this ShopManufacturersController */
/* @var $model ShopManufacturers */

$this->breadcrumbs=array(
	'Shop Manufacturers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShopManufacturers', 'url'=>array('index')),
	array('label'=>'Manage ShopManufacturers', 'url'=>array('admin')),
);
?>

<h1>Create ShopManufacturers</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>