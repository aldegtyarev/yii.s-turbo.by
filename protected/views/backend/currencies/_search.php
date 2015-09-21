<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'currency_id'); ?>
		<?php echo $form->textField($model,'currency_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_name'); ?>
		<?php echo $form->textField($model,'currency_name',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_code'); ?>
		<?php echo $form->textField($model,'currency_code',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_code_iso'); ?>
		<?php echo $form->textField($model,'currency_code_iso',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_code_num'); ?>
		<?php echo $form->textField($model,'currency_code_num',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_ordering'); ?>
		<?php echo $form->textField($model,'currency_ordering'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_value'); ?>
		<?php echo $form->textField($model,'currency_value',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_publish'); ?>
		<?php echo $form->textField($model,'currency_publish'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->