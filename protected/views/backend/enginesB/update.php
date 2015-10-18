<?php
/* @var $this EnginesController */
/* @var $model Engines */

$this->breadcrumbs=array(
	'Объемы'=>array('admin'),
	'Редактирование '.$model->name,
);

$this->menu=array(
	array('label'=>'Объемы', 'url'=>array('admin')),
	array('label'=>'Добавить', 'url'=>array('create')),
);
?>

<h1>Редактирование <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>