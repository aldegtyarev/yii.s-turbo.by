<?php
/* @var $this ShopManufacturersController */
/* @var $model ShopManufacturers */

$this->breadcrumbs=array(
	'Shop Manufacturers'=>array('index'),
	$model->manufacturer_id=>array('view','id'=>$model->manufacturer_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShopManufacturers', 'url'=>array('index')),
	array('label'=>'Create ShopManufacturers', 'url'=>array('create')),
	array('label'=>'View ShopManufacturers', 'url'=>array('view', 'id'=>$model->manufacturer_id)),
	array('label'=>'Manage ShopManufacturers', 'url'=>array('admin')),
);
?>

<h1>Update ShopManufacturers <?php echo $model->manufacturer_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>