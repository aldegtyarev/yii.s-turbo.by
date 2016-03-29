<?php
/* @var $this MetaController */
/* @var $model Meta */

$this->breadcrumbs=array(
	'Meta'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Meta', 'url'=>array('admin')),
);
?>

<h1>Создание мета-описания</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>