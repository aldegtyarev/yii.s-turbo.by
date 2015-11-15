<div class="contact-form-cnt">
<h4>Форма обратной связи</h4>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row pos-rel">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		
			<?php $this->widget('CCaptcha', array('clickableImage' => true, /*'showRefreshButton'=>false,*/ 'buttonLabel' => '+', 'buttonType' => 'button', 'id' => 'reload_captcha')); ?>
			<?php echo $form->textField($model,'verifyCode'); ?>
		
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить', array('class'=>'button-red')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
