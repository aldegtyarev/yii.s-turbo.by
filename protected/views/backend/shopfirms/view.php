<?php
/* @var $this ShopFirmsController */
/* @var $model ShopFirms */

$this->breadcrumbs=array(
	'Shop Firms'=>array('index'),
	$model->firm_id,
);

$this->menu=array(
	array('label'=>'List ShopFirms', 'url'=>array('index')),
	array('label'=>'Create ShopFirms', 'url'=>array('create')),
	array('label'=>'Update ShopFirms', 'url'=>array('update', 'id'=>$model->firm_id)),
	array('label'=>'Delete ShopFirms', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->firm_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopFirms', 'url'=>array('admin')),
);
?>

<h1>View ShopFirms #<?php echo $model->firm_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'firm_id',
		'firm_name',
		'firm_description',
		'firm_logo',
	),
)); ?>
