<?php
/* @var $this ShopProductTypesController */
/* @var $data ShopProductTypes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->type_id), array('view', 'id'=>$data->type_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_name')); ?>:</b>
	<?php echo CHtml::encode($data->type_name); ?>
	<br />


</div>