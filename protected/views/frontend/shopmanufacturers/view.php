<?php
/* @var $this ShopManufacturersController */
/* @var $model ShopManufacturers */

$this->breadcrumbs=array(
	'Shop Manufacturers'=>array('index'),
	$model->manufacturer_id,
);

$this->menu=array(
	array('label'=>'List ShopManufacturers', 'url'=>array('index')),
	array('label'=>'Create ShopManufacturers', 'url'=>array('create')),
	array('label'=>'Update ShopManufacturers', 'url'=>array('update', 'id'=>$model->manufacturer_id)),
	array('label'=>'Delete ShopManufacturers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->manufacturer_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopManufacturers', 'url'=>array('admin')),
);
?>

<h1>View ShopManufacturers #<?php echo $model->manufacturer_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'manufacturer_id',
		'manufacturer_name',
		'manufacturer_description',
		'manufacturer_logo',
	),
)); ?>
