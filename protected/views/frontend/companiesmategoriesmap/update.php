<?php
/* @var $this CompaniesCategoriesMapController */
/* @var $model CompaniesCategoriesMap */

$this->breadcrumbs=array(
	'Companies Categories Maps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CompaniesCategoriesMap', 'url'=>array('index')),
	array('label'=>'Create CompaniesCategoriesMap', 'url'=>array('create')),
	array('label'=>'View CompaniesCategoriesMap', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CompaniesCategoriesMap', 'url'=>array('admin')),
);
?>

<h1>Update CompaniesCategoriesMap <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>