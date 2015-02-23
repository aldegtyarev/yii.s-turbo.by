<?php
/* @var $this ShopadmincategoriesController */
/* @var $model ShopAdminCategories */

$this->breadcrumbs=array(
	'Адм. категории'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Адм. категории', 'url'=>array('admin')),
	array('label'=>'Новая', 'url'=>array('create')),
	
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>