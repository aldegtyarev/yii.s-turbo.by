<?php
/* @var $this ShopadmincategoriesController */
/* @var $model ShopAdminCategories */

$this->breadcrumbs=array(
	'Shop Admin Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ShopAdminCategories', 'url'=>array('index')),
	array('label'=>'Create ShopAdminCategories', 'url'=>array('create')),
	array('label'=>'Update ShopAdminCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ShopAdminCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopAdminCategories', 'url'=>array('admin')),
);
?>

<h1>View ShopAdminCategories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'root',
		'lft',
		'rgt',
		'level',
		'parent_id',
		'name',
		'ordering',
	),
)); ?>
