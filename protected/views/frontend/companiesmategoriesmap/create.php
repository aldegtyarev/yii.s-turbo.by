<?php
/* @var $this CompaniesCategoriesMapController */
/* @var $model CompaniesCategoriesMap */

$this->breadcrumbs=array(
	'Companies Categories Maps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CompaniesCategoriesMap', 'url'=>array('index')),
	array('label'=>'Manage CompaniesCategoriesMap', 'url'=>array('admin')),
);
?>

<h1>Create CompaniesCategoriesMap</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>