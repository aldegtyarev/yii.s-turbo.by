<?php
/* @var $this ShopModelsAutoController */
/* @var $model ShopModelsAuto */

$this->breadcrumbs=array(
	'Shop Models Autos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShopModelsAuto', 'url'=>array('index')),
	array('label'=>'Manage ShopModelsAuto', 'url'=>array('admin')),
);
?>

<h1>Create ShopModelsAuto</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>