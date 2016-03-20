<?php if ($dataProvider->totalItemCount > $dataProvider->pagination->pageSize)	{	?>
    <p id="loading" class="more-products button" style="display:none">Загрузка...</p>
	<a href="#" id="showMore" class="more-products button">Показать еще</a>
	
	<input type="hidden" id="page_input" value="<?= (int)$app->request->getParam('page', 1) ?>">
	<input type="hidden" id="pageCount_input" value="<?= (int)$dataProvider->pagination->pageCount ?>">
	<input type="hidden" id="csrfTokenName" value="<?= $app->request->csrfTokenName ?>">
	<input type="hidden" id="csrfToken" value="<?= $app->request->csrfToken ?>"> 
	<input type="hidden" id="pagination-url" value="<?= $pagination_url ?>"> 
	
	<?
	/*
	$app->clientScript->registerScript('pages-index', "
$('.pager').hide();

var page = parseInt('".(int)$app->request->getParam('page', 1)."');
var pageCount = parseInt('".(int)$dataProvider->pagination->pageCount."');

var loadingFlag = false;

$('#showMore').click(function()
{
	if (!loadingFlag)
	{
		loadingFlag = true;

		$('#loading').show();
		$('#showMore').hide();

		$.ajax({
			type: 'post',
			//url: window.location.href,
			url: ".$pagination_url.",
			data: {
				'page': page + 1,
				'".$app->request->csrfTokenName."': '".$app->request->csrfToken."',
				'more': 1
			},
			success: function(data)
			{
				page++;                            
				loadingFlag = false;                            

				$('#loading').hide();
				$('#showMore').show();

				$('#listView').append(data);

				if (page >= pageCount)
					$('#showMore').hide();
			}
		});
	}
	return false;
})");*/?>
 
<?php	}	?>