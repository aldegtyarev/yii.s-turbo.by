<?php
/* @var $this ShopCategoriesController */
/* @var $model ShopCategories */

$this->breadcrumbs=array(
	'Shop Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ShopCategories', 'url'=>array('index')),
	array('label'=>'Create ShopCategories', 'url'=>array('create')),
	array('label'=>'Update ShopCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ShopCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopCategories', 'url'=>array('admin')),
);
?>

<h1>View ShopCategories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'root',
		'lft',
		'rgt',
		'level',
		'name',
		'title',
		'keywords',
		'description',
		'alias',
		'ordering',
		'category_companies',
		'cat_column',
	),
)); ?>
