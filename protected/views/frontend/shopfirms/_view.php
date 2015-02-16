<?php
/* @var $this ShopFirmsController */
/* @var $data ShopFirms */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('firm_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->firm_id), array('view', 'id'=>$data->firm_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firm_name')); ?>:</b>
	<?php echo CHtml::encode($data->firm_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firm_description')); ?>:</b>
	<?php echo CHtml::encode($data->firm_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firm_logo')); ?>:</b>
	<?php echo CHtml::encode($data->firm_logo); ?>
	<br />


</div>