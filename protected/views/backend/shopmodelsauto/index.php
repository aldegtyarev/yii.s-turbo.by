<?php
/* @var $this ShopModelsAutoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shop Models Autos',
);

$this->menu=array(
	array('label'=>'Create ShopModelsAuto', 'url'=>array('create')),
	array('label'=>'Manage ShopModelsAuto', 'url'=>array('admin')),
);
?>

<h1>Shop Models Autos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
