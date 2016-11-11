<?php
/* @var $this ProductcommentsController */
/* @var $model ProductComments */

$this->breadcrumbs=array(
	'Product Comments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductComments', 'url'=>array('index')),
	array('label'=>'Create ProductComments', 'url'=>array('create')),
	array('label'=>'Update ProductComments', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductComments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductComments', 'url'=>array('admin')),
);
?>

<h1>View ProductComments #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_id',
		'comment',
		'answer',
	),
)); ?>
