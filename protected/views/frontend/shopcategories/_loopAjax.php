<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>$itemView,
	'ajaxUpdate'=>false,
	'template'=>"{items}",
	'pager'=>array(
		'htmlOptions'=>array(
			'class'=>'paginator'
		)
	),	
	'itemsCssClass' => 'products-list clearfix',
	'viewData'=>array(
		'currency_info' => $currency_info,
	),
	
)); ?>