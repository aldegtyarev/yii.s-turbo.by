<p class="bold mb-15 pl-5">Страница <?= $page_num ?></p>
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
		'deliveries_list' => $deliveries_list,
		'modelinfoTxt' => $model_info_name,
		'app'=>$app,
        'arQuestionsCount'=>$arQuestionsCount,
    ),
	
)); ?>