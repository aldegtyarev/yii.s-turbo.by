<?php
/* @var $this ShopBodiesController */
/* @var $model ShopBodies */

$this->breadcrumbs=array(
	'Shop Bodies'=>array('index'),
	$model->name=>array('view','id'=>$model->body_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShopBodies', 'url'=>array('index')),
	array('label'=>'Create ShopBodies', 'url'=>array('create')),
	array('label'=>'View ShopBodies', 'url'=>array('view', 'id'=>$model->body_id)),
	array('label'=>'Manage ShopBodies', 'url'=>array('admin')),
);
?>

<h1>Update ShopBodies <?php echo $model->body_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>