<?php
/* @var $this ShopFirmsController */
/* @var $model ShopFirms */

$this->breadcrumbs=array(
	'Фирмы'=>array('admin'),
	$model->firm_name,
);

$this->menu=array(
	array('label'=>'Фирмы', 'url'=>array('admin')),
	array('label'=>'Новый', 'url'=>array('create')),
	//array('label'=>'View ShopFirms', 'url'=>array('view', 'id'=>$model->firm_id)),
);
?>

<h1><?php echo $model->firm_name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>