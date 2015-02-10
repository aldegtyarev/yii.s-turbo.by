<?php
/* @var $this ShopFirmsController */
/* @var $model ShopFirms */

$this->breadcrumbs=array(
	'Shop Firms'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShopFirms', 'url'=>array('index')),
	array('label'=>'Manage ShopFirms', 'url'=>array('admin')),
);
?>

<h1>Create ShopFirms</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>