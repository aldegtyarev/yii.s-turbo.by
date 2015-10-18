<?php
/* @var $this EnginesController */
/* @var $model Engines */

$this->breadcrumbs=array(
	$model_title => array('shopmodelsauto/update', 'id'=>$model->model_id),
	'Двигатели'=>array('modellist', 'model_id'=>$model->model_id),
	'Добавить двигатель для '.$model_title,
);

$this->menu=array(
	array('label'=>'List Engines', 'url'=>array('index')),
	array('label'=>'Manage Engines', 'url'=>array('admin')),
);
?>

<h1>Добавить двигатель для <?php echo $model_title; ?></h1>

<?php $this->renderPartial('_form-to-model', array('model'=>$model)); ?>