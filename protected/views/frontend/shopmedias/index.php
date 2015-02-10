<?php
/* @var $this ShopMediasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shop Mediases',
);

$this->menu=array(
	array('label'=>'Create ShopMedias', 'url'=>array('create')),
	array('label'=>'Manage ShopMedias', 'url'=>array('admin')),
);
?>

<h1>Shop Mediases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
