<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">


<?php
$cs        = Yii::app()->clientScript;
//$themePath = Yii::app()->theme->baseUrl;
$themePath = '';

/**
 * StyleSHeets
 */
//$cs->registerCssFile('/css/bootstrap.css');
//$cs->registerCssFile('/css/bootstrap-theme.css');
$cs->registerCoreScript('bootstrap-pack');

/**
 * JavaScripts
 */
//$cs->registerCoreScript('jquery', CClientScript::POS_END);
//$cs->registerCoreScript('jquery.ui', CClientScript::POS_END);
/*
$cs->registerScriptFile('/js/bootstrap.min.js', CClientScript::POS_END);
$cs->registerScript('tooltip', "$('[data-toggle=\"tooltip\"]').tooltip();$('[data-toggle=\"popover\"]').tooltip()", CClientScript::POS_READY);
*/
?>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="<?php
echo Yii::app()->theme->baseUrl . '/assets/js/html5shiv.js';
?>"></script>
    <script src="<?php
echo Yii::app()->theme->baseUrl . '/assets/js/respond.min.js';
?>"></script>
<![endif]-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript"></script>
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/cms/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/cms/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/cms/main.css" />
	<? /* <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/cms/form.css" /> */?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header" class="row">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu" class="row">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				//array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Категории магазина', 'url'=>array('shopcategories/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Модельный ряд', 'url'=>array('shopmodelsauto/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Товары', 'url'=>array('shopproducts/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Производители', 'url'=>array('shopmanufacturers/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Фирмы', 'url'=>array('shopfirms/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Кузова', 'url'=>array('shopbodies/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Группа товаров', 'url'=>array('shopproducttypes/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Страницы', 'url'=>array('pages/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Новости магазина', 'url'=>array('shopposts/admin'), 'visible'=>!Yii::app()->user->isGuest),
				//array('label'=>'Баннеры', 'url'=>array('banners/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	<?php //$this->widget('application.components.MsiLogin'); ?>		
	</div><!-- mainmenu -->
	
	<?php if(isset($this->breadcrumbs)):?>
		<div class="row">
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
		</div>
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer" class="row">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
