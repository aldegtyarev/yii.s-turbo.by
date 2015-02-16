<?php
/* @var $this CompaniesCategoriesController */
/* @var $model CompaniesCategories */

$this->breadcrumbs=array(
	'Companies Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CompaniesCategories', 'url'=>array('index')),
	array('label'=>'Create CompaniesCategories', 'url'=>array('create')),
	array('label'=>'View CompaniesCategories', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CompaniesCategories', 'url'=>array('admin')),
);
?>

<h1>Update CompaniesCategories <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>