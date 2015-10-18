<?php
/* @var $this EnginesController */
/* @var $model Engines */
/* @var $form CActiveForm */
$cs = Yii::app()->clientScript;

//$cs->registerCssFile('/css/chosen.css', 'screen');
//$cs->registerScriptFile('/js/chosen.jquery.min.js', CClientScript::POS_END);

$cs->registerScript('loading', "
	var options = {
		onText: 'Да',
		offText: 'Нет',
	};
	$('#Engines_engine').bootstrapSwitch(options);
");

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
		<?php echo $form->checkBoxControlGroup($model, 'engine'); ?>
		<?php echo $form->error($model,'engine'); ?>
	</div>
	

	<div class="row">
		<?php echo $form->labelEx($model,'image_title'); ?>
		<?php echo $form->textField($model,'image_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'image_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fileImage'); ?>
		<?php echo $form->fileField($model, 'fileImage'); ?>				
		<?php echo $form->error($model,'fileImage'); ?>
	</div>
	
	<?php if($model->image_file != '')	{	?>
		<div class="row">
			<?php echo CHtml::image(Yii::app()->params->product_images_liveUrl.$model->image_file, '', array('class'=>'img-responsive')) ?>
			<p><a href="<?= $this->createUrl('engines/removeimg', array('id'=>$model->id)) ?>">Удалить изображение</a></p>
		</div>
	
	<?php	}	?>
	
	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'name'=>'save')); ?>
		<?php echo BsHtml::submitButton('Применить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'apply')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->