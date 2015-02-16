<?php
/* @var $this ShopManufacturersController */
/* @var $model ShopManufacturers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shop-manufacturers-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer_name'); ?>
		<?php echo $form->textField($model,'manufacturer_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'manufacturer_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer_description'); ?>
		<?php echo $form->textArea($model,'manufacturer_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'manufacturer_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer_logo'); ?>
		<?php echo $form->textField($model,'manufacturer_logo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'manufacturer_logo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->