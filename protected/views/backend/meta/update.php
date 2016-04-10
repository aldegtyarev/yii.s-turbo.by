<?php
/* @var $this MetaController */
/* @var $model Meta */

$this->breadcrumbs=array(
	'Meta'=>array('admin'),
	'Изменить ' . $model->name,
);

$this->menu=array(
	array('label'=>'Meta', 'url'=>array('admin')),
);
?>

<h1>Изменить "<?php echo $model->name; ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>