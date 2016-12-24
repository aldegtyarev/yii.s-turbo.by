<?php
/* @var $this ShopFirmsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shop Firms',
);

$this->menu=array(
	array('label'=>'Create ShopFirms', 'url'=>array('create')),
	array('label'=>'Manage ShopFirms', 'url'=>array('admin')),
);
?>

<h1>Shop Firms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
