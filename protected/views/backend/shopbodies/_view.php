<?php
/* @var $this ShopBodiesController */
/* @var $data ShopBodies */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('body_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->body_id), array('view', 'id'=>$data->body_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order')); ?>:</b>
	<?php echo CHtml::encode($data->order); ?>
	<br />


</div>