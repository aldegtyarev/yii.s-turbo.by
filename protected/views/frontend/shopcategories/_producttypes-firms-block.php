<?
function showFilterItems($list, $total = 0, $url_parameter, $main_url, $request_id, $show_all = true) 
{
	$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) . $total . CHtml::CloseTag('span');
	
	if($request_id != 0)	{
		$htmlOptions = array();
	}	else	{
		$htmlOptions = array('class'=>'active');
	}
	
	if($show_all) {
		echo CHtml::OpenTag('li', array('class'=>'product-types-list-item'));
		echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name'))."Все".CHtml::CloseTag('span') . $total_str, $main_url, $htmlOptions);
		echo CHtml::CloseTag('li');
	}

	foreach($list as $item)	{
		$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) .$item['count'] . CHtml::CloseTag('span');
		$url = $main_url . '?'. $url_parameter . '=' . $item['id'];
		
		if($request_id == $item['id'])	{
			$htmlOptions = array('class'=>'active');
		}	else	{
			$htmlOptions = array();
		}
		
		echo CHtml::OpenTag('li', array('class'=>'product-types-list-item'));
		echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name')).$item['name'].CHtml::CloseTag('span').$total_str, $url, $htmlOptions);
		echo CHtml::CloseTag('li');							
	}
	
}

$main_url = '/'.Yii::app()->getRequest()->getPathInfo();
?>

<? if(count($producttypes) || count($firms))	{	?>
	<div class="filter-block container-block">
		<? if(count($producttypes))	{ ?>
			<div class="product-types-block">
				<p class="filter-block-header">Категории</p>
				<ul class="product-types-list filter-block-list clearfix">
					<? showFilterItems($producttypes, $productsTotal, 'type', $main_url, $type_request); ?>
				</ul>
			</div>
		<?	}	?>
		<?php /*
		<? if(count($firms))	{ ?>
			<div class="firms-block">
				<p class="filter-block-header">Производители</p>
				<ul class="product-types-list filter-block-list clearfix">
					<? showFilterItems($firms, $productsTotal, 'firm', $main_url, $firm_request); ?>
				</ul>
				
			</div>
		<?	}	?>
		*/ ?>
		<? if(count($bodies))	{ ?>
			<div class="bodies-block">
				<p class="filter-block-header">Год</p>
				<ul class="product-types-list filter-block-list clearfix">
					<? showFilterItems($bodies, $productsTotal, 'body', $main_url, $body_request); ?>
				</ul>
			</div>
			
			<?php if($body_request == 0)	{	?>
				<div id="bodies-popup" class="p-20 bodies-popup" style="width:200px;display:none;">
					<div class="bodies-block">
						<p class="filter-block-header">Уточните год</p>
						<ul class="product-types-list filter-block-list clearfix">
							<? showFilterItems($bodies, $productsTotal, 'body', $main_url, $body_request, false); ?>
						</ul>
					</div>
				</div>
				<a href="#bodies-popup" id="select-body" class="fancybox" rel="nofollow" style="display:none;">Год</a>
				<?php $cs->registerScript('select-body', "$('#select-body').click(); ") ?>
			<?php	}	?>
		<?	}	?>		
		<a href="<?=$main_url?>" class="clear-filter">Сбросить фильтр</a>
		
	</div>
<?	}	?>


