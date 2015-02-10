<?php
/* @var $this ShopManufacturersController */
/* @var $model ShopManufacturers */

$this->breadcrumbs=array(
	'Производители'=>array('admin'),
	$model->manufacturer_name,
);

$this->menu=array(
	array('label'=>'Производители', 'url'=>array('admin')),
	array('label'=>'Новый', 'url'=>array('create')),
);
?>

<h1><?php echo $model->manufacturer_name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>