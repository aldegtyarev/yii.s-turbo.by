<?php
/* @var $this EnginesController */
/* @var $model Engines */

$this->breadcrumbs=array(
	'Engines'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Engines', 'url'=>array('index')),
	array('label'=>'Create Engines', 'url'=>array('create')),
	array('label'=>'View Engines', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Engines', 'url'=>array('admin')),
);
?>

<h1>Update Engines <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>