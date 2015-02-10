<?php
/* @var $this ShopFirmsController */
/* @var $model ShopFirms */

$this->breadcrumbs=array(
	'Shop Firms'=>array('index'),
	$model->firm_id=>array('view','id'=>$model->firm_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShopFirms', 'url'=>array('index')),
	array('label'=>'Create ShopFirms', 'url'=>array('create')),
	array('label'=>'View ShopFirms', 'url'=>array('view', 'id'=>$model->firm_id)),
	array('label'=>'Manage ShopFirms', 'url'=>array('admin')),
);
?>

<h1>Update ShopFirms <?php echo $model->firm_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>