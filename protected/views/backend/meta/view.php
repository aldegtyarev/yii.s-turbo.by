<?php
/* @var $this MetaController */
/* @var $model Meta */

$this->breadcrumbs=array(
	'Metas'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Meta', 'url'=>array('index')),
	array('label'=>'Create Meta', 'url'=>array('create')),
	array('label'=>'Update Meta', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Meta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Meta', 'url'=>array('admin')),
);
?>

<h1>View Meta #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'metatitle',
		'metakey',
		'metadesc',
	),
)); ?>
