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
$cs = $app->clientScript;
$cs->registerCoreScript('fancybox');

if ($engineTitle != null) {
	$title = $engineTitle;
}	else	{
	$title = $category->name;
}

$this->pageTitle = $title.' | '.$app->name;

$images_live_url = substr($app->params->images_live_url, 0, -1);	// на таких страницах нужно удалить последний слэш

$params = $app->params;

$cat_imgPath = Yii::getPathOfAlias($app->params->category_imagePath);
?>

<div class="category-view">
	<?php if($show_search_notice == true)	{	?>
		<div class="search-notice">
			<img src="/img/notice-arrow-up.png" alt="Для точного поиска, выберите СВОЙ АВТОМОБИЛЬ">
			<p>Для точного поиска, выберите СВОЙ АВТОМОБИЛЬ</p>
		</div>
	<?php }	?>
	
	<h1<?= $show_search_notice ? ' class="h1-small"' : ''; if($engineImage != null) echo ' class="engine-h1"' ?>><?=$title?></h1>

<?php if(count($descendants))	{	?>
			<div class="category-products-list child-categories products-list clearfix">
				<?php
					$i = 1;
					foreach($descendants as $cat)	{
						if(($i-1)%4 == 0) $clr = ' clear';
							else $clr = '';

						$i++;
						
						$caturl = $this->createUrl('/shopcategories/show/', array('id'=>$cat->id));
						
						if($cat->foto == '') {
							$cat_image = '/img/no_photo.png';
						}	elseif(file_exists($cat_imgPath . DIRECTORY_SEPARATOR . 'thumb_'.$cat->foto))	{
							$cat_image = $app->params->category_images_liveUrl . 'thumb_'.$cat->foto;
						}	else	{
							$cat_image = '/img/no_photo.png';
						}
						?>
						<div class="product-item product-list-item fLeft<?= $clr ?>">
							<a href="<?= $caturl ?>" class="product-item-wr" title="<?= $cat->name ?>">
								<span class="product-image-cnt">
									<img class="product-image" src="<?= $cat_image ?>" alt="<?= $cat->name ?>">
								</span>
								<span class="product-title cat-title db bold text_c font-12"><?= $cat->name ?></span>
							</a>
						</div>
				<?	}	?>
			</div>

<?

}	else	{
	if(count($descendants))	{	?>
		<ul class="categories-list claerfix">
		
		<?php foreach($descendants as $cat)	{
			$caturl = $this->createUrl('/shopcategories/show/', array('id'=>$cat->id));
			?>
			<li class="category-item">
				<div class="category-item-wr">
					<a href="<?php echo $caturl ?>" title="<?php echo $cat->name ?>">
					<?php if ($cat->category_image){
						echo CHtml::image($images_live_url . DIRECTORY_SEPARATOR . $cat->category_image).'<br />';
					} ?>
						<span><?php echo $cat->name ?></span>
					</a>
				</div>
			</li>
		<?php	}	?>
		</ul>
	<?php	}
}

?>
</div>

<?php	if ($engineImage != null) {	?>
	<div class="engine-info">
		<?=CHtml::image($app->params->product_images_liveUrl . DIRECTORY_SEPARATOR . $engineImage) ?>
	</div>
<?php	}	?>

<?php	if (count($dataProvider->data) && $model_auto_selected == true || $app->params['show_products_on_index'] == true || $app->user->id == 1) {	?>
	
	<?php	include('_producttypes-firms-block.php')?>
	<?php
	
		$url_params = array('id'=>$category->id);
																																				  
		if($body_request != 0) $url_params['body'] = $body_request;
		if($type_request != 0) $url_params['type'] = $type_request;
		if($firm_request != 0) $url_params['firm'] = $firm_request;
	?>
	
	<div class="select-view-block clearfix">
		<?php echo CHtml::beginForm($this->createUrl('/shopcategories/show', $url_params), 'get', array('id'=>'select-view-form')); ?>
			<span class="font-12 db fLeft pt-5 pr-15 bold">Вид: </span>
			<a href="<?=$select_view_row?>" rel="nofollow" class="switch-view <? if($selected_view == 'row') echo 'view-row-active'; else echo 'view-row'; ?>">row</a>
			<a href="<?=$select_view_tile?>" rel="nofollow" class="switch-view <? if($selected_view == 'tile') echo 'view-tile-active'; else echo 'view-tile'; ?>">tile</a>		
		<?php echo CHtml::endForm(); ?>
	</div>
	
	<div class="category-list-<?= $category->id ?> category-products-list">		
		<?php 
			$this->renderPartial('_loop', array(
				'app'=>$app,
				'dataProvider'=>$dataProvider,
				'itemView'=>$itemView,
				'currency_info' => $currency_info,
			));						 
		?>		
	</div>		
<?php	}	?>



<?php if($category->category_description && $model_auto_selected == false) { ?>
	<div class="category-description clearfix">
		<?= $category->category_description?>
	</div>
<?php } ?>

