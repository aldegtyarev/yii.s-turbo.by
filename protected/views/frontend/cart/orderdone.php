<?
$this->breadcrumbs = array(
	'Заказ завершен'
);

$clientScript = $app->clientScript;


$this->pageTitle = "Заказ завершен | ".$app->name;
$clientScript->registerMetaTag("Заказ завершен,".$app->name, 'keywords');
$clientScript->registerMetaTag("Заказ завершен на ".$app->name, 'description');

?>
<div class="cart-view item-page">
	
	<h1>Заказ завершен</h1>

	<div class="cart-list bg-fff p-30">
		<div class="cart-empty">Заказ завершен</div>
	</div>


</div>