<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->pageTitle = $title.' | '.$app->name;

$this->breadcrumbs = $breadcrumbs;

$main_url = '/'.Yii::app()->getRequest()->getPathInfo();
?>

<?	/*<h1><?php echo $category->name; ?></h1>	*/?>
<div class="category-view">

	<?php if($show_search_notice == true)	{	?>
		<div class="search-notice-1">
			
			<p><img src="/img/notice-arrow-left.png" alt="Для точного поиска, воспользуйтесь КАТАЛОГОМ">Для точного поиска, воспользуйтесь КАТАЛОГОМ</p>
		</div>
	<?php }	?>

	<h1<?= $show_search_notice ? ' class="h1-small"' : '' ?>><?=$title?></h1>
</div>

<?/*
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

*/?>