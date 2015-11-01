<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	$model->name,
);

$app = Yii::app();
$clientScript = $app->clientScript;
$clientScript->registerCoreScript('fancybox');


MetaHelper::setMeta($this, $model);

?>
<div class="page-cnt <?=$current_controller . '-' . $current_action?>">
	<h1><?php echo $model->name; ?></h1>

	<div class="page-body"><? echo $model->text; ?></div>
</div>
