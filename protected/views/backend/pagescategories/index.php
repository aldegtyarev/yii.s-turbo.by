<?php
/* @var $this PagescategoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pages Categories',
);

$this->menu=array(
	array('label'=>'Create PagesCategories', 'url'=>array('create')),
	array('label'=>'Manage PagesCategories', 'url'=>array('admin')),
);
?>

<h1>Pages Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
