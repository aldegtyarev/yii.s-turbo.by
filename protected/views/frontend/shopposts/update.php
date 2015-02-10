<?php
/* @var $this ShopPostsController */
/* @var $model ShopPosts */

$this->breadcrumbs=array(
	'Shop Posts'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShopPosts', 'url'=>array('index')),
	array('label'=>'Create ShopPosts', 'url'=>array('create')),
	array('label'=>'View ShopPosts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ShopPosts', 'url'=>array('admin')),
);
?>

<h1>Update ShopPosts <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>