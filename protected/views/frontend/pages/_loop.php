<?php

$pagination_url = $app->getRequest()->getRequestUri();
	
?>

<div id="listView">

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'ajaxUpdate'=>false,
	'template'=>"{items}\n{pager}",
	'pager'=>array(
		'htmlOptions'=>array(
			'class'=>'paginator'
		)
	),	
	'itemsCssClass' => 'products-list pages-list clearfix',
	'viewData'=>array(
		'url_path'=>$url_path,
	),	
	
)); ?>

</div>

<?php include("_ajax-pagination.php")?>