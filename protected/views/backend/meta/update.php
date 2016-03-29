<?php
/* @var $this MetaController */
/* @var $model Meta */

$this->breadcrumbs=array(
	'Meta'=>array('admin'),
	'Изменить ' . $model->name,
);

$this->menu=array(
	array('label'=>'List Meta', 'url'=>array('index')),
	array('label'=>'Create Meta', 'url'=>array('create')),
	array('label'=>'View Meta', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Meta', 'url'=>array('admin')),
);
?>

<h1>Изменить "<?php echo $model->name; ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>