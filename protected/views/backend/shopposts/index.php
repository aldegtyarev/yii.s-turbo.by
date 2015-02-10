<?php
/* @var $this ShopPostsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shop Posts',
);

$this->menu=array(
	array('label'=>'Create ShopPosts', 'url'=>array('create')),
	array('label'=>'Manage ShopPosts', 'url'=>array('admin')),
);
?>

<h1>Shop Posts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
