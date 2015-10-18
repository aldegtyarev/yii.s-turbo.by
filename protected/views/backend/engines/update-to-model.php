<?php
/* @var $this EnginesController */
/* @var $model Engines */

$this->breadcrumbs=array(
	$model_title => array('shopmodelsauto/update', 'id'=>$model->model_id),
	'Двигатели'=>array('modellist', 'model_id'=>$model->model_id),
	'Редактирование двигателя '.$model_title.' '.$model->name,
);

$this->menu=array(
	array('label'=>'Двигатели', 'url'=>array('modellist', 'model_id'=>$model->model_id)),
	array('label'=>'Добавить', 'url'=>array('createtomodel', 'id'=>$model->model_id)),
);
?>

<h1>Редактирование <?php echo $model_title.' '.$model->name; ?></h1>

<?php $this->renderPartial('_form-to-model', array('model'=>$model)); ?>