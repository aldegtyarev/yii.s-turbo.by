<?php
/* @var $this ShopBodiesController */
/* @var $model ShopBodies */

$this->breadcrumbs=array(
	'Shop Bodies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShopBodies', 'url'=>array('index')),
	array('label'=>'Manage ShopBodies', 'url'=>array('admin')),
);
?>

<h1>Create ShopBodies</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>