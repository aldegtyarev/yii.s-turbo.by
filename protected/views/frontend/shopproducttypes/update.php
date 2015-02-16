<?php
/* @var $this ShopProductTypesController */
/* @var $model ShopProductTypes */

$this->breadcrumbs=array(
	'Shop Product Types'=>array('index'),
	$model->type_id=>array('view','id'=>$model->type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShopProductTypes', 'url'=>array('index')),
	array('label'=>'Create ShopProductTypes', 'url'=>array('create')),
	array('label'=>'View ShopProductTypes', 'url'=>array('view', 'id'=>$model->type_id)),
	array('label'=>'Manage ShopProductTypes', 'url'=>array('admin')),
);
?>

<h1>Update ShopProductTypes <?php echo $model->type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>