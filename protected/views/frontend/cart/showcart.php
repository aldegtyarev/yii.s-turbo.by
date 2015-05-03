<?
$this->breadcrumbs = array(
	'Корзина'
);

$clientScript = $app->clientScript;


$this->pageTitle = "Корзина | ".$app->name;
$clientScript->registerMetaTag("Корзина,".$app->name, 'keywords');
$clientScript->registerMetaTag("Корзина на ".$app->name, 'description');

?>
<div class="cart-view item-page">
	
	<h1>Корзина</h1>

	<? if(count($positions) != 0)	{	?>
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
		
	<div id="cart-list" class="cart-list pos-rel bg-fff clearfix">
		<? $this->renderPartial('_cart-list', array('app'=>$app, 'params'=>$params, 'positions'=>$positions)) ?>
	</div>
		
    		
	<? } else {?>
		<div class="cart-list bg-fff p-30">
			<div class="cart-empty">Ваша корзина пуста</div>
		</div>
	<? }?>

</div>