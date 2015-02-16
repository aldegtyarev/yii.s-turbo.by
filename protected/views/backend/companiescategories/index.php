<?php
/* @var $this CompaniesCategoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Companies Categories',
);

$this->menu=array(
	array('label'=>'Create CompaniesCategories', 'url'=>array('create')),
	array('label'=>'Manage CompaniesCategories', 'url'=>array('admin')),
);
?>

<h1>Companies Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
