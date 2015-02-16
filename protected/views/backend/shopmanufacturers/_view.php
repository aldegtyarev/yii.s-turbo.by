<?php
/* @var $this ShopManufacturersController */
/* @var $data ShopManufacturers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->manufacturer_id), array('view', 'id'=>$data->manufacturer_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer_name')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer_description')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer_logo')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer_logo); ?>
	<br />


</div>