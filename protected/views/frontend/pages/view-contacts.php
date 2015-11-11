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

$show_form = true;

?>
<div class="page-cnt <?=$current_controller . '-' . $current_action?>">
	<h1><?php echo $model->name; ?></h1>

	<div class="page-body clearfix">
	
		<?php if(Yii::app()->user->hasFlash('contact'))	{	?>
			<?php $show_form = false; ?>
		
			<div class="flash-success"><?php echo Yii::app()->user->getFlash('contact'); ?></div>
		<?php	}	?>
	
		<? echo $model->text; ?>
		
		<?php if($show_form == true) $this->renderPartial('_contact-form', array('model'=>$form));?>
		
		<? echo $model->intro; ?>
		
	</div>
</div>
