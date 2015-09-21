<?php
/* @var $this EnginesController */
/* @var $model Engines */

$this->breadcrumbs=array(
	'Engines'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Engines', 'url'=>array('index')),
	array('label'=>'Manage Engines', 'url'=>array('admin')),
);
?>

<h1>Create Engines</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>