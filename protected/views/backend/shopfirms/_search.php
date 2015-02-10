<?php
/* @var $this ShopFirmsController */
/* @var $model ShopFirms */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'firm_id'); ?>
		<?php echo $form->textField($model,'firm_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firm_name'); ?>
		<?php echo $form->textField($model,'firm_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firm_description'); ?>
		<?php echo $form->textArea($model,'firm_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firm_logo'); ?>
		<?php echo $form->textField($model,'firm_logo',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->