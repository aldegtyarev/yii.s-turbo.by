<?php
/* @var $this ShopProductTypesController */
/* @var $model ShopProductTypes */

$this->breadcrumbs=array(
	'Shop Product Types'=>array('index'),
	$model->type_id,
);

$this->menu=array(
	array('label'=>'List ShopProductTypes', 'url'=>array('index')),
	array('label'=>'Create ShopProductTypes', 'url'=>array('create')),
	array('label'=>'Update ShopProductTypes', 'url'=>array('update', 'id'=>$model->type_id)),
	array('label'=>'Delete ShopProductTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopProductTypes', 'url'=>array('admin')),
);
?>

<h1>View ShopProductTypes #<?php echo $model->type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'type_id',
		'type_name',
	),
)); ?>
