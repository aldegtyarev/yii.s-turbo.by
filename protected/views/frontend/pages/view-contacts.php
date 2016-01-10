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
			<?php 
				$show_form = false;
				$js = "$('#msgsended-popup').click();";
				$js1 = '$(".fb-orderdone").fancybox({padding : 0});';

				$app->clientScript->registerScript('msg-sended', $js, CClientScript::POS_LOAD);
				$app->clientScript->registerScript('fb-msg-sended', $js1, CClientScript::POS_READY);
														 
			?>
			
			<a href="#msg-sended-popup" id="msgsended-popup" class="fb-orderdone" style="color:#fff;font-size:2px;"><span>Подробнее</span></a>
			<div id="msg-sended-popup" class="order-done-popup" style="width: 550px; display: none;">
				<div class="order-done-hdr">
					<img src="/img/logo-top.png" alt="магазин автомобильных запчастей">
				</div>
				
				<div class="order-done-info">
					<p class="text_c">Ваше сообщение отправлено.<br>В ближайшее время на Ваш e-mail придет ответ.<br><br>Спасибо!</p>
				</div>

			</div>
			
			
		<?php	}	?>
	
		<? echo $model->text; ?>
		
		<?php if($show_form == true) $this->renderPartial('_contact-form', array('model'=>$form));?>
		
		<? echo $model->intro; ?>
		
	</div>
	
	
</div>
