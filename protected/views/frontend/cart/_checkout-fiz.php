<?
if($delivery_id == 2) $stylePostCode = 'display: block;';
    else $stylePostCode = 'display: none;';
?>
<div id="checkout-fiz" class="checkout-cnt checkout-cnt-fiz " <?= $style_fiz ?> >
	<?
	if(isset($model->errors['positions'])) {
		if(isset($model->errors['positions'][0])) {
			echo '<p style="color: red; font-weight: bold">'.$model->errors['positions'][0].'</p>';
		}
	}
	?>



	<??>
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

	<div class="row  js-row__post-code" style="<?= $stylePostCode?>">
		<?php echo $form->labelEx($model,'post_code', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'post_code',array('size'=>24,'maxlength'=>6, 'class'=>'inputbox post-code')); ?>
		<?php echo $form->error($model,'post_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address1', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'address1',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'address1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address2', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'address2',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'address2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address3', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'address3',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'address3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone1', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'phone1',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox phone-input')); ?>
		<?php echo $form->error($model,'phone1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone2', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'phone2',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox phone-input')); ?>
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
	
	<?/*
	<div class="row info_text">
		Удобный способ <a href="<?= $this->createUrl('pages/payment')?>" class="advantages-item-detail modal-url fancybox1 fancybox.ajax" title="Удобная оплата">оплаты</a> и <a href="<?= $this->createUrl('pages/delivery')?>" class="modal-url fancybox1 fancybox.ajax" title="Доставка по всей Беларуси">доставки</a>   с Вами обсудит наш менеджер по телефону
	</div>
	*/?>
	

</div>