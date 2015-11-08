<?php
/* @var $this PagescategoriesController */
/* @var $model PagesCategories */

$this->breadcrumbs=array(
	'Pages Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List PagesCategories', 'url'=>array('index')),
	array('label'=>'Create PagesCategories', 'url'=>array('create')),
	array('label'=>'Update PagesCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PagesCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PagesCategories', 'url'=>array('admin')),
);
?>

<h1>View PagesCategories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'alias',
		'descr',
		'metatitle',
		'metakey',
		'metadesc',
	),
)); ?>
