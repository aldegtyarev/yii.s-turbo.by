<div class="contact-form-cnt backcall-form-cnt">
<h3>Заказ обратного звонка</h3>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<div class="form back-call-frm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'backcall-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php //echo $form->errorSummary($model); ?>
	
	<p class="backcall-form-descr">Оставьте номер Вашего телефона и наш оператор перезвонит Вам.</p>

	<div class="row">
		<?php echo $form->textField($model, 'name', array('placeholder'=>$model->getAttributeLabel('name'))); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->textField($model,'phone', array('placeholder'=>$model->getAttributeLabel('phone'), 'class'=>'phone-input')); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->textField($model,'time', array('placeholder'=>$model->getAttributeLabel('time'), 'class'=>'time-to-call-input')); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row buttons">
		<?php 
		echo CHtml::submitButton('Жду звонка', array('name'=>'send-backcall', 'id'=>'send-backcall', 'class'=>'button-red send-backcall', 'onclick'=>'sendBackCall(this);return false;')); 
		/*
			echo CHtml::ajaxSubmitButton('Обработать', '', 
				array(
					'type' => 'POST',
					// Результат запроса записываем в элемент, найденный
					// по CSS-селектору #output.
					'update' => '#backcall-cnt',
				),
				array(
					// Меняем тип элемента на submit, чтобы у пользователей
					// с отключенным JavaScript всё было хорошо.
					'type' => 'submit'
					
				)
			);
			*/
		
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
</div>