<?php
/* @var $this ShopManufacturersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shop Manufacturers',
);

$this->menu=array(
	array('label'=>'Create ShopManufacturers', 'url'=>array('create')),
	array('label'=>'Manage ShopManufacturers', 'url'=>array('admin')),
);
?>

<h1>Shop Manufacturers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
