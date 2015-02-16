<?php
/* @var $this ShopModelsAutoController */
/* @var $model ShopModelsAuto */

$this->breadcrumbs=array(
	'Shop Models Autos'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ShopModelsAuto', 'url'=>array('index')),
	array('label'=>'Create ShopModelsAuto', 'url'=>array('create')),
	array('label'=>'Update ShopModelsAuto', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ShopModelsAuto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopModelsAuto', 'url'=>array('admin')),
);
?>

<h1>View ShopModelsAuto #<?php echo $model->id; ?></h1>

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
		'title',
		'keywords',
		'description',
		'alias',
		'path',
		'ordering',
		'category_companies',
		'cat_column',
		'anchor_css',
		'show_in_menu',
		'category_description',
	),
)); ?>
