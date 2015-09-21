<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

$this->breadcrumbs=array(
	'Список валют'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Список валют', 'url'=>array('admin')),
);
?>

<h1>Новая</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>