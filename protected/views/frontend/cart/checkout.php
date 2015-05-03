<?
$this->breadcrumbs = array(
	'Корзина'=>array('cart/showcart'),
	'Оформление заказа'
);

$clientScript = $app->clientScript;


$this->pageTitle = "Оформление заказа | ".$app->name;
$clientScript->registerMetaTag("Оформление заказа,".$app->name, 'keywords');
$clientScript->registerMetaTag("Оформление заказа на ".$app->name, 'description');

?>
<div class="cart-view item-page">
	
	<h1>Оформление заказа</h1>

	<? if(count($positions) != 0)	{	?>
		<ul class="cart-steps clearfix">
			<li class="cart-step fLeft pt-10 pb-15 pl-10 pr-20">
				<span class="cart-step-num">1</span>
				<span class="c-777">Информация</span>
			</li>
			<li class="cart-step cart-step-active fLeft pt-10 pb-15 pl-10 pr-20">
				<span class="cart-step-num cart-step-num-active">2</span>
				<span class="c-777">Контактные данные</span>
			</li>
		</ul>
		
	<div id="cart-list" class="cart-list pos-rel bg-fff clearfix p-20">
	
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'checkout-form',
			'enableAjaxValidation'=>false,
		)); ?>
			
			<p class="font-20 bold mb-30">Контактные данные <span class="c-777 italic font-14">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения </span></p>

			<?php //echo $form->errorSummary($model); ?>

			<div class="row1 border-box clearfix">
				<div class="width50 fLeft border-box pr-10 pl-10">
					<div class="p-10">
						<div class="row dtr">
							<div class="dtc pb-10 pr-10"><?php echo $form->labelEx($model,'region', array('class'=>'bold nowrap')); ?></div>
							<div class="dtc pb-10">
								<?php echo $form->textField($model,'region',array('size'=>24,'maxlength'=>255)); ?>
								<?php echo $form->error($model,'region'); ?>
							</div>
						</div>
						<div class="row dtr">
							<div class="dtc pb-10 pr-10"><?php echo $form->labelEx($model,'town', array('class'=>'bold nowrap')); ?></div>
							<div class="dtc pb-10">
								<?php echo $form->textField($model,'town',array('size'=>24,'maxlength'=>255)); ?>
								<?php echo $form->error($model,'town'); ?>
							</div>
						</div>
						<div class="row dtr">
							<div class="dtc pb-10 pr-10"><?php echo $form->labelEx($model,'post_index', array('class'=>'bold nowrap')); ?></div>
							<div class="dtc pb-10">
								<?php echo $form->textField($model,'post_index',array('size'=>24,'maxlength'=>255)); ?>
								<?php echo $form->error($model,'post_index'); ?>
							</div>
						</div>
						<div class="row dtr">
							<div class="dtc pb-10 pr-10"><?php echo $form->labelEx($model,'address', array('class'=>'bold nowrap')); ?></div>
							<div class="dtc pb-10">
								<?php echo $form->textField($model,'address',array('size'=>24,'maxlength'=>255)); ?>
								<?php echo $form->error($model,'address'); ?>
							</div>
						</div>
						<div class="row dtr">
							<div class="dtc pb-10 pr-10"><?php echo $form->labelEx($model,'fio', array('class'=>'bold nowrap')); ?></div>
							<div class="dtc pb-10">
								<?php echo $form->textField($model,'fio',array('size'=>24,'maxlength'=>255)); ?>
								<?php echo $form->error($model,'fio'); ?>
								<br><br><span class="font-12 c-777"><span class="c_d70000">ВНИМАНИЕ!</span> Полностью и правильно указывайте ФАМИЛИЮ, ИМЯ и ОТЧЕСТВО получателя заказа, поскольку выдача почтовых или курьерских отправлений может производиться только после предъявления документов, удостоверяющих личность.</span>
							</div>
						</div>
					</div>

				</div>

				<div class="width50 fLeft border-box pr-10 pl-10">
					<div class="p-10">
					
						<div class="row dtr">
							<div class="dtc pb-10 pr-10"><?php echo $form->labelEx($model,'phone', array('class'=>'bold nowrap')); ?></div>
							<div class="dtc pb-10">
								<?php echo $form->textField($model,'phone',array('size'=>24,'maxlength'=>255)); ?>
								<?php echo $form->error($model,'phone'); ?>
								<br><br><span class="font-12 c-777">Телефон для оперативной связ с Вами, для подтверждения заказа.</span>
							</div>
						</div>
					
						<div class="row dtr">
							<div class="dtc pb-10 pr-10"><?php echo $form->labelEx($model,'email', array('class'=>'bold nowrap')); ?></div>
							<div class="dtc pb-10">
								<?php echo $form->textField($model,'email',array('size'=>24,'maxlength'=>255)); ?>
								<?php echo $form->error($model,'email'); ?>
								<br><br><span class="font-12 c-777">На него будут высланы уведомления о состоянии заказа и счет на оплату.</span>
							</div>
						</div>
					
						<div class="row dtr">
							<div class="dtc pb-10 pr-10 v-middle"><?php echo $form->labelEx($model,'comment', array('class'=>'bold')); ?></div>
							<div class="dtc pb-10">
								<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>26)); ?>
								<?php echo $form->error($model,'comment'); ?>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="row">
				<? echo CHtml::link('Продолжать покупки', '/', array('title' => 'Продолжать покупки', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-continue')); ?>
				<? echo CHtml::submitButton('Оформить', array('title' => 'Оформить заказ', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-checkout pointer')); ?>			
				<? //echo CHtml::link('Оформить', $this->createUrl('/cart/checkout'), array('title' => 'Оформить заказ', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-checkout')); ?>
			</div>			

		<?php $this->endWidget(); ?>
	</div>
		
    		
	<? } else {?>
		<div class="cart-list bg-fff p-30">
			<div class="cart-empty">Ваша корзина пуста</div>
		</div>
	<? }?>

</div>