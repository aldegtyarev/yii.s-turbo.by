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
			<a href="<?= Yii::app()->params->pages_images_liveUrl . 'full_'.$model->foto ?>" class="page-cnt-main-image" title="<?php echo $model->name; ?>">
				<img src="<?= Yii::app()->params->pages_images_liveUrl . 'thumb_'.$model->foto ?>" class="" alt="<?php echo $model->name; ?>">
			</a>
		<?php	}	?>
		<? echo $model->intro; ?>
		<? echo $model->text; ?>
	</div>
</div>
