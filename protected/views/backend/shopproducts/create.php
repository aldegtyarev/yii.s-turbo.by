<?php
/* @var $this ShopProductsController */
/* @var $model ShopProducts */

$this->breadcrumbs=array(
	'Список товаров'=>array('admin'),
	'Новая товарная позиция',
);

$this->menu=array(
	array('label'=>'Список товаров', 'url'=>array('admin')),
);
?>

<h1>Новая товарная позиция</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'params'=>$params,)); ?>