<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->breadcrumbs = $breadcrumbs;
/*
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$category->name,
);
*/

$app = Yii::app();
//$base_url = $app->getBaseUrl(true);
//echo'<pre>';print_r($base_url);echo'</pre>';
//echo'<pre>';print_r($app->homeUrl);echo'</pre>';

//$clientScript = $app->clientScript;
//$clientScript->registerCssFile('/css/shop.css', 'screen');
//echo'<pre>';print_r(count($descendants));echo'</pre>';
//echo'<pre>';print_r($descendants);echo'</pre>';
//echo'<pre>';print_r($products_and_pages);echo'</pre>';

$products = $products_and_pages['rows'];
$pagination = $products_and_pages['pages'];

$images_live_url = substr($app->params->images_live_url, 0, -1);	// на таких страницах нужно удалить последний слэш

$params = $app->params;

//echo'<pre>';print_r($category);echo'</pre>';

?>

<?	/*<h1><?php echo $category->name; ?></h1>	*/?>
<div class="category-view">
	<h1><?=$category->name?></h1>
<?if(count($descendants) && $descendants[0]->category_image == null)	{
			$child_col0 = array();
			$child_col1 = array();
			$child_col2 = array();
			$child_col3 = array();		

			foreach ( $descendants as $category ) {
				//echo $category->cat_column.'<br />';
				switch($category->cat_column){
					case 0:
						$child_col0[] = $category;
						break;
					case 1:
						$child_col1[] = $category;
						break;
					case 2:
						$child_col2[] = $category;
						break;
					case 3:
						$child_col3[] = $category;
						break;
					default:
						break;
				}
			}

			?>
			<div class="item-page">
				<table class="child-categories">
					<tr>
						<td>
							<ul>
								<?php
									foreach($child_col1 as $category){
										$caturl = $this->createUrl('/shopcategories/show/', array('id'=>$category->id));
										echo'<li><a href="'.$caturl.'">'.$category->name.'</a></li>';
									}
									foreach($child_col0 as $category){
										$caturl = $this->createUrl('/shopcategories/show/', array('id'=>$category->id));
										echo'<li><a href="'.$caturl.'">'.$category->name.'</a></li>';
									}
								?>
							</ul>
						</td>
						<td>
							<ul>
								<?php
									foreach($child_col2 as $category){
										$caturl = $this->createUrl('/shopcategories/show/', array('id'=>$category->id));
										echo'<li><a href="'.$caturl.'">'.$category->name.'</a></li>';
									}
								?>
							</ul>
						</td>
						<td>
							<ul>
								<?php
									foreach($child_col3 as $category){
										$caturl = $this->createUrl('/shopcategories/show/', array('id'=>$category->id));
										echo'<li><a href="'.$caturl.'">'.$category->name.'</a></li>';
									}
								?>
							</ul>
						</td>
					</tr>
				</table>
			</div>

<?

}	else	{
	
	if(count($descendants))	{	?>
		<? /* <p style="font-weight:bold;color:#2779B7;">Выберите категорию</p> */ ?>
		
		<ul class="categories-list claerfix">
		
		<?	foreach($descendants as $category)	{
			$caturl = $this->createUrl('/shopcategories/show/', array('id'=>$category->id));
			?>
			<li class="category-item">
				<div class="category-item-wr">
					<a href="<?php echo $caturl ?>" title="<?php echo $category->name ?>">
					<?php
						if ($category->category_image){
							echo CHtml::image($images_live_url . DIRECTORY_SEPARATOR . $category->category_image).'<br />';
						} ?>
						<span><?php echo $category->name ?></span>
					</a>
				</div>
			</li>
		<?	}	?>
		</ul>
	<?	}
}

?>
</div>

<?	if (!empty($products)) {	?>
	
	<?	include('producttypes-firms-block.php')?>
	
	<div class="select-view-block clearfix">
		<a href="?select-view=row" class="<? if($selected_view == 'row') echo'view-row-active'; else echo'view-row'; ?>">row</a>
		<a href="?select-view=tile" class="<? if($selected_view == 'tile') echo'view-tile-active'; else echo'view-tile'; ?>">tile</a>
	</div>
	
	<?/*
	<div class="container-block sorting-block-conteiner">
		<span class="sorting-block">Сортировать по: <a href="#" class="active">цене</a> <a href="#">товар в наличии</a></span>
		<span class="currency-select">Цены в: <a href="#" class="active">USD</a> <a href="#">BR</a> <a href="#">RUB</a></span>
	</div>
	*/?>
	
<?
	$rows = $products;
	//$images_live_url = $app->params->images_live_url;
	$webroot = Yii::getPathOfAlias('webroot');
	$product_classes = "";
	$isWidget = false;	
	?>
		<div class="category-products-list">
			<ul class="products-list clearfix">
				<? //include("$webroot/protected/views/frontend/common/product-list.php");	?>
				<? 
					if($selected_view == 'row')	{
						include("$webroot/protected/views/frontend/common/product-list-row.php");
					}	else	{
						include("$webroot/protected/views/frontend/common/product-list.php");
					}
				?>
			</ul>
		
		</div>


	<? 
//echo'<pre>';print_r($pagination->itemCount);echo'</pre>';							
	if($pagination && ($pagination->pageSize < $pagination->itemCount))	{	?>
		<a href="#" class="more-products button">Ещё товары</a>
		<div class="pagination">
			<?php 
				
					$this->widget('CLinkPager', array(	
						'header' => '', 
						'pages' => $pagination, 
						'id' => 'pages',
						'nextPageLabel'=> '>',
						'prevPageLabel'=> '<',
						'cssFile'=>'/css/pager.css',
						'htmlOptions' => array(
							'class' => 'pagination-list', 
						),
					));
				
			?>
		</div>
	<?	}	?>			

<?	}	?>

<? if($category->category_description) { ?>
	<div class="category-description"><?=$category->category_description?></div>
<? } ?>

