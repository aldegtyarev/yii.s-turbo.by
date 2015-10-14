<?php
/* @var $this EnginesController */
/* @var $model Engines */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'engines-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' =>	array(
		'enctype'=>'multipart/form-data',
	),
	
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'dropDownListTree'); ?>
		<?php echo $form->dropDownList($model, 'parentId', $model->DropDownlistData); ?>
		<?php echo $form->error($model,'dropDownListTree'); ?>		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fileImage'); ?>
		<?php echo $form->fileField($model, 'fileImage'); ?>				
		<?php echo $form->error($model,'fileImage'); ?>
	</div>
	<div class="row">
		
		<?php if($model->image_file != '') echo CHtml::image(Yii::app()->params->product_images_liveUrl.$model->image_file, '', array('class'=>'img-responsive')) ?>
		<?php //echo $form->fileField($model, 'fileImage'); ?>				
		<?php //echo $form->error($model,'fileImage'); ?>
	</div>

	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->