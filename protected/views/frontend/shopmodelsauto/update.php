<?php
/* @var $this ShopModelsAutoController */
/* @var $model ShopModelsAuto */

$this->breadcrumbs=array(
	'Shop Models Autos'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShopModelsAuto', 'url'=>array('index')),
	array('label'=>'Create ShopModelsAuto', 'url'=>array('create')),
	array('label'=>'View ShopModelsAuto', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ShopModelsAuto', 'url'=>array('admin')),
);
?>

<h1>Update ShopModelsAuto <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>