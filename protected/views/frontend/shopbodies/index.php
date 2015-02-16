<?php
/* @var $this ShopBodiesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shop Bodies',
);

$this->menu=array(
	array('label'=>'Create ShopBodies', 'url'=>array('create')),
	array('label'=>'Manage ShopBodies', 'url'=>array('admin')),
);
?>

<h1>Shop Bodies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
