<?php

$this->breadcrumbs=array(
	'Последние просмотренные товары',
);


$app = Yii::app();

//$clientScript = $app->clientScript;
//$clientScript->registerCssFile('/css/shop.css', 'screen');
//echo'<pre>';print_r(count($descendants));echo'</pre>';
//echo'<pre>';print_r($descendants);echo'</pre>';
//echo'<pre>';print_r($firm_request);echo'</pre>';

//$products = $products_and_pages['rows'];
//$pagination = $products_and_pages['pages'];
?>

<h1>Последние просмотренные товары</h1>

<?php	if (count($dataProvider->data)) {	?>
	<div class="category-products-list">		
		<div id="listView">
			<?php $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'_view',
				'ajaxUpdate'=>false,
				'template'=>"{items}",
				'itemsCssClass' => 'products-list clearfix',
			)); ?>
		</div>
	</div>		
<?php	}	?>
