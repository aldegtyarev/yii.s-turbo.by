<?php
/* @var $this CategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
?>

<div class="form">

<?php //$form=$this->beginWidget('CActiveForm', array(
 $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'categories-form',
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

    <ul class="nav nav-tabs" id="myTab">
		<li><a href="#tab1" data-toggle="tab">Основное</a></li>
		<li><a href="#tab2" data-toggle="tab">Meta</a></li>
    </ul>
	<div class="tab-content">
	
		<div class="tab-pane active" id="tab1">
			<div class="row">
				<div class="col-lg-12">
					<?php echo $form->labelEx($model,'dropDownListTree'); ?>
					<?php echo $form->dropDownList($model, 'parentId', $model->DropDownlistData); ?>
					<?php echo $form->error($model,'dropDownListTree'); ?>		
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<?php echo $form->labelEx($model,'name'); ?>
					<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
					<?php echo $form->error($model,'name'); ?>
				</div>
				
				<div class="col-lg-6">
					<?php echo $form->labelEx($model,'name1'); ?>
					<?php echo $form->textField($model,'name1',array('size'=>60,'maxlength'=>255)); ?>
					<?php echo $form->error($model,'name1'); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6">
					<?php echo $form->labelEx($model,'currency_id'); ?>
					<?php echo $form->dropDownList($model, 'currency_id', Currencies::model()->dropDownCurrenciesList, array('options' => $model->currency_id));?>
					<?php echo $form->error($model,'currency_id'); ?>					
				</div>
			</div>
			
			<?php if($model->foto != '')	{	?>
				<img src="<?= Yii::app()->params->category_images_liveUrl . 'thumb_'.$model->foto ?>" alt="">
				<p><a href="<?= $this->createUrl('removefoto', array('id'=>$model->id))?>">Удалить фото</a></p>
			<?php	}	?>
			<fieldset>
				<legend>Добавить фото</legend>
				<input type="checkbox" value="1" name="no_watermark" id="no_watermark" /> <label for="no_watermark">Без водяного знака</label>
				<?php echo BsHtml::activeFileField($model, 'uploading_foto'); ?>			
			</fieldset>
			
			
<?
/*
			<div class="row">
				<?php echo $form->labelEx($model,'alias'); ?>
				<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'alias'); ?>
			</div>
*/
?>
			
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
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'name'=>'save')); ?>
		<?php echo BsHtml::submitButton('Применить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'apply')); ?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->