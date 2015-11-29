<div id="checkout-fiz" class="checkout-cnt checkout-cnt-fiz " <?= $style_fiz ?> >
<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fio', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'fio',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'fio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'town', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'town',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'town'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'address',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone1', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'phone1',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox phone-input')); ?>
		<?php echo $form->error($model,'phone1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone2', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'phone2',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'phone2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'email',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'email'); ?>
		<p class="small">На него будет выслана информация о заказе</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>46, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>
	
	<div class="row info_text">
		Удобный способ оплаты и доставки с Вами обсудит наш менеджер по телефону
	</div>
	

</div>