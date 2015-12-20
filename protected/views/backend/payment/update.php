<?php
/* @var $this PaymentController */
/* @var $model Payment */

$this->breadcrumbs=array(
	'Способы оплаты'=>array('admin'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Способы оплаты', 'url'=>array('admin')),
	array('label'=>'Добавить', 'url'=>array('create')),
	
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'deliveries'=>$deliveries,)); ?>