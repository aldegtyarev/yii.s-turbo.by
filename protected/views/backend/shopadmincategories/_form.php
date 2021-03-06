<?php
/* @var $this ShopadmincategoriesController */
/* @var $model ShopAdminCategories */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'shop-admin-categories-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'dropDownListTree'); ?>
		<?php echo $form->dropDownList($model, 'parentId', $model->DropDownlistData, array('data-placeholder'=>'выберите...', 'options' => $model->SelectedCategory)); ?>
		<?php echo $form->error($model,'dropDownListTree'); ?>		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'price_discount'); ?>
		<?php echo $form->textField($model,'price_discount',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'price_discount'); ?>
	</div>
	
	

	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->