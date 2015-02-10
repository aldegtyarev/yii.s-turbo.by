<?php
/* @var $this ShopBodiesController */
/* @var $model ShopBodies */

$this->breadcrumbs=array(
	'Shop Bodies'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ShopBodies', 'url'=>array('index')),
	array('label'=>'Create ShopBodies', 'url'=>array('create')),
	array('label'=>'Update ShopBodies', 'url'=>array('update', 'id'=>$model->body_id)),
	array('label'=>'Delete ShopBodies', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->body_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopBodies', 'url'=>array('admin')),
);
?>

<h1>View ShopBodies #<?php echo $model->body_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'body_id',
		'name',
		'order',
	),
)); ?>
