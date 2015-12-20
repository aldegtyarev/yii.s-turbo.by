<div id="checkout-ur" class="checkout-cnt checkout-cnt-ur" <?= $style_ur ?> >

	<h3>Данные организации</h3>

	<div class="row">
		<?php echo $form->labelEx($model,'name_ur', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'name_ur',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'name_ur'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address_ur', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'address_ur',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'address_ur'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unp', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'unp',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'unp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'okpo', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'okpo',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'okpo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'r_schet', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'r_schet',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'r_schet'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bank_name', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'bank_name',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'bank_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bank_address', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'bank_address',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'bank_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bank_code', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'bank_code',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'bank_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fio_director', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'fio_director',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'fio_director'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'na_osnovanii', array('class'=>'bold nowrap')); ?>
		<?php echo $form->radioButtonList($model,'na_osnovanii', $model->getNaOsnovaniiRadioList(), array('template'=>'<span>{input} {label}</span>', 'separator'=>' ', 'class'=>'na_osnovanii_radio')); ?>
		<?php echo $form->error($model,'na_osnovanii'); ?>
	</div>
	
	<div id="doverennost_text_cnt" class="row na_osnovanii_textbox" <?php if($model->na_osnovanii != 2) echo 'style="display:none;"' ?> >
		<?php echo $form->textArea($model,'doverennost_text', array('rows'=>1, 'cols'=>45, 'placeholder'=>$model->getAttributeLabel('doverennost_text'), 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'doverennost_text'); ?>
	</div>
	
	<div id="svidetelstvo_text_cnt" class="row na_osnovanii_textbox" <?php if($model->na_osnovanii != 3) echo 'style="display:none;"' ?> >
		<?php echo $form->textArea($model,'svidetelstvo_text', array('rows'=>1, 'cols'=>45, 'placeholder'=>$model->getAttributeLabel('svidetelstvo_text'), 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'svidetelstvo_text'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'phone1_ur', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'phone1_ur',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox phone-input')); ?>
		<?php echo $form->error($model,'phone1_ur'); ?>
	</div>

	<br>
	
	<h3>Контактное лицо</h3>
	
	<div class="row">
		<?php echo $form->labelEx($model,'fio', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textField($model,'fio',array('size'=>24,'maxlength'=>255, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'fio'); ?>
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
		<p class="small">Для получения счет-фактуры</p>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'comment', array('class'=>'bold nowrap')); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>26, 'class'=>'inputbox')); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>
	
	<div class="row info_text">
		Удобный способ оплаты и доставки с Вами обсудит наш менеджер по телефону
	</div>
	

</div>