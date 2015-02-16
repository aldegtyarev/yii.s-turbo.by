<?php
/* @var $this ShopMediasController */
/* @var $model ShopMedias */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'virtuemart_media_id'); ?>
		<?php echo $form->textField($model,'virtuemart_media_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_title'); ?>
		<?php echo $form->textField($model,'file_title',array('size'=>60,'maxlength'=>126)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_description'); ?>
		<?php echo $form->textField($model,'file_description',array('size'=>60,'maxlength'=>254)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_meta'); ?>
		<?php echo $form->textField($model,'file_meta',array('size'=>60,'maxlength'=>254)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_mimetype'); ?>
		<?php echo $form->textField($model,'file_mimetype',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_type'); ?>
		<?php echo $form->textField($model,'file_type',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_url'); ?>
		<?php echo $form->textArea($model,'file_url',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_url_thumb'); ?>
		<?php echo $form->textField($model,'file_url_thumb',array('size'=>60,'maxlength'=>254)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_is_product_image'); ?>
		<?php echo $form->textField($model,'file_is_product_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_is_downloadable'); ?>
		<?php echo $form->textField($model,'file_is_downloadable'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_is_forSale'); ?>
		<?php echo $form->textField($model,'file_is_forSale'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_params'); ?>
		<?php echo $form->textArea($model,'file_params',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shared'); ?>
		<?php echo $form->textField($model,'shared'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_on'); ?>
		<?php echo $form->textField($model,'created_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->