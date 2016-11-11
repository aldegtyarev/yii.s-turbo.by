<div id="listView">

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>$itemView,
	'ajaxUpdate'=>false,
	'template'=>"{items}\n{pager}",
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


</div>


<?php if ($dataProvider->totalItemCount > $dataProvider->pagination->pageSize)	{	?>
 
    <? /*<p id="loading" style="display:none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="" /></p> */ ?>
    <p id="loading" class="more-products button" style="display:none">Загрузка...</p>
	<a href="#" id="showMore" class="more-products button">Показать еще</a>
	
	<input type="hidden" id="page_input" value="<?= (int)$app->request->getParam('page', 1) ?>">
	<input type="hidden" id="pageCount_input" value="<?= (int)$dataProvider->pagination->pageCount ?>">
	<input type="hidden" id="csrfTokenName" value="<?= $app->request->csrfTokenName ?>">
	<input type="hidden" id="csrfToken" value="<?= $app->request->csrfToken ?>"> 
	<input type="hidden" id="pagination-url" value="<?= $app->getRequest()->getRequestUri() ?>"> 
<?php	}	?>