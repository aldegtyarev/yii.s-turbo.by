<?php
/* @var $this ShopProductsController */
/* @var $data ShopProducts */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->product_id), array('view', 'id'=>$data->product_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_s_desc')); ?>:</b>
	<?php echo CHtml::encode($data->product_s_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_desc')); ?>:</b>
	<?php echo CHtml::encode($data->product_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_name')); ?>:</b>
	<?php echo CHtml::encode($data->product_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_name_manual')); ?>:</b>
	<?php echo CHtml::encode($data->product_name_manual); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_sku')); ?>:</b>
	<?php echo CHtml::encode($data->product_sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metadesc')); ?>:</b>
	<?php echo CHtml::encode($data->metadesc); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('metakey')); ?>:</b>
	<?php echo CHtml::encode($data->metakey); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customtitle')); ?>:</b>
	<?php echo CHtml::encode($data->customtitle); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo CHtml::encode($data->slug); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_video')); ?>:</b>
	<?php echo CHtml::encode($data->product_video); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_charact')); ?>:</b>
	<?php echo CHtml::encode($data->product_charact); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_firm_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_firm_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('for_dogs')); ?>:</b>
	<?php echo CHtml::encode($data->for_dogs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('protect_copy')); ?>:</b>
	<?php echo CHtml::encode($data->protect_copy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_in_stock')); ?>:</b>
	<?php echo CHtml::encode($data->product_in_stock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_ordered')); ?>:</b>
	<?php echo CHtml::encode($data->product_ordered); ?>
	<br />

	*/ ?>

</div>