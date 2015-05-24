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
//echo'<pre>';print_r($firm_request);echo'</pre>';

//$products = $products_and_pages['rows'];
//$pagination = $products_and_pages['pages'];

$images_live_url = substr($app->params->images_live_url, 0, -1);	// на таких страницах нужно удалить последний слэш

$params = $app->params;


?>

<div class="category-view">
	<h1><?=$category->name?></h1>
<?php if(count($descendants) && $descendants[0]->category_image == null)	{
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
		
		<?php	foreach($descendants as $category)	{
			$caturl = $this->createUrl('/shopcategories/show/', array('id'=>$category->id));
			?>
			<li class="category-item">
				<div class="category-item-wr">
					<a href="<?php echo $caturl ?>" title="<?php echo $category->name ?>">
					<?php if ($category->category_image){
						echo CHtml::image($images_live_url . DIRECTORY_SEPARATOR . $category->category_image).'<br />';
					} ?>
						<span><?php echo $category->name ?></span>
					</a>
				</div>
			</li>
		<?php	}	?>
		</ul>
	<?php	}
}

?>
</div>

<?php	if (count($dataProvider->data)) {	?>
	
	<?php	include('_producttypes-firms-block.php')?>
	
	<div class="select-view-block clearfix">
		<?php echo CHtml::beginForm($this->createUrl('/shopcategories/show', array('id'=>$category->id)), 'get', array('id'=>'select-view-form')); ?>
		<span class="font-12 db fLeft pt-5 pr-15 bold">Вид: </span>
		
		<a href="?select-view=row" class="<? if($selected_view == 'row') echo 'view-row-active'; else echo 'view-row'; ?>">row</a>
		<a href="?select-view=tile" class="<? if($selected_view == 'tile') echo 'view-tile-active'; else echo 'view-tile'; ?>">tile</a>
		
		<?php if(count($firmsDropDown) != 0) echo CHtml::dropDownList('firm', $firm_request, $firmsDropDown,  array('empty' => '(Выберите фирму)')) ?>
		<?php echo CHtml::endForm(); ?>
	</div>
	
	<div class="category-products-list">		
		<?php 
			$this->renderPartial('_loop', array(
				'app'=>$app,
				'dataProvider'=>$dataProvider,
				'itemView'=>$itemView,
			));						 
		?>		
	</div>		
<?php	}	?>



<?php if($category->category_description) { ?>
	<div class="category-description"><?=$category->category_description?></div>
<?php } ?>

