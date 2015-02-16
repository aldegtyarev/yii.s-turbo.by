<?php
/* @var $this ShopProductsController */
/* @var $model ShopProducts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shop-products-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_s_desc'); ?>
		<?php echo $form->textField($model,'product_s_desc',array('size'=>60,'maxlength'=>2000)); ?>
		<?php echo $form->error($model,'product_s_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_desc'); ?>
		<?php echo $form->textField($model,'product_desc',array('size'=>60,'maxlength'=>18500)); ?>
		<?php echo $form->error($model,'product_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_name'); ?>
		<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>180)); ?>
		<?php echo $form->error($model,'product_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_name_manual'); ?>
		<?php echo $form->textArea($model,'product_name_manual',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'product_name_manual'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_sku'); ?>
		<?php echo $form->textField($model,'product_sku',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'product_sku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metadesc'); ?>
		<?php echo $form->textField($model,'metadesc',array('size'=>60,'maxlength'=>192)); ?>
		<?php echo $form->error($model,'metadesc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metakey'); ?>
		<?php echo $form->textField($model,'metakey',array('size'=>60,'maxlength'=>192)); ?>
		<?php echo $form->error($model,'metakey'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customtitle'); ?>
		<?php echo $form->textField($model,'customtitle',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'customtitle'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('size'=>60,'maxlength'=>192)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_video'); ?>
		<?php echo $form->textField($model,'product_video',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'product_video'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_charact'); ?>
		<?php echo $form->textArea($model,'product_charact',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'product_charact'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_brand_id'); ?>
		<?php echo $form->textField($model,'product_brand_id'); ?>
		<?php echo $form->error($model,'product_brand_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_type_id'); ?>
		<?php echo $form->textField($model,'product_type_id'); ?>
		<?php echo $form->error($model,'product_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'for_dogs'); ?>
		<?php echo $form->textField($model,'for_dogs'); ?>
		<?php echo $form->error($model,'for_dogs'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'protect_copy'); ?>
		<?php echo $form->textField($model,'protect_copy'); ?>
		<?php echo $form->error($model,'protect_copy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_in_stock'); ?>
		<?php echo $form->textField($model,'product_in_stock'); ?>
		<?php echo $form->error($model,'product_in_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_ordered'); ?>
		<?php echo $form->textField($model,'product_ordered'); ?>
		<?php echo $form->error($model,'product_ordered'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->