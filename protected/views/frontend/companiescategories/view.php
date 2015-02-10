<?php
/* @var $this CompaniesCategoriesController */
/* @var $model CompaniesCategories */

$this->breadcrumbs=array(
	'Companies Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CompaniesCategories', 'url'=>array('index')),
	array('label'=>'Create CompaniesCategories', 'url'=>array('create')),
	array('label'=>'Update CompaniesCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CompaniesCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CompaniesCategories', 'url'=>array('admin')),
);
?>

<h1>View CompaniesCategories #<?php echo $model->id; ?></h1>

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
