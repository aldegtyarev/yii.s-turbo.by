<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'currencies-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_name'); ?>
		<?php echo $form->textField($model,'currency_name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'currency_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_code'); ?>
		<?php echo $form->textField($model,'currency_code',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'currency_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_code_iso'); ?>
		<?php echo $form->textField($model,'currency_code_iso',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'currency_code_iso'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_code_num'); ?>
		<?php echo $form->textField($model,'currency_code_num',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'currency_code_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_ordering'); ?>
		<?php echo $form->textField($model,'currency_ordering'); ?>
		<?php echo $form->error($model,'currency_ordering'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_value'); ?>
		<?php echo $form->textField($model,'currency_value',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'currency_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_publish'); ?>
		<?php echo $form->textField($model,'currency_publish'); ?>
		<?php echo $form->error($model,'currency_publish'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'precision'); ?>
		<?php echo $form->textField($model,'precision'); ?>
		<?php echo $form->error($model,'precision'); ?>
	</div>

	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->