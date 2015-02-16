<?php
/* @var $this ShopManufacturersController */
/* @var $model ShopManufacturers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php //$form=$this->beginWidget('CActiveForm', array(
	$form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'shop-manufacturers-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer_name'); ?>
		<?php echo $form->textField($model,'manufacturer_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'manufacturer_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer_description'); ?>
		<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
			  'model'=>$model,
			  'attribute'=>'manufacturer_description',
			  'language'=>'ru',
			  'editorTemplate'=>'full',
			  'height'=>'200px'
		)); ?>	
		<?php echo $form->error($model,'manufacturer_description'); ?>
	</div>
	

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer_logo'); ?>
		<?php echo $form->textField($model,'manufacturer_logo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'manufacturer_logo'); ?>
	</div>

	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->