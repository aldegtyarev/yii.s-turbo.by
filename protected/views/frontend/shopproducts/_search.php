<?php
/* @var $this ShopProductsController */
/* @var $model ShopProducts */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_s_desc'); ?>
		<?php echo $form->textField($model,'product_s_desc',array('size'=>60,'maxlength'=>2000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_desc'); ?>
		<?php echo $form->textField($model,'product_desc',array('size'=>60,'maxlength'=>18500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_name'); ?>
		<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>180)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_name_manual'); ?>
		<?php echo $form->textArea($model,'product_name_manual',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_sku'); ?>
		<?php echo $form->textField($model,'product_sku',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'metadesc'); ?>
		<?php echo $form->textField($model,'metadesc',array('size'=>60,'maxlength'=>192)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'metakey'); ?>
		<?php echo $form->textField($model,'metakey',array('size'=>60,'maxlength'=>192)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customtitle'); ?>
		<?php echo $form->textField($model,'customtitle',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('size'=>60,'maxlength'=>192)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_video'); ?>
		<?php echo $form->textField($model,'product_video',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_charact'); ?>
		<?php echo $form->textArea($model,'product_charact',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_brand_id'); ?>
		<?php echo $form->textField($model,'product_brand_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_type_id'); ?>
		<?php echo $form->textField($model,'product_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'for_dogs'); ?>
		<?php echo $form->textField($model,'for_dogs'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'protect_copy'); ?>
		<?php echo $form->textField($model,'protect_copy'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_in_stock'); ?>
		<?php echo $form->textField($model,'product_in_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_ordered'); ?>
		<?php echo $form->textField($model,'product_ordered'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->