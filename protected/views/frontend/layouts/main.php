<?php /* @var $this Controller */ ?>
<?/*<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">*/?>
<!DOCTYPE html>

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
	$cs->registerCoreScript('fancybox');
	$cs->registerCoreScript('formstyler');
	$cs->registerCoreScript('phone-input');
	$cs->registerCoreScript('jquery-history');

	//$cs->registerCoreScript('fancybox');
	//$cs->registerCoreScript('selectbox');
	
	if($current_controller == 'site' && $current_action == 'index') $isMainPage = true;
		else $isMainPage = false;
	
//	if($isMainPage) {
//		//$cs->registerCoreScript('jcarousel-new-positions');
//		$cs->registerCoreScript('jcarousel-products-on-auto');
//	}
	
	/*
	if($isMainPage == false) {
		$js = "
		var scroll_el = $('#search-auto-block');
		if ($(scroll_el).length != 0) {
			$('html, body').animate({ scrollTop: scroll_el.offset().top }, 900);
		}";
		$app->clientScript->registerScript('scroll_to', $js, CClientScript::POS_READY);
		
	}
	*/

//$cs->registerLinkTag('apple-touch-icon', NULL, '/favicons/apple-touch-icon-57x57.png', NULL, array('sizes'=>'57x57'));

?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="ru">
	<link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicons/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/favicons/manifest.json">
	<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="/favicons/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="/favicons/mstile-144x144.png">
	<meta name="msapplication-config" content="/favicons/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<meta name="yandex-verification" content="68c1bd58dd5319ee">
	<link rel="stylesheet" type="text/css" href="<?php echo $app->request->baseUrl; ?>/css/screen.css" />

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
								array('label'=>'Главная', 'url'=>($app->homeUrl), 'itemOptions'=> $isMainPage ? array('class'=>'active') : array()),
								array('label'=>'Доставка', 'url'=>array('/pages/dostavka')),
								array('label'=>'Оплата', 'url'=>array('/pages/oplata')),
								array('label'=>'Гарантия', 'url'=>array('/pages/garantiya')),
								array('label'=>'Контакты', 'url'=>array('/pages/kontakty')),
								array('label'=>'О нас', 'url'=>array('/pages/onas'), 'itemOptions'=>array('class'=>'last-item')),
							),'htmlOptions' => array('class'=>'main-menu clearfix', 'id'=>'main-menu')
						)); ?>
					</div>
				
					<div id="cartBlock-cnt" class="pos-rel floatRight"><?php $this->widget('application.components.CartWidget'); ?></div>
				</div>
			</div>
			
			<div class="header-block width-wrap clearfix">
				<div class="block1 floatLeft">
					<a href="/" class="logo-top white-color uppercase font-size-13">
						<img src="/img/logo-top.png" alt="магазин автомобильных запчастей" />
						<?= $app->params['siteSlogan'] ?>
					</a>
					<?php //$this->widget('application.components.SearchWidget'); ?>
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
				<div id="central-cnt" class="central clearfix"><?php echo $content; ?></div>
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
				<p class="email"><img src="/img/ico-email.png" alt=""><a href="mailto:info@s-turbo.by">info@s-turbo.by</a></p>
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
 		<div class="db-stat" style="display:none;"><? print_r($app->db->getStats()); ?></div>
	</footer>
	
	<div id="popup-gallery" class="popup-gallery pos-abs hidden"></div>

</div>
	<span id="gotop" class="scrollTop" onclick="top.goTop(); return false;" style="display:none;"></span>
	<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
	
	<script type="text/javascript" src="http://consultsystems.ru/script/30888/" charset="utf-8"></script>
<?/*
<!-- Yandex.Metrika counter -->
<script>
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter34557575 = new Ya.Metrika({
                    id:34557575,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/34557575" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
*/?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
	(function (d, w, c) {
		(w[c] = w[c] || []).push(function() {
			try {
				w.yaCounter24091183 = new Ya.Metrika({id:24091183,
					clickmap:true,
					trackLinks:true,
					accurateTrackBounce:true});
			} catch(e) { }
		});

		var n = d.getElementsByTagName("script")[0],
			s = d.createElement("script"),
			f = function () { n.parentNode.insertBefore(s, n); };
		s.type = "text/javascript";
		s.async = true;
		s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

		if (w.opera == "[object Opera]") {
			d.addEventListener("DOMContentLoaded", f, false);
		} else { f(); }
	})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/24091183" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

	
	
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-73715533-1', 'auto');
  ga('send', 'pageview');
</script>

</body>
</html>
