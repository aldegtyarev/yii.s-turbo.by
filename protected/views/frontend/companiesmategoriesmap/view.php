<?php
/* @var $this CompaniesCategoriesMapController */
/* @var $model CompaniesCategoriesMap */

$this->breadcrumbs=array(
	'Companies Categories Maps'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CompaniesCategoriesMap', 'url'=>array('index')),
	array('label'=>'Create CompaniesCategoriesMap', 'url'=>array('create')),
	array('label'=>'Update CompaniesCategoriesMap', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CompaniesCategoriesMap', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CompaniesCategoriesMap', 'url'=>array('admin')),
);
?>

<h1>View CompaniesCategoriesMap #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'company_id',
		'category_id',
		'ordering',
	),
)); ?>
