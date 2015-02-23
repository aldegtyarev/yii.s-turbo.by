<?php
/* @var $this ShopadmincategoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shop Admin Categories',
);

$this->menu=array(
	array('label'=>'Create ShopAdminCategories', 'url'=>array('create')),
	array('label'=>'Manage ShopAdminCategories', 'url'=>array('admin')),
);
?>

<h1>Shop Admin Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
