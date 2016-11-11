<?php
/* @var $this ProductcommentsController */
/* @var $model ProductComments */

$this->breadcrumbs=array(
	'Комментарии'=>array('admin'),
	'Добавить комментарий',
);

$this->menu=array(
	array('label'=>'Комментарии', 'url'=>array('admin')),
);
?>

<h1>Добавить комментарий</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>