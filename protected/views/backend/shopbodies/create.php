<?php
/* @var $this ShopBodiesController */
/* @var $model ShopBodies */

$this->breadcrumbs=array(
	'Кузова'=>array('admin'),
	'Новый',
);

$this->menu=array(
	//array('label'=>'List ShopBodies', 'url'=>array('index')),
	array('label'=>'Кузова', 'url'=>array('admin')),
);
?>

<h1>Новый</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>