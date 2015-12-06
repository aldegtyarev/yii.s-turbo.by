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
	),
)); ?>


</div>


<?php if ($dataProvider->totalItemCount > $dataProvider->pagination->pageSize)	{	?>
 
    <? /*<p id="loading" style="display:none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="" /></p> */ ?>
    <p id="loading" class="more-products button" style="display:none">Загрузка...</p>
	<a href="#" id="showMore" class="more-products button">Показать еще</a>
	
	<?
	$app->clientScript->registerScript('bids-index', "
// скрываем стандартный навигатор
$('.pager').hide();

// запоминаем текущую страницу и их максимальное количество
var page = parseInt('".(int)$app->request->getParam('page', 1)."');
var pageCount = parseInt('".(int)$dataProvider->pagination->pageCount."');

var loadingFlag = false;

$('#showMore').click(function()
{
	// защита от повторных нажатий
	if (!loadingFlag)
	{
		// выставляем блокировку
		loadingFlag = true;

		// отображаем анимацию загрузки
		$('#loading').show();
		$('#showMore').hide();

		$.ajax({
			type: 'post',
			url: window.location.href,
			data: {
				// передаём номер нужной страницы методом POST
				'page': page + 1,
				'".$app->request->csrfTokenName."': '".$app->request->csrfToken."'
			},
			success: function(data)
			{
				// увеличиваем номер текущей страницы и снимаем блокировку
				page++;                            
				loadingFlag = false;                            

				// прячем анимацию загрузки
				$('#loading').hide();
				$('#showMore').show();

				// вставляем полученные записи после имеющихся в наш блок
				$('#listView').append(data);

				// если достигли максимальной страницы, то прячем кнопку
				if (page >= pageCount)
					$('#showMore').hide();
			}
		});
	}
	return false;
})
");

?>
 
<?php	}	?>