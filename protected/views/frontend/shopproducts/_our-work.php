<?php

$pagination_url = $this->createUrl('pages/our');
	
?>
<div id="listView" class="productdetails-our">

<div class="h1">Наши работы</div>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=> '../pages/_view',
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



<?php include(dirname(dirname(__FILE__))."/pages/_ajax-pagination.php")?>