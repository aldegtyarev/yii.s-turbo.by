<?php
/* @var $this ShopPostsController */
/* @var $model ShopPosts */

$this->breadcrumbs=array(
	'Shop Posts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShopPosts', 'url'=>array('index')),
	array('label'=>'Manage ShopPosts', 'url'=>array('admin')),
);
?>

<h1>Create ShopPosts</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>