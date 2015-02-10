<?php
/* @var $this ShopManufacturersController */
/* @var $model ShopManufacturers */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'manufacturer_id'); ?>
		<?php echo $form->textField($model,'manufacturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manufacturer_name'); ?>
		<?php echo $form->textField($model,'manufacturer_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manufacturer_description'); ?>
		<?php echo $form->textArea($model,'manufacturer_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manufacturer_logo'); ?>
		<?php echo $form->textField($model,'manufacturer_logo',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->