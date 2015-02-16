<?php
/* @var $this CompaniesController */
/* @var $data Companies */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('published')); ?>:</b>
	<?php echo CHtml::encode($data->published); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('introtext')); ?>:</b>
	<?php echo CHtml::encode($data->introtext); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fulltext')); ?>:</b>
	<?php echo CHtml::encode($data->fulltext); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trash')); ?>:</b>
	<?php echo CHtml::encode($data->trash); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('featured')); ?>:</b>
	<?php echo CHtml::encode($data->featured); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('featured_ordering')); ?>:</b>
	<?php echo CHtml::encode($data->featured_ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hits')); ?>:</b>
	<?php echo CHtml::encode($data->hits); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metadesc')); ?>:</b>
	<?php echo CHtml::encode($data->metadesc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metadata')); ?>:</b>
	<?php echo CHtml::encode($data->metadata); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metakey')); ?>:</b>
	<?php echo CHtml::encode($data->metakey); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('section')); ?>:</b>
	<?php echo CHtml::encode($data->section); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('region')); ?>:</b>
	<?php echo CHtml::encode($data->region); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('site')); ?>:</b>
	<?php echo CHtml::encode($data->site); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone_mts')); ?>:</b>
	<?php echo CHtml::encode($data->phone_mts); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone_vel')); ?>:</b>
	<?php echo CHtml::encode($data->phone_vel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscribers')); ?>:</b>
	<?php echo CHtml::encode($data->subscribers); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_comments')); ?>:</b>
	<?php echo CHtml::encode($data->company_comments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_rating')); ?>:</b>
	<?php echo CHtml::encode($data->company_rating); ?>
	<br />

	*/ ?>

</div>