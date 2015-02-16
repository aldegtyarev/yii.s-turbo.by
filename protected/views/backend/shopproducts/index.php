<?php
/* @var $this ShopProductsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shop Products',
);

$this->menu=array(
	array('label'=>'Create ShopProducts', 'url'=>array('create')),
	array('label'=>'Manage ShopProducts', 'url'=>array('admin')),
);
?>

<h1>Shop Products</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
