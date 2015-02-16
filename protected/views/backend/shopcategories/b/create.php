<?php
/* @var $this ShopCategoriesController */
/* @var $model ShopCategories */

$this->breadcrumbs=array(
	'Shop Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShopCategories', 'url'=>array('index')),
	array('label'=>'Manage ShopCategories', 'url'=>array('admin')),
);
?>

<h1>Create ShopCategories</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>