<?
$this->breadcrumbs = array(
	'Корзина'=>array('cart/showcart'),
	'Оформление заказа'
);

$clientScript = $app->clientScript;

$this->pageTitle = "Оформление заказа | ".$app->name;
$clientScript->registerMetaTag("Оформление заказа,".$app->name, 'keywords');
$clientScript->registerMetaTag("Оформление заказа на ".$app->name, 'description');

switch($checkoutType) {
	case 'checkout-fiz':
		$style_fiz = 'style="display:block"';
		$style_ur = 'style="display:none"';
		break;

	case 'checkout-ur':
		$style_fiz = 'style="display:none"';
		$style_ur = 'style="display:block"';
		break;

}

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
		
		<?php echo CHtml::radioButtonList('checkoutType', $checkoutType, array('checkout-fiz'=>'Физическое лицо','checkout-ur'=>'Юридическое лицо'),array('separator'=>' ')); ?>
		
		<br>
		<br>
		<br>
		<? $this->renderPartial('_checkout-fiz', array('model'=>$modelFiz, 'form'=>$form, 'style_fiz'=>$style_fiz)) ?>
		
		<? $this->renderPartial('_checkout-ur', array('model'=>$modelUr, 'form'=>$form, 'style_ur'=>$style_ur)) ?>
			


			<div class="row checkout-btns">
				<? echo CHtml::link('Вернуться к товарам', '/showcart.html', array('title' => 'Продолжать покупки', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-continue')); ?>
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