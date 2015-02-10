<?php
/* @var $this ShopCategoriesController */
/* @var $model ShopCategories */

$this->breadcrumbs=array(
	'Shop Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShopCategories', 'url'=>array('index')),
	array('label'=>'Create ShopCategories', 'url'=>array('create')),
	array('label'=>'View ShopCategories', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ShopCategories', 'url'=>array('admin')),
);
?>

<h1>Update ShopCategories <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>