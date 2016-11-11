<?php
/* @var $this ProductcommentsController */
/* @var $model ProductComments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php //$form=$this->beginWidget('CActiveForm', array(
	$form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'product-comments-form',
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
            <?php echo $form->labelEx($model,'product_id'); ?>
            <?php echo $form->textField($model,'product_id',array('size'=>11,'maxlength'=>11)); ?>
            <?php echo $form->error($model,'product_id'); ?>
        </div>
	</div>

	<div class="row">
        <div class="col-lg-6">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name',array('size'=>11,'maxlength'=>64)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="col-lg-6">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email',array('size'=>11,'maxlength'=>256)); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>
	</div>

	<div class="row">
        <div class="col-lg-12">
            <?php echo $form->labelEx($model,'comment'); ?>
            <?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50,'maxlength'=>2048)); ?>
            <?php echo $form->error($model,'comment'); ?>
	    </div>
	</div>

	<div class="row">
        <div class="col-lg-12">
            <?php echo $form->labelEx($model,'answer'); ?>
			<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
				'model'=>$model,
				'attribute'=>'answer',
				'language'=>'ru',
				'editorTemplate'=>'full',
				'height'=>'200px'
			)); ?>
			<?php echo $form->error($model,'answer'); ?>
	    </div>
	</div>

	<div class="buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'apply')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->