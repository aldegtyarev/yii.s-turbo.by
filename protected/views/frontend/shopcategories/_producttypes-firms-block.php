<?php
function showFilterItems($list, $total = 0, $url_parameter, $main_url, $request_id, $this_, $category_id, $body_request, $type_request, $firm_request, $show_all = true, $url_params) 
{
	$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) . $total . CHtml::CloseTag('span');
	
	if($request_id != 0)	{
		$htmlOptions = array();
	}	else	{
		$htmlOptions = array('class'=>'active');
	}
	
	if($show_all) {
		//echo CHtml::OpenTag('li', array('class'=>'product-types-list-item product-types-list-all'));
		echo CHtml::OpenTag('li', array('class'=>'product-types-list-item'));
		echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name'))."Все".CHtml::CloseTag('span') . $total_str, $main_url, $htmlOptions);
		echo CHtml::CloseTag('li');
	}
	//echo'<pre>';print_r($url_params);echo'</pre>';
	
	$k = 1;
	
	foreach($list as $item)	{
		$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) .$item['count'] . CHtml::CloseTag('span');
		
		$url_params_ = array();
		foreach($url_params as $k=>$v) {
			if($k != 'current_action' && $k != 'current_controller' && !is_null($v))
				$url_params_[$k] = $v;
		}
		
		if($url_parameter == 'body') {
			$url_params_[$url_parameter] = $item['id'];
			//if($type_request != 0) $url_params['type'] = $type_request;	
		}	elseif($url_parameter == 'type') {
			$url_params_[$url_parameter] = $item['id'];
			if($body_request != 0) $url_params_['body'] = $body_request;
			if($firm_request != 0) $url_params_['firm'] = $firm_request;
		}	elseif($url_parameter == 'firm') {
			$url_params_[$url_parameter] = $item['id'];
			if($body_request != 0) $url_params_['body'] = $body_request;
			if($type_request != 0) $url_params_['type'] = $type_request;	
		}
		
		//echo'<pre>';print_r($url_params_);echo'</pre>';
		
		$url = $this_->createUrl('shopcategories/show', $url_params_);
		
		if($request_id == $item['id'])	{
			$htmlOptions = array('class'=>'active');
		}	else	{
			$htmlOptions = array();
		}
		
		if(($k-1)%4 == 0) $clr = ' clear';
			else $clr = '';
		
		$class = 'product-types-list-item'.$clr;
		//if(($k == 1 && $show_all)) $class .= ' clear';
		echo CHtml::OpenTag('li', array('class'=>$class));
		echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name')).$item['name'].CHtml::CloseTag('span').$total_str, $url, $htmlOptions);
		echo CHtml::CloseTag('li');	
		
		$k++;
	}
	
}

$main_url = '/'.Yii::app()->getRequest()->getPathInfo();

$url_params = UrlHelper::getUrlParams(Yii::app());

?>

<? //if(count($producttypes) || count($firms))	{	?>
<? if(count($producttypes))	{	?>
	<div class="filter-block container-block">
		<? if(count($producttypes))	{ ?>
			<div class="product-types-block clearfix">
				<?/*<p class="filter-block-header">Категории</p>*/?>
				
				<ul class="product-types-list filter-block-list filter-block-list-all clearfix">
					<li class="product-types-list-item">
						<a <?php if($type_request == 0) echo 'class="active"'?> href="<?= $main_url ?>"><span class="name">Все</span><span class="product-count"><?= $productsTotal ?></span></a>
					</li>
				</ul>
				
				<ul class="product-types-list filter-block-list filter-block-list-items clearfix">
					<? //showFilterItems($producttypes, $productsTotal, 'type', $main_url, $type_request, $this, $category->id, $body_request, $type_request, $firm_request, true); ?>
					<?php showFilterItems($producttypes, $productsTotal, 'type', $main_url, $type_request, $this, $category->id, $body_request, $type_request, $firm_request, false, $url_params); ?>
				</ul>
				
			</div>
		<?	}	?>
		<?/*
		<? if(count($firms))	{ ?>
			<div class="firms-block">
				<p class="filter-block-header">Производители</p>
				<ul class="product-types-list filter-block-list clearfix">
					<? showFilterItems($firms, $productsTotal, 'firm', $main_url, $firm_request, $this, $category->id, $body_request, $type_request, $firm_request, true); ?>
				</ul>
				
			</div>
		<?	}	?>
		*/?>
		<a href="<?=$main_url?>" class="clear-filter">Сбросить фильтр</a>
		
	</div>
<?	}	?>


