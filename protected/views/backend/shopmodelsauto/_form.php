<?php
/* @var $this ShopModelsAutoController */
/* @var $model ShopModelsAuto */
/* @var $form CActiveForm */

$cs = Yii::app()->clientScript;

$cs->registerCssFile('/css/chosen.css', 'screen');
$cs->registerScriptFile('/js/chosen.jquery.min.js', CClientScript::POS_END);
$cs->registerScript('shop-models-auto-form', "
	$('.chosen_select').chosen();
");

?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'shop-models-auto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
	
    <ul class="nav nav-tabs" id="myTab">
		<li class="active"><a href="#tab1" data-toggle="tab">Основное</a></li>
		<li><a href="#tab2" data-toggle="tab">Meta</a></li>
    </ul>

	<div class="tab-content">
		
		<div class="tab-pane active" id="tab1">
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
			
            <div class="row chosen-row">
                <?php echo $form->labelEx($model,'body_ids'); ?>
                <?php echo $form->dropDownList($model, 'body_ids', $model->DropDownlistBodies, array('multiple' => true, 'class'=>'chosen_select', 'data-placeholder'=>'выберите категорию', 'style'=>'width:400px;', 'options' => $model->selectedBodies));?>
                <?php echo $form->error($model,'body_ids'); ?>
            </div>
			
<?
/*
			<div class="row">
				<?php echo $form->labelEx($model,'alias'); ?>
				<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'alias'); ?>
			</div>
*/
?>
			<?/*
			<div class="row">
				<?php echo $form->labelEx($model,'category_description'); ?>
				<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
					  'model'=>$model,
					  'attribute'=>'category_description',
					  'language'=>'ru',
					  'editorTemplate'=>'full',
					  'height'=>'200px'
				)); ?>	
				<?php echo $form->error($model,'category_description'); ?>
			</div>
			*/?>
		</div>
		
		<div class="tab-pane" id="tab2">
			<div class="row">
				<?php echo $form->labelEx($model,'title'); ?>
				<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'title'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'keywords'); ?>
				<?php echo $form->textArea($model,'keywords',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'keywords'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'description'); ?>
				<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'description'); ?>
			</div>
		</div>
	</div>
	
	

	
	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->