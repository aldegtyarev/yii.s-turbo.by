<?php
/* @var $this ShopProductTypesController */
/* @var $model ShopProductTypes */

$this->breadcrumbs=array(
	'Группа товаров'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Группа товаров', 'url'=>array('admin')),
	array('label'=>'Новый', 'url'=>array('create')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>