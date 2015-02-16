<?php
/* @var $this ShopMediasController */
/* @var $model ShopMedias */

$this->breadcrumbs=array(
	'Shop Mediases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShopMedias', 'url'=>array('index')),
	array('label'=>'Manage ShopMedias', 'url'=>array('admin')),
);
?>

<h1>Create ShopMedias</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>