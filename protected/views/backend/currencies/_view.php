<?php
/* @var $this CurrenciesController */
/* @var $data Currencies */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->currency_id), array('view', 'id'=>$data->currency_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_name')); ?>:</b>
	<?php echo CHtml::encode($data->currency_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_code')); ?>:</b>
	<?php echo CHtml::encode($data->currency_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_code_iso')); ?>:</b>
	<?php echo CHtml::encode($data->currency_code_iso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_code_num')); ?>:</b>
	<?php echo CHtml::encode($data->currency_code_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_ordering')); ?>:</b>
	<?php echo CHtml::encode($data->currency_ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_value')); ?>:</b>
	<?php echo CHtml::encode($data->currency_value); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_publish')); ?>:</b>
	<?php echo CHtml::encode($data->currency_publish); ?>
	<br />

	*/ ?>

</div>