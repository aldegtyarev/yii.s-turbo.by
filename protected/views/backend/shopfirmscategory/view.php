<?php
/* @var $this ShopFirmsCategoryController */
/* @var $model ShopFirmsCategory */

$this->breadcrumbs=array(
	'Shop Firms Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ShopFirmsCategory', 'url'=>array('index')),
	array('label'=>'Create ShopFirmsCategory', 'url'=>array('create')),
	array('label'=>'Update ShopFirmsCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ShopFirmsCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopFirmsCategory', 'url'=>array('admin')),
);
?>

<h1>View ShopFirmsCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
