<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

$this->breadcrumbs=array(
	'Currencies'=>array('index'),
	$model->currency_id,
);

$this->menu=array(
	array('label'=>'List Currencies', 'url'=>array('index')),
	array('label'=>'Create Currencies', 'url'=>array('create')),
	array('label'=>'Update Currencies', 'url'=>array('update', 'id'=>$model->currency_id)),
	array('label'=>'Delete Currencies', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->currency_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Currencies', 'url'=>array('admin')),
);
?>

<h1>View Currencies #<?php echo $model->currency_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'currency_id',
		'currency_name',
		'currency_code',
		'currency_code_iso',
		'currency_code_num',
		'currency_ordering',
		'currency_value',
		'currency_publish',
	),
)); ?>
