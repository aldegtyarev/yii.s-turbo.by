<?php
/* @var $this ShopProductTypesController */
/* @var $model ShopProductTypes */

$this->breadcrumbs=array(
	'Список товаров'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Список товаров', 'url'=>array('admin')),
	array('label'=>'Новый', 'url'=>array('create')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>