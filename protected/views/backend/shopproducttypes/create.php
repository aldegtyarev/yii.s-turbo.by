<?php
/* @var $this ShopProductTypesController */
/* @var $model ShopProductTypes */

$this->breadcrumbs=array(
	'Группа товаров'=>array('admin'),
	'Новый',
);

$this->menu=array(
	//array('label'=>'List ShopProductTypes', 'url'=>array('index')),
	array('label'=>'Группа товаров', 'url'=>array('admin')),
);
?>

<h1>Новый</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>