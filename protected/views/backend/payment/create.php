<?php
/* @var $this PaymentController */
/* @var $model Payment */

$this->breadcrumbs=array(
	'Способы оплаты'=>array('admin'),
	'Новая',
);

$this->menu=array(
	array('label'=>'Способы оплаты', 'url'=>array('admin')),
);
?>

<h1>Create Payment</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'deliveries'=>$deliveries,)); ?>