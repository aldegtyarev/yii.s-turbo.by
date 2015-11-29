<?
$this->breadcrumbs = array(
	'Корзина'
);

$clientScript = $app->clientScript;


$this->pageTitle = "Корзина | ".$app->name;
$clientScript->registerMetaTag("Корзина,".$app->name, 'keywords');
$clientScript->registerMetaTag("Корзина на ".$app->name, 'description');

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
		<?/*
		<ul class="cart-steps clearfix">
			<li class="cart-step cart-step-active fLeft pt-10 pb-15 pl-10 pr-20">
				<span class="cart-step-num cart-step-num-active">1</span>
				<span class="c-777">Информация</span>
			</li>
			<li class="cart-step fLeft pt-10 pb-15 pl-10 pr-20">
				<span class="cart-step-num">2</span>
				<span class="c-777">Контактные данные</span>
			</li>
		</ul>
		*/?>
		
	
		
	<div id="cart-list" class="cart-list pos-rel bg-fff clearfix pt-20">
		<? $this->renderPartial('_cart-list', array('app'=>$app, 'params'=>$params, 'positions'=>$positions)) ?>
	</div>
	
	
		
    		
	<? } else {?>
		<div class="cart-list bg-fff p-30">
			<div class="cart-empty">Ваша корзина пуста</div>
		</div>
	<? }?>

</div>


<? if(count($positions) != 0)	{	?>
	<div class="cart-view item-page">
		<div id="cart-checkout-list" class="cart-list pos-rel bg-fff clearfix p-20">

			<h3 class="c_d70000">Оформить заказ</h3>

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
					<? echo CHtml::link('Вернуться к товарам', $this->createUrl('shopcategories/index'), array('title' => 'Продолжать покупки', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-continue')); ?>
					<? echo CHtml::submitButton('Оформить заказ', array('title' => 'Оформить заказ', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-checkout pointer')); ?>			
					<? //echo CHtml::link('Оформить', $this->createUrl('/cart/checkout'), array('title' => 'Оформить заказ', 'class'=>'db fLeft c_fff bold cart-btn cart-btn-checkout')); ?>
				</div>			

			<?php $this->endWidget(); ?>
		</div>
	</div>
<?php	}	?>