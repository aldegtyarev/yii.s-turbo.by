<?php
/* @var $this ShopMediasController */
/* @var $model ShopMedias */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shop-medias-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'file_title'); ?>
		<?php echo $form->textField($model,'file_title',array('size'=>60,'maxlength'=>126)); ?>
		<?php echo $form->error($model,'file_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_description'); ?>
		<?php echo $form->textField($model,'file_description',array('size'=>60,'maxlength'=>254)); ?>
		<?php echo $form->error($model,'file_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_meta'); ?>
		<?php echo $form->textField($model,'file_meta',array('size'=>60,'maxlength'=>254)); ?>
		<?php echo $form->error($model,'file_meta'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_mimetype'); ?>
		<?php echo $form->textField($model,'file_mimetype',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'file_mimetype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_type'); ?>
		<?php echo $form->textField($model,'file_type',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'file_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_url'); ?>
		<?php echo $form->textArea($model,'file_url',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'file_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_url_thumb'); ?>
		<?php echo $form->textField($model,'file_url_thumb',array('size'=>60,'maxlength'=>254)); ?>
		<?php echo $form->error($model,'file_url_thumb'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_is_product_image'); ?>
		<?php echo $form->textField($model,'file_is_product_image'); ?>
		<?php echo $form->error($model,'file_is_product_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_is_downloadable'); ?>
		<?php echo $form->textField($model,'file_is_downloadable'); ?>
		<?php echo $form->error($model,'file_is_downloadable'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_is_forSale'); ?>
		<?php echo $form->textField($model,'file_is_forSale'); ?>
		<?php echo $form->error($model,'file_is_forSale'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_params'); ?>
		<?php echo $form->textArea($model,'file_params',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'file_params'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shared'); ?>
		<?php echo $form->textField($model,'shared'); ?>
		<?php echo $form->error($model,'shared'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
		<?php echo $form->error($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_on'); ?>
		<?php echo $form->textField($model,'created_on'); ?>
		<?php echo $form->error($model,'created_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->