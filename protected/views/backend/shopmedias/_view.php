<?php
/* @var $this ShopMediasController */
/* @var $data ShopMedias */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('virtuemart_media_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->virtuemart_media_id), array('view', 'id'=>$data->virtuemart_media_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_title')); ?>:</b>
	<?php echo CHtml::encode($data->file_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_description')); ?>:</b>
	<?php echo CHtml::encode($data->file_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_meta')); ?>:</b>
	<?php echo CHtml::encode($data->file_meta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_mimetype')); ?>:</b>
	<?php echo CHtml::encode($data->file_mimetype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_type')); ?>:</b>
	<?php echo CHtml::encode($data->file_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_url')); ?>:</b>
	<?php echo CHtml::encode($data->file_url); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('file_url_thumb')); ?>:</b>
	<?php echo CHtml::encode($data->file_url_thumb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_is_product_image')); ?>:</b>
	<?php echo CHtml::encode($data->file_is_product_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_is_downloadable')); ?>:</b>
	<?php echo CHtml::encode($data->file_is_downloadable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_is_forSale')); ?>:</b>
	<?php echo CHtml::encode($data->file_is_forSale); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_params')); ?>:</b>
	<?php echo CHtml::encode($data->file_params); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shared')); ?>:</b>
	<?php echo CHtml::encode($data->shared); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('published')); ?>:</b>
	<?php echo CHtml::encode($data->published); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_on')); ?>:</b>
	<?php echo CHtml::encode($data->created_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	*/ ?>

</div>