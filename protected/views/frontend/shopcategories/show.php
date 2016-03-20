<?php

$this->breadcrumbs = $breadcrumbs;

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

//var_dump($select_engine);
//var_dump($show_search_notice);

//этот кусок нужен чтобы предупреждение появлялось после обновления страницы
if($select_engine == true && $show_search_notice == false)	{
	$js = "
	var menu_item = $('.sideLeft .cat-4622'),
		select_str = '';
		
	scroll_el_pos = menu_item.offset().top;
	$('.sideLeft .cat-4623').find('li').each(function() {
		if($(this).hasClass('bodyset')) {
			select_str = 'Для точного поиска, выберите КУЗОВ';
		}
		console.log($(this).attr('class'));
	});

	if(select_str === '') {
		select_str = 'Для точного поиска, выберите ДВИГАТЕЛЬ';
	}

	$('#select_engine_notice span').text(select_str);

	$('html, body').animate({ scrollTop: scroll_el_pos }, 900, function(){
		$('#select_engine_notice').css('top', (scroll_el_pos + 50));
		$('#select_engine_notice').fadeIn();

		document.onmousewheel=document.onwheel=function(){ 
			return true;
		};					
	});

	";
	$cs->registerScript('tooltip', $js, CClientScript::POS_READY);
}

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
<?	}	else	{
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
	<div class="engine-info"><?=CHtml::image($app->params->product_images_liveUrl . DIRECTORY_SEPARATOR . $engineImage) ?></div>
<?php	}	?>

<?php	if ((((count($dataProvider->data) && $model_auto_selected == true) || ($app->params['show_products_on_index'] == true)) && ($select_engine == false && $show_search_notice == false)) || $app->user->id == 1) {	?>
	
	<?php	include('_producttypes-firms-block.php')?>
	<?php
		$url_params = array('id'=>$category->id);
		if($body_request != 0) $url_params['body'] = $body_request;
		if($type_request != 0) $url_params['type'] = $type_request;
		if($firm_request != 0) $url_params['firm'] = $firm_request;
	?>
	
	<div class="select-view-block clearfix">
		<?php echo CHtml::beginForm($this->createUrl('/shopcategories/show', $url_params), 'get', array('id'=>'select-view-form', 'class'=>'select-view-form')); ?>
			<span class="font-12 db fLeft pt-5 pr-15 bold">Вид: </span>
			<a href="<?=$select_view_row?>" rel="nofollow" class="switch-view <? if($selected_view == 'row') echo 'view-row-active'; else echo 'view-row'; ?>">row</a>
			<a href="<?=$select_view_tile?>" rel="nofollow" class="switch-view <? if($selected_view == 'tile') echo 'view-tile-active'; else echo 'view-tile'; ?>">tile</a>		
		<?php echo CHtml::endForm(); ?>


		<?php if(count($related_categories) || count($related_types)) {	?>
			<div class="related_categories">
				<?php if(count($related_types) == 0) {	?>
					<?php foreach($related_categories as $related_category) {	?>
						<p>Посмотреть раздел <a href="<?= $related_category['url'] ?>" rel="nofollow" data-cat="cat-<?= $related_category['id'] ?>"><?= $related_category['cat_rel_name'] ? $related_category['cat_rel_name'] : $related_category['name'] ?></a></p>
					<?php	}	?>
				<?php	}	?>

				<?php foreach($related_types as $related_type) {	?>
					<p>Посмотреть раздел <a href="<?= $related_type['url'] ?>" rel="nofollow" data-cat="cat-<?= $related_type['category_id'] ?>"><?= $related_type['cat_rel_name'] ? $related_type['cat_rel_name'] : $related_type['name'] ?></a></p>
				<?php	}	?>
			</div>
		<?php	}	?>
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
<?php	}	elseif($select_engine == true && $show_search_notice == false)	{	?>
	<div id="select_engine_notice" class="select_engine_notice">
		<img src="/img/notice-arrow-left.png" alt="Для точного поиска, выберите ДВИГАТЕЛЬ">
		<span>Для точного поиска, выберите ДВИГАТЕЛЬ</span>
	</div>
<?php	}	?>



<?php if($category->category_description && $model_auto_selected == false) { ?>
	<div class="category-description clearfix">
		<?= $category->category_description?>
	</div>
<?php } ?>

<input type="hidden" id="scroll_to_engine" value="<?= ($select_engine == true && $show_search_notice == false) ? 1 : 0 ?>">