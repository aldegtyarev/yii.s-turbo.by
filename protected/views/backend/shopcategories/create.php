<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'Категории магазина'=>array('admin'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Категории магазина', 'url'=>array('admin')),
);
?>

<h1>Новая категория</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>