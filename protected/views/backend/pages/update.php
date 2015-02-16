<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'Страницы'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Страницы', 'url'=>array('admin')),
//	/array('label'=>'List Pages', 'url'=>array('index')),
	array('label'=>'Новая', 'url'=>array('create')),
	//array('label'=>'View Pages', 'url'=>array('view', 'id'=>$model->id)),
	
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>