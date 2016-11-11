<?php
/* @var $this ProductcommentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Comments',
);

$this->menu=array(
	array('label'=>'Create ProductComments', 'url'=>array('create')),
	array('label'=>'Manage ProductComments', 'url'=>array('admin')),
);
?>

<h1>Product Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
