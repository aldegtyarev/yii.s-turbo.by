<?php
/* @var $this ShopProductTypesController */
/* @var $model ShopProductTypes */

$this->breadcrumbs=array(
	'Список товаров'=>array('admin'),
	$model->type_name,
);

$this->menu=array(
	array('label'=>'Список товаров', 'url'=>array('admin')),
	array('label'=>'Новый', 'url'=>array('create')),
);
?>

<h1><?php echo $model->type_name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>