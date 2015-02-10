<?php
/* @var $this ShopCategoriesController */
/* @var $data ShopCategories */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('root')); ?>:</b>
	<?php echo CHtml::encode($data->root); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lft')); ?>:</b>
	<?php echo CHtml::encode($data->lft); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rgt')); ?>:</b>
	<?php echo CHtml::encode($data->rgt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level')); ?>:</b>
	<?php echo CHtml::encode($data->level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('keywords')); ?>:</b>
	<?php echo CHtml::encode($data->keywords); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_companies')); ?>:</b>
	<?php echo CHtml::encode($data->category_companies); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cat_column')); ?>:</b>
	<?php echo CHtml::encode($data->cat_column); ?>
	<br />

	*/ ?>

</div>