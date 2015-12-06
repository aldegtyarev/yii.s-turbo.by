<?php
/* @var $this PagesController */
/* @var $model Pages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php //$form=$this->beginWidget('CActiveForm', array(
$form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'pages-form',
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
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php //echo $form->dropDownList($model, 'type', Yii::app()->params->pages_rubriks); ?>
		<?php echo $form->dropDownList($model, 'type', $model->categoriesDropDownList); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
	
	<?php if($model->foto != '')	{	?>
		<img src="<?= Yii::app()->params->pages_images_liveUrl . 'full_'.$model->foto ?>" alt="">
		<p><a href="<?= $this->createUrl('pages/removefoto', array('id'=>$model->id))?>">Удалить фото</a></p>
	<?php	}	?>
	<fieldset>
		<legend>Добавить фото</legend>
		<input type="checkbox" value="1" name="no_watermark" id="no_watermark" /> <label for="no_watermark">Без водяного знака</label>
		<?php echo BsHtml::activeFileField($model, 'uploading_foto'); ?>			
	</fieldset>
	

	<div class="row">
		<?php echo $form->labelEx($model,'intro'); ?>
		<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
			  'model'=>$model,
			  'attribute'=>'intro',
			  'language'=>'ru',
			  'editorTemplate'=>'full',
			  'height'=>'200px'
		)); ?>	
		<?php echo $form->error($model,'intro'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
			  'model'=>$model,
			  'attribute'=>'text',
			  'language'=>'ru',
			  'editorTemplate'=>'full',
			  'height'=>'600px'
		)); ?>	
		<?php echo $form->error($model,'text'); ?>
	</div>
	

	<div class="row">
		<?php echo $form->labelEx($model,'metatitle'); ?>
		<?php echo $form->textField($model,'metatitle',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'metatitle'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metakey'); ?>
		<?php echo $form->textField($model,'metakey',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'metakey'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'metadesc'); ?>
		<?php echo $form->textArea($model,'metadesc',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'metadesc'); ?>		
	</div>
	

	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'name'=>'save')); ?>
		<?php echo BsHtml::submitButton('Применить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'apply')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->