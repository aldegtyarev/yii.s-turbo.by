<?php
/* @var $this ShopProductTypesController */
/* @var $model ShopProductTypes */

$this->breadcrumbs=array(
	'Shop Product Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShopProductTypes', 'url'=>array('index')),
	array('label'=>'Manage ShopProductTypes', 'url'=>array('admin')),
);
?>

<h1>Create ShopProductTypes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>