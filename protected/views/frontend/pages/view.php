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

?>
<div class="page-cnt <?=$current_controller . '-' . $current_action?>">
	<h1><?php echo $model->name; ?></h1>

	<div class="page-body clearfix">
		<?php if($model->foto != '')	{	?>
			<a href="<?= Yii::app()->params->pages_images_liveUrl . 'full_'.$model->foto ?>" class="fancybox page-cnt-main-image" title="<?php echo $model->name; ?>">
				<img src="<?= Yii::app()->params->pages_images_liveUrl . 'thumb_'.$model->foto ?>" class="" alt="<?php echo $model->name; ?>">
			</a>
		<?php	}	?>
		<div class="page-text-intro"><? echo $model->intro; ?></div>
		<div class="page-text-main"><? echo $model->text; ?></div>
		
		<?php if($model->type != 1)	{	?>
			<script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus"></div>		
		<?php	}	?>
	</div>
</div>
