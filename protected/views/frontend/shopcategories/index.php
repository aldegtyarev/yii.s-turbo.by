<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->pageTitle = $title.' | '.$app->name;

$this->breadcrumbs = $breadcrumbs;

$main_url = '/'.Yii::app()->getRequest()->getPathInfo();
?>

<?	/*<h1><?php echo $category->name; ?></h1>	*/?>
<div class="category-view">
	<h1><?=$title?></h1>
</div>
<?php //echo'<pre>';print_r($producttypes);echo'</pre>'; ?>

<?/*
<? if(count($producttypes))	{ ?>
	<div class="filter-block container-block">

			<div class="product-types-block">
				<p class="filter-block-header">Категории</p>
				<?php
	
				$htmlOptions = array();
	
				$level=0;
	
				$total_str = CHtml::OpenTag('span', array('class'=>'product-count')) . $productsTotal . CHtml::CloseTag('span');
	
				echo CHtml::OpenTag('div', array('class'=>'product-types-index-item product-types-index-all'));
				echo CHtml::link(CHtml::OpenTag('span', array('class'=>'name'))."Все".CHtml::CloseTag('span') . $total_str, $main_url, $htmlOptions);
				echo CHtml::CloseTag('div');
	
				//echo CHtml::OpenTag('div', array('class'=>'product-types-list-wr clear'));
	
				foreach($producttypes as $n=>$cat)	{
					if($cat['level']==$level)
						echo CHtml::closeTag('li');
					else if($cat['level'] > $level)	{
						$ul_htmlOptions = array();
						if($cat['level'] == 1 && $level == 0)	{
							$ul_htmlOptions = array('class'=>'product-types-index clearfix clear');
						}
						
						echo CHtml::openTag('ul', $ul_htmlOptions);
						
						
					}	else	{
						echo CHtml::closeTag('li');

						for($i=$level-$cat['level'];$i;$i--)	{
							echo CHtml::closeTag('ul');
							echo CHtml::closeTag('li');
						}
					}
					$li_htmlOptions = array('class'=>'product-types-index-item');
					echo CHtml::openTag('li', $li_htmlOptions);
					
					$url_params = array();

					$url_params['type'] = $cat['id'];
					//if($body_request != 0) $url_params['body'] = $body_request;
					//if($firm_request != 0) $url_params['firm'] = $firm_request;
					
					//echo'<pre>';print_r($url_params);echo'</pre>';
					

					$url = $this->createUrl('shopcategories/index', $url_params);

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
				
									 
				?>
				
			</div>
		<a href="<?=$main_url?>" class="clear-filter">Сбросить фильтр</a>
		
	</div>
<?	}	?>

*/?>
<?	if (count($dataProvider->data)) {	?>
	
	<div class="select-view-block clearfix">
		<span class="font-12 db fLeft pt-5 pr-15 bold">Вид: </span>
		<a href="?select-view=row" class="<? if($selected_view == 'row') echo'view-row-active'; else echo'view-row'; ?>">row</a>
		<a href="?select-view=tile" class="<? if($selected_view == 'tile') echo'view-tile-active'; else echo'view-tile'; ?>">tile</a>
	</div>
	
	<div class="category-products-list">		
		<? 
			$this->renderPartial('_loop', array(
				'app'=>$app,
				'dataProvider'=>$dataProvider,
				'itemView'=>$itemView,
			));						 
		?>
	</div>		
<?	}	?>