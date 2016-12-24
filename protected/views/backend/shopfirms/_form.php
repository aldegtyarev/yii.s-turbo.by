<?php
/* @var $this ShopFirmsController */
/* @var $model ShopFirms */
/* @var $form CActiveForm */
?>

<div class="form">

<?php //$form=$this->beginWidget('CActiveForm', array(
$form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'shop-firms-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' =>	array(
        'enctype'=>'multipart/form-data',
    ),
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'firm_name'); ?>
		<?php echo $form->textField($model,'firm_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'firm_name'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'category_id'); ?>
        <?php echo $form->dropDownList($model, 'category_id', $model->categoriesList, array('options' => $model->category_id)); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'alias'); ?>
                <?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'alias'); ?>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'url'); ?>
                <?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>1024)); ?>
                <?php echo $form->error($model,'url'); ?>
            </div>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'firm_description'); ?>
		<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
			  'model'=>$model,
			  'attribute'=>'firm_description',
			  'language'=>'ru',
			  'editorTemplate'=>'full',
			  'height'=>'200px'
		)); ?>	
		<?php echo $form->error($model,'firm_description'); ?>
	</div>
	

	<div class="form-group">
        <?php if($model->firm_logo != '')	{	?>
            <img src="<?= Yii::app()->params->brands_images_liveUrl . 'full_'.$model->firm_logo ?>" alt="">
            <p><a href="<?= $this->createUrl('removefoto', array('id'=>$model->firm_id))?>">Удалить фото</a></p>
        <?php	}	?>
        <fieldset>
            <legend>Добавить фото</legend>
            <input type="checkbox" value="1" name="no_watermark" id="no_watermark" /> <label for="no_watermark">Без водяного знака</label>
            <?php echo BsHtml::activeFileField($model, 'uploading_foto'); ?>
        </fieldset>
    </div>

	<div class="form-group buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'apply')); ?>
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать и закрыть' : 'Сохранить и закрыть', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->