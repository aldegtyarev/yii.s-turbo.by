<?php
/* @var $this ShopPostsController */
/* @var $model ShopPosts */

$this->breadcrumbs=array(
	'Shop Posts'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List ShopPosts', 'url'=>array('index')),
	array('label'=>'Create ShopPosts', 'url'=>array('create')),
	array('label'=>'Update ShopPosts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ShopPosts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopPosts', 'url'=>array('admin')),
);
?>

<h1>View ShopPosts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'alias',
		'published',
		'introtext',
		'fulltext',
		'created',
		'hits',
		'metadesc',
		'metadata',
		'metakey',
	),
)); ?>
