<?php
/* @var $this ShopBodiesController */
/* @var $model ShopBodies */

$this->breadcrumbs=array(
	'Кузова'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Кузова', 'url'=>array('admin')),	
	//array('label'=>'List ShopBodies', 'url'=>array('index')),
	array('label'=>'Новый', 'url'=>array('create')),
	//array('label'=>'View ShopBodies', 'url'=>array('view', 'id'=>$model->body_id)),
	
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>