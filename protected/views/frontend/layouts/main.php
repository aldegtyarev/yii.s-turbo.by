<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<?php
	$app = Yii::app();
	
	//$requestUri	= $app->request->requestUri;
	$current_action = $app->getController()->getAction()->getId();
	$current_controller =  $app->getController()->getId();
	
	//$baseUrl = $app->request->HostInfo;
	//$baseUrl_banners = $baseUrl."/images/banners/";
	$cs = $app->getClientScript();
	$cs->coreScriptPosition = CClientScript::POS_END;
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('scripts');
	//$cs->registerCoreScript('fancybox');
	$cs->registerCoreScript('formstyler');

	//$cs->registerCoreScript('fancybox');
	//$cs->registerCoreScript('selectbox');
	
	if($current_controller == 'site' && $current_action == 'index') $isMainPage = true;
		else $isMainPage = false;
	
	if($isMainPage) {
		//$cs->registerCoreScript('jcarousel-new-positions');
		$cs->registerCoreScript('jcarousel-products-on-auto');		
	}

?>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
	<?
	/*

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	*/
	?>
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" />
	<?	/*<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />*/	?>
	
	<? /*<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript"></script>	*/?>
	<? /*<script src="<?=Yii::app()->request->baseUrl?>/js/jquery.2.0.3.min.js" type="text/javascript"></script>	*/?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="wrapper">
	<div class="wrapperPage">
<? //echo $current_controller ?>
		<header class="header">
			<div class="top-line">
				<div class="width-wrap">
					<div class="main-menu floatLeft">

						<?php $this->widget('zii.widgets.CMenu',array(
							'items'=>array(

								array('label'=>'Главная', 'url'=>(Yii::app()->homeUrl), 'itemOptions'=> $isMainPage ? array('class'=>'active') : array()),
								//array('label'=>'тест', 'url'=>array('/pages/view', 'id'=> 1)),
								array('label'=>'Доставка', 'url'=>array('/pages/delivery')),
								array('label'=>'Оплата', 'url'=>array('/pages/payment')),
								array('label'=>'Гарантия', 'url'=>array('/pages/guarantee')),
								array('label'=>'Контакты', 'url'=>array('/pages/contacts')),
								array('label'=>'О нас', 'url'=>array('/pages/about'), 'itemOptions'=>array('class'=>'last-item')),
								//array('label'=>'Отзывы', 'url'=>array('/site/feedback'), 'itemOptions'=>array('class'=>'last-item'),),
							),'htmlOptions' => array('class'=>'main-menu clearfix', 'id'=>'main-menu')
						)); ?>
					</div>
					<? /* <a href="http://turbo/admin.php">Адм</a> */ ?>
				
					<?php //$this->widget('application.components.MsiLogin'); ?>
					<?php $this->widget('application.components.CartWidget'); ?>
				</div>
			</div>
			
			<div class="header-block width-wrap clearfix">
				<div class="block1 floatLeft">
					<a href="/" class="logo-top white-color uppercase font-size-13">
						<img src="/img/logo-top.png" alt="магазин автомобильных запчастей" />
						магазин автомобильных запчастей
					</a>
					<?php $this->widget('application.components.SearchWidget'); ?>
				</div>
				<div class="block2 floatRight">
					<?php $this->widget('application.components.ContactsWidget'); ?>
					<?php $this->widget('application.components.ConsultantWidget'); ?>					
				</div>
			
				<?php //$this->widget('application.components.CurrencyWidget'); ?>
			
			</div>
		</header>

		<div class="middle">
			<div class="width-wrap">
			
				<?php $this->widget('application.components.SearchAutoWidget'); ?>
				<div class="central clearfix"><?php echo $content; ?></div>
				<div class="content-down">

				</div>
			</div>
		</div>
	</div>
	
	<footer class="footer">
		<div class="width-wrap clearfix">
			<div class="ur-data">
				<p class="footer-hdr">Юридические данные</p>
				<p class="txt">
					ИП Коленко Виталий Викторович<br>
					УНП 591400676<br>
					Свидетельство №0280855 от 14.01.2011 г. Волковыск<br>
					Зарегистрирован в Торговом реестре 05.11.2012 г.
				</p>
				
				<p class="copyright">
					© 2012-<?php echo date('Y'); ?> <span class="site-name">S-TURBO.BY</span><br>
					<a href="#" class="copyright-note">Контент защищается от копирования технически и юридически</a>
				</p>
			</div>
		
			<div class="contacts">
				<p class="footer-hdr">Контакты</p>
				
				<p class="phones phones-mts"><img src="/img/ico-mts.jpg" alt=""> +375 29 530 22 99</p>
				<p class="phones phones-vel"><img src="/img/ico-velcom.png" alt="">+375 44 530 22 99</p>
				<p class="email"><img src="/img/ico-email.png" alt="">info@s-turbo.by</p>
			</div>

			<div class="contacts">
				<p class="footer-hdr">Звоните</p>
				<p class="txt">
					с 9.00 до 22.00 БЕЗ ВЫХОДНЫХ<br>
					Заказы на сайте через корзину - КРУГЛОСУТОЧНО
				</p>
			</div>
			<?/*
			<div class="contacts">
				<p class="footer-hdr">Контакты</p>
				<p class="email">E-mail: info@s-turbo.by</p>
				<p class="phones">Отдел продаж: <br>+375 29 530 22 99 <br>+375 44 530 22 99</p>
				<p class="adress">Мы находимся: <br>г. Минск, АвтоМолл "Кольцо", <br>2-ой этаж, 417 павильон</p>
				<p class="copyright">© <?php echo date('Y'); ?> <span class="site-name">S-TURBO.BY</span> Республика Беларусь</p>
			</div>

			<div class="ur-data">
				<p class="footer-hdr">Юридические данные</p>
				<p class="txt">220089 г. Минск ул. Гурского 37, офис 5Н, <br>комната 18/23</p>
				<p class="txt">
					р/с 3012162108013 в Региональной дирекции №700<br>
					ОАО «БПС-Сбербанк» 220035, г. Минск, пр-т Машерова, 80, код 369<br>
					УНП 192025656
				</p>
				<p class="txt">
					Директор Ксензов Евгений Олегович<br>
					Дата регистрации в торговом реестре - 07.08.2013г.	
				</p>
			</div>
			<div class="our-shop">
				<p class="footer-hdr uppercase">Наш магазин</p>
				<a href="#" class="view-map"><img src="/images/map.jpg" alt="Наш магазин" /></a>
			</div>
			*/?>
			
			
 		</div>
 		<div class="db-stat" style="display:none;"><? print_r(Yii::app()->db->getStats()); ?></div>
	</footer>
	
	<div id="popup-gallery" class="popup-gallery pos-abs hidden"></div>

</div>

</body>
</html>
