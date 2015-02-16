<?php
/* @var $this CompaniesCategoriesMapController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Companies Categories Maps',
);

$this->menu=array(
	array('label'=>'Create CompaniesCategoriesMap', 'url'=>array('create')),
	array('label'=>'Manage CompaniesCategoriesMap', 'url'=>array('admin')),
);
?>

<h1>Companies Categories Maps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
