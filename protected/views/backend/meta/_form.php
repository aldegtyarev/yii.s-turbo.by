<?php
/* @var $this MetaController */
/* @var $model Meta */
/* @var $form CActiveForm */


//echo'<pre>';print_r($model->attributes);echo'</pre>';die;
$cs = Yii::app()->clientScript;

$cs->registerScript('loading', "
	$('#Meta_published').bootstrapSwitch();
");


?>

<div class="form">

	<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'meta-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->checkBoxControlGroup($model, 'published'); ?>
			<?php echo $form->error($model,'published'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'cntr_act'); ?>
			<?php echo $form->textField($model,'cntr_act',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'cntr_act'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'category_id'); ?>
			<?php echo $form->dropDownList($model, 'category_id', ShopCategories::model()->getDropDownlistItems()); ?>
			<?php echo $form->error($model,'category_id'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'model_id'); ?>
			<?php echo $form->dropDownList($model, 'model_id', array(0=>'Не указана') + ShopModelsAuto::model()->getDropDownlistItems()); ?>
			<?php echo $form->error($model,'model_id'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'type_id'); ?>
			<?php echo $form->dropDownList($model, 'type_id', ShopProductTypes::model()->getDropDownlistItems()); ?>
			<?php echo $form->error($model,'type_id'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'metatitle'); ?>
			<?php echo $form->textField($model,'metatitle',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'metatitle'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'metadesc'); ?>
			<?php echo $form->textArea($model,'metadesc'); ?>
			<?php echo $form->error($model,'metadesc'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'metakey'); ?>
			<?php echo $form->textField($model,'metakey',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'metakey'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'descr'); ?>
			<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
				'model'=>$model,
				'attribute'=>'descr',
				'language'=>'ru',
				'editorTemplate'=>'full',
				'height'=>'400px',
			)); ?>

			<?php echo $form->error($model,'descr'); ?>
		</div>
	</div>

	<div class="form-group buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать и выйти' : 'Сохранить и выйти', array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'name'=>'task', 'value'=>'save')); ?>
		<?php echo BsHtml::submitButton('Применить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'task', 'value'=>'apply')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->