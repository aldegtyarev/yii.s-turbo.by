<?
function showFilterItems($list, $total = 0) 
{
	$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) . $total . CHtml::CloseTag('span');
	
	echo CHtml::OpenTag('li', array('class'=>'product-types-list-item'));
	echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name'))."Все".CHtml::CloseTag('span') . $total_str, '#', array('class'=>'active'));
	echo CHtml::CloseTag('li');							

	foreach($list as $item)	{
		$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) .$item['count'] . CHtml::CloseTag('span');
		echo CHtml::OpenTag('li', array('class'=>'product-types-list-item'));
		echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name')).$item['name'].CHtml::CloseTag('span').$total_str, '#');
		echo CHtml::CloseTag('li');							
	}
	
}
?>
<? if(count($producttypes) || count($firms))	{	?>
	<div class="filter-block container-block">
		<? if(count($producttypes))	{ ?>
			<div class="product-types-block">
				<p class="filter-block-header">Категории</p>
				<ul class="product-types-list filter-block-list clearfix">
					<? showFilterItems($producttypes, $productsTotal); ?>
				</ul>
			</div>
		<?	}	?>
		<? if(count($firms))	{ ?>
			<div class="firms-block">
				<p class="filter-block-header">Производители</p>
				<ul class="product-types-list filter-block-list clearfix">
					<? showFilterItems($firms, $productsTotal); ?>
				</ul>
				
			</div>
		<?	}	?>
		<a href="/<?=Yii::app()->getRequest()->getPathInfo()?>" class="clear-filter">Сбросить фильтр</a>
	</div>
<?	}	?>


