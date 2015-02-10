<?php
/* @var $this ShopProductTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shop Product Types',
);

$this->menu=array(
	array('label'=>'Create ShopProductTypes', 'url'=>array('create')),
	array('label'=>'Manage ShopProductTypes', 'url'=>array('admin')),
);
?>

<h1>Shop Product Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
