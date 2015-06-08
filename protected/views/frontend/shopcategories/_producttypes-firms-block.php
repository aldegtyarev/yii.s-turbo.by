<?php
function showFilterItems($list, $total = 0, $url_parameter, $main_url, $request_id, $this_, $category_id, $body_request, $type_request, $firm_request, $show_all = true) 
{
	$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) . $total . CHtml::CloseTag('span');
	
	if($request_id != 0)	{
		$htmlOptions = array();
	}	else	{
		$htmlOptions = array('class'=>'active');
	}
	
	if($show_all) {
		echo CHtml::OpenTag('li', array('class'=>'product-types-list-item product-types-list-all'));
		echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name'))."Все".CHtml::CloseTag('span') . $total_str, $main_url, $htmlOptions);
		echo CHtml::CloseTag('li');
	}
	//echo'<pre>';print_r($list);echo'</pre>';
	
	$k = 1;
	foreach($list as $item)	{
		$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) .$item['count'] . CHtml::CloseTag('span');
		
		$url_params = array(
			'id'=>$category_id,
		);
		
		if($url_parameter == 'body') {
			$url_params[$url_parameter] = $item['id'];
			//if($type_request != 0) $url_params['type'] = $type_request;	
		}	elseif($url_parameter == 'type') {
			$url_params[$url_parameter] = $item['id'];
			if($body_request != 0) $url_params['body'] = $body_request;
			if($firm_request != 0) $url_params['firm'] = $firm_request;
		}	elseif($url_parameter == 'firm') {
			$url_params[$url_parameter] = $item['id'];
			if($body_request != 0) $url_params['body'] = $body_request;
			if($type_request != 0) $url_params['type'] = $type_request;	
		}
		
		$url = $this_->createUrl('shopcategories/show', $url_params);
		//$url = $main_url . '?'. $url_parameter . '=' . $item['id'];
		
		if($request_id == $item['id'])	{
			$htmlOptions = array('class'=>'active');
		}	else	{
			$htmlOptions = array();
		}
		
		$class = 'product-types-list-item';
		//$clear = ( ($k - 1) % 4) +1;		
		//if(($k == 1 && $show_all) || ($k<=4 && $clear == 4) || ($k>4 && $clear == 3)) $class .= ' clear';
		if(($k == 1 && $show_all)) $class .= ' clear';
		echo CHtml::OpenTag('li', array('class'=>$class));
		echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name')).$item['name'].CHtml::CloseTag('span').$total_str, $url, $htmlOptions);
		echo CHtml::CloseTag('li');	
		
		$k++;
	}
	
}

$main_url = '/'.Yii::app()->getRequest()->getPathInfo();
//$main_url = '/'.Yii::app()->getRequest()->getRequestUri();
/*
if($type_request != 0)	{
	$htmlOptions = array('class'=>'filter-block-all-items');
}	else	{
	$htmlOptions = array('class'=>'filter-block-all-items active');
}
$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) . $productsTotal . CHtml::CloseTag('span');

$all_types = CHtml::link(CHtml::OpenTag('span', array('class'=>'name'))."Все".CHtml::CloseTag('span') . $total_str, $main_url, $htmlOptions);



if($body_request != 0)	{
	$htmlOptions = array('class'=>'filter-block-all-items');
}	else	{
	$htmlOptions = array('class'=>'filter-block-all-items active');
}
$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) . $productsTotal . CHtml::CloseTag('span');

$all_bodies = CHtml::link(CHtml::OpenTag('span', array('class'=>'name'))."Все".CHtml::CloseTag('span') . $total_str, $main_url, $htmlOptions);
*/
//echo'<pre>$type_request = ';print_r($type_request);echo'</pre>';

?>

<? if(count($producttypes) || count($firms))	{	?>
	<div class="filter-block container-block">
		<?/*
		<? if(count($bodies))	{ ?>
			<div class="bodies-block mb-30">
				<p class="filter-block-header">Уточните кузов</p>
				<ul class="product-types-list filter-block-list clearfix">
					<? showFilterItems($bodies, $productsTotal, 'body', $main_url, $body_request, $this, $category->id, $body_request, $type_request, $firm_request, true); ?>
				</ul>
			</div>
			
			<?/*
			<?php if($body_request == 0)	{	?>
				<div id="bodies-popup" class="p-20 bodies-popup" style="width:200px;display:none;">
					<div class="bodies-block">
						<p class="filter-block-header">Уточните кузов</p>
						<ul class="product-types-list filter-block-list clearfix">
							<? showFilterItems($bodies, $productsTotal, 'body', $main_url, $body_request, $this, $category->id, $body_request, $type_request, $firm_request, false); ?>
						</ul>
					</div>
				</div>
				<a href="#bodies-popup" id="select-body" class="fancybox" rel="nofollow" style="display:none;">Год</a>
				<?php $cs->registerScript('select-body', "$('#select-body').click(); ", CClientScript::POS_LOAD) ?>
			<?php	}	?>
			*/?>
			
			<?/*
		<?	}	?>		
		*/?>
		<? if(count($producttypes))	{ ?>
			<div class="product-types-block">
				<p class="filter-block-header">Категории</p>
				<?php
				/*
				$level=0;
				$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) . $productsTotal . CHtml::CloseTag('span');
	
				echo CHtml::OpenTag('div', array('class'=>'filter-block-list product-types-list-item product-types-list-all'));
				echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name'))."Все".CHtml::CloseTag('span') . $total_str, $main_url, $htmlOptions);
				echo CHtml::CloseTag('div');
	
				//echo CHtml::OpenTag('div', array('class'=>'product-types-list-wr clear'));
	
				foreach($producttypes as $n=>$cat)	{
					if($cat['level']==$level)
						echo CHtml::closeTag('li');
					else if($cat['level'] > $level)	{
						$ul_htmlOptions = array();
						if($cat['level'] == 1 && $level == 0)	{
							$ul_htmlOptions = array('class'=>'product-types-list filter-block-list clearfix clear');
						}
						
						echo CHtml::openTag('ul', $ul_htmlOptions);
						
						
					}	else	{
						echo CHtml::closeTag('li');

						for($i=$level-$cat['level'];$i;$i--)	{
							echo CHtml::closeTag('ul');
							echo CHtml::closeTag('li');
						}
					}
					$li_htmlOptions = array('class'=>'product-types-list-item');
					echo CHtml::openTag('li', $li_htmlOptions);
					
					$url_params = array(
						'id'=>$category->id,
					);

					$url_params['type'] = $cat['id'];
					if($body_request != 0) $url_params['body'] = $body_request;
					if($firm_request != 0) $url_params['firm'] = $firm_request;
					
					echo'<pre>';print_r($url_params);echo'</pre>';
					

					$url = $this->createUrl('shopcategories/show', $url_params);

					$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) .CHtml::encode($cat['count']) . CHtml::CloseTag('span');
					if($cat['count'] != 0) {
						echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name')).CHtml::encode($cat['name']).CHtml::CloseTag('span').$total_str, $url, $htmlOptions);
					}	else	{
						echo CHtml::openTag('p').CHtml::OpenTag('span', array('class'=>'name')).CHtml::encode($cat['name']).CHtml::CloseTag('span').CHtml::closeTag('p');
					}
						
					
					$level = $cat['level'];
				}

				for($i=$level;$i;$i--)	{
					echo CHtml::closeTag('li');
					echo CHtml::closeTag('ul');
				}			
				*/
									 
				?>
				
				<ul class="product-types-list filter-block-list clearfix">
					<? showFilterItems($producttypes, $productsTotal, 'type', $main_url, $type_request, $this, $category->id, $body_request, $type_request, $firm_request, true); ?>
				</ul>
				
			</div>
		<?	}	?>

		<? if(count($firms))	{ ?>
			<div class="firms-block">
				<p class="filter-block-header">Производители</p>
				<ul class="product-types-list filter-block-list clearfix">
					<? showFilterItems($firms, $productsTotal, 'firm', $main_url, $firm_request, $this, $category->id, $body_request, $type_request, $firm_request, true); ?>
				</ul>
				
			</div>
		<?	}	?>

		<a href="<?=$main_url?>" class="clear-filter">Сбросить фильтр</a>
		
	</div>
<?	}	?>


