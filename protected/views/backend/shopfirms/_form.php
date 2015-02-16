<?php
/* @var $this ShopFirmsController */
/* @var $model ShopFirms */
/* @var $form CActiveForm */
?>

<div class="form">

<?php //$form=$this->beginWidget('CActiveForm', array(
$form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'shop-firms-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'firm_name'); ?>
		<?php echo $form->textField($model,'firm_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'firm_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firm_description'); ?>
		<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
			  'model'=>$model,
			  'attribute'=>'firm_description',
			  'language'=>'ru',
			  'editorTemplate'=>'full',
			  'height'=>'200px'
		)); ?>	
		<?php echo $form->error($model,'firm_description'); ?>
	</div>
	

	<div class="row">
		<?php echo $form->labelEx($model,'firm_logo'); ?>
		<?php echo $form->textField($model,'firm_logo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'firm_logo'); ?>
	</div>

	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->