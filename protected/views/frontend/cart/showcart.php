<?
$this->breadcrumbs = array(
	'Корзина'
);

$clientScript = $app->clientScript;

$this->pageTitle = "Корзина | ".$app->name;
$clientScript->registerMetaTag("Корзина,".$app->name, 'keywords');
$clientScript->registerMetaTag("Корзина на ".$app->name, 'description');

$cs = $app->getClientScript();
$cs->coreScriptPosition = CClientScript::POS_END;
$cs->registerCoreScript('cart');


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
<div class="cart-view item-page mb-40">
	
	<h1>Корзина</h1>
	
	<? if(count($positions) != 0)	{	?>	
		<div id="cart-list" class="cart-list pos-rel bg-fff clearfix pt-20">
			<? $this->renderPartial('_cart-list', array('app'=>$app, 'params'=>$params, 'positions'=>$positions, 'currency_info' => $currency_info)) ?>
		</div>
	<? } else {?>
		<div class="cart-list bg-fff p-30">
			<div class="cart-empty">Ваша корзина пуста</div>
		</div>
	<? }?>
	
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'checkout-form',
	'enableAjaxValidation'=>false,
)); ?>


<? if(count($positions) != 0)	{	?>

	<? $this->renderPartial('_delivery', array('rows'=>$delivery_list, 'form'=>$form, 'currency_info' => $currency_info, 'delivery_id' => $delivery_id, 'delivery_quick' => $delivery_quick)) ?>
	
	<? $this->renderPartial('_payment', array('rows'=>$payment_list, 'form'=>$form, 'currency_info' => $currency_info, 'payment_id' => $payment_id, 'delivery_id' => $delivery_id)) ?>

	<div class="cart-view item-page">
		<div id="cart-checkout-list" class="cart-list pos-rel bg-fff clearfix p-20">

			<h3 class="c_d70000">Контактные данные</h3>

				<?php echo CHtml::radioButtonList('checkoutType', $checkoutType, array('checkout-fiz'=>'Физическое лицо','checkout-ur'=>'Юридическое лицо'),array('separator'=>' ')); ?>

				<br>
				<br>
				<br>
				
				<? $this->renderPartial('_checkout-fiz', array('model'=>$modelFiz, 'form'=>$form, 'style_fiz'=>$style_fiz)) ?>

				<? $this->renderPartial('_checkout-ur', array('model'=>$modelUr, 'form'=>$form, 'style_ur'=>$style_ur)) ?>
				
				<div class="row checkout-btns">
					<? echo CHtml::link('Вернуться к товарам', $this->createUrl('shopcategories/index'), array('title' => 'Продолжать покупки', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-continue')); ?>
					<? echo CHtml::submitButton('Отправить заказ', array('title' => 'Оформить заказ', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-checkout pointer')); ?>			
					<? //echo CHtml::link('Оформить', $this->createUrl('/cart/checkout'), array('title' => 'Оформить заказ', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-checkout')); ?>
				</div>			


		</div>
	</div>
<?php	}	?>

<?php $this->endWidget(); ?>


