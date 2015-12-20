<?php
/* @var $this ShopProductTypesController */
/* @var $model ShopProductTypes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'shop-product-types-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'dropDownListTree'); ?>
			<?php echo $form->dropDownList($model, 'parentId', $model->DropDownlistData); ?>
			<?php echo $form->error($model,'dropDownListTree'); ?>		
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'cargo_type'); ?>
			<?php echo $form->dropDownList($model, 'cargo_type', Delivery::model()->cargoTypesList, array('options' => $model->cargo_type, 'empty'=>'Выберите'));?>
			<?php echo $form->error($model,'cargo_type'); ?>
		</div>
	</div>
	

	<div class="row buttons">
		<div class="col-lg-12">
			<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS)); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->