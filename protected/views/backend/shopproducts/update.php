<?php
/* @var $this ShopProductsController */
/* @var $model ShopProducts */

$this->breadcrumbs=array(
	'Список товаров'=>array('admin'),
	$model->product_name,
);

$this->menu=array(
	array('label'=>'Список товаров', 'url'=>array('admin')),
	array('label'=>'Новый', 'url'=>array('create')),
	array('label'=>'Копировать', 'url'=>array('copy', 'id'=>$model->product_id)),
);
?>

<h1><?php echo $model->product_name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'params'=>$params,)); ?>