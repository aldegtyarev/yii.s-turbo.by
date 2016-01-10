<?php
/* @var $this PagesController */
/* @var $model Pages */

//$this->breadcrumbs=array(
//	$model->name,
//);

$this->breadcrumbs = $breadcrumbs;

$app = Yii::app();
$clientScript = $app->clientScript;
$clientScript->registerCoreScript('fancybox');


MetaHelper::setMeta($this, $model);

$params = $app->params;
if($model->foto != '')	{
	$image_url = $app->getBaseUrl(true) . $params->pages_images_liveUrl . 'full_'.$model->foto;
}	else	{
	$image_url = '';
}

$current_url = $app->getBaseUrl(true).$app->getRequest()->getUrl();

mb_internal_encoding('UTF-8');
$desc .= strip_tags($model->intro);
$desc = mb_substr($desc, 0, 297).'...';

if (!$app->request->isAjaxRequest) {
	$clientScript->registerMetaTag($image_url, 'og:image');
	$clientScript->registerMetaTag('article', 'og:type');
	$clientScript->registerMetaTag($current_url, 'og:url');
	$clientScript->registerMetaTag($this->pageTitle, 'og:title');
	$clientScript->registerMetaTag($desc, 'og:description');
}


?>
<div class="page-cnt <?=$current_controller . '-' . $current_action?>">
	<?php 
		if ($app->request->isAjaxRequest) {
			
			$tag = 'og_image';
			echo CHtml::hiddenField($tag, $image_url, array ('id'=>$tag));
			
			$tag = 'og_type';
			echo CHtml::hiddenField($tag, 'article', array ('id'=>$tag));
			
			$tag = 'og_url';
			echo CHtml::hiddenField($tag, $current_url, array ('id'=>$tag));
			
			$tag = 'og_title';
			echo CHtml::hiddenField($tag, $this->pageTitle, array ('id'=>$tag));
			
			$tag = 'og_description';
			echo CHtml::hiddenField($tag, $product_desc, array ('id'=>$tag));
		}
	?>

	<h1><?php echo $model->name; ?></h1>

	<div class="page-body clearfix">
		<?php if($model->foto != '')	{	?>
			<a href="<?= $params->pages_images_liveUrl . 'full_'.$model->foto ?>" class="fancybox page-cnt-main-image" title="<?php echo $model->name; ?>">
				<img src="<?= $params->pages_images_liveUrl . 'thumb_'.$model->foto ?>" class="" alt="<?php echo $model->name; ?>">
			</a>
		<?php	}	?>
		<div class="page-text-intro"><? echo $model->intro; ?></div>
		<div class="page-text-main"><? echo $model->text; ?></div>
		
		<?php if($model->type != 1)	{	?>
			<div id="likes-block" class="likes-block">
				<?/*
				<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
				<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
				*/?>
				<div id="my-share" class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,lj"></div>

			</div>
		<?php	}	?>
	</div>
</div>
