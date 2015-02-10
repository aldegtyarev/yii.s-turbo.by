<?php
/* @var $this CompaniesCategoriesController */
/* @var $model CompaniesCategories */

$this->breadcrumbs=array(
	'Companies Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CompaniesCategories', 'url'=>array('index')),
	array('label'=>'Manage CompaniesCategories', 'url'=>array('admin')),
);
?>

<h1>Create CompaniesCategories</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>