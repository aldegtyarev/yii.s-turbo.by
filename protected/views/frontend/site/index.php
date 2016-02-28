<?php
/* @var $this SiteController */

$app = Yii::app();

$this->pageTitle = $app->name;

$clientScript = $app->clientScript;
$clientScript->registerCoreScript('fancybox');


?>


<?php //$this->widget('application.components.NewProductsWidget'); ?>

<style>
	.fancybox-wrap {/*top:50px !important;*/max-width:800px !important;}
	.fancybox-inner {max-width:760px !important;}
</style>
<div class="advantages">
	<p class="advantages-title">Наши преимущества</p>
	<div class="advantages-row">
		<div class="advantages-item advantages-item-1">
			<div class="advantages-item-cnt">
				<div class="advantages-item-sdesc-cnt">
					<p class="advantages-item-title"><span class="cifra">1</span><span class="n-news">Лучшие цены</span></p>
					<div class="advantages-item-sdesc">
						<?/*<p>Цены ниже<br>среднерыночных</p>*/?>
						<p>Мы предлагаем самые<br>конкурентные цены</p>
						<img src="/img/advantages-1.png" alt="Лучшие цены" class="advantages-item-img advantages-item-img-1">
						
					</div>
					<a href="#adv-item-1" class="advantages-item-detail fancybox1"><span>Подробнее</span></a>
				</div>
				<div id="adv-item-1" class="advantages-item-popup" style="display:none; width:600px;">					
					<p class="advantages-item-popup-title">Лучшие цены</p>
					<ul>
						<li>Мы постоянно следим за ценами и стремимся сделать для Вас лучшее предложение!</li>
						<li>Наши цены ниже среднерыночных,  так как запасные части мы покупаем у производителей и официальных дилеров оптом.</li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="advantages-item advantages-item-2">
			<div class="advantages-item-cnt">
				<div class="advantages-item-sdesc-cnt">
					<p class="advantages-item-title"><span class="cifra">2</span><span class="n-news">Доставка по всей Беларуси</span></p>
					<div class="advantages-item-sdesc">
						<p>Доставляем товар в течении<br>2-3 дней</p>
						<p class="small">
							- курьерской службой<br>
							- почтовым отправлением<br>
							- самовывоз<br>
						</p>
						<img src="/img/advantages-2.png" alt="Доставка по всей Беларуси" class="advantages-item-img advantages-item-img-2">
						
					</div>
					<a href="<?= $this->createUrl('pages/dostavka')?>" class="advantages-item-detail modal-url fancybox1 fancybox.ajax"><span>Подробнее</span></a>
				</div>
			</div>
		</div>
				
		<div class="advantages-item advantages-item-3">
			<div class="advantages-item-cnt">
				<div class="advantages-item-sdesc-cnt">
					<p class="advantages-item-title"><span class="cifra">3</span><span class="n-news">Удобная оплата</span></p>
					<div class="advantages-item-sdesc">
						<p class="small">
							- курьеру при получении<br>
							- на почте при получении<br>
							- через кассу банка<br>
							- безналичный расчет (для юридических лиц)<br>
						</p>
						<img src="/img/advantages-3.png" alt="Удобная оплата" class="advantages-item-img advantages-item-img-3">
						
					</div>
					<a href="<?= $this->createUrl('pages/oplata')?>" class="advantages-item-detail modal-url fancybox1 fancybox.ajax"><span>Подробнее</span></a>
				</div>
			</div>
		</div>
		
		<div class="advantages-item advantages-item-4">
			<div class="advantages-item-cnt">
				<div class="advantages-item-sdesc-cnt">
					<p class="advantages-item-title"><span class="cifra">4</span><span class="n-news">Гарантия и возврат</span></p>
					<div class="advantages-item-sdesc">
						<p>Все наши товары соответствуют<br>стандартам как международным,<br>так и национальным требованиям качества</p>
						<p class="small" style="padding-top:5px;">
							- обмен / возврат в течении 14 дней<br>
						</p>
						<img src="/img/advantages-4.png" alt="Гарантия и возврат" class="advantages-item-img advantages-item-img-4">
						
					</div>
					<a href="<?= $this->createUrl('pages/garantiya')?>" class="advantages-item-detail modal-url fancybox1 fancybox.ajax"><span>Подробнее</span></a>
				</div>
			</div>
		</div>
		
		
	</div>
</div>
<?php if($this->beginCache($id, array('duration'=>$app->params['cache_duration']))) { ?>
	<?php $this->widget('application.components.NewsWidget', array('type' => 2)); ?>

	<?php $this->widget('application.components.NewsWidget', array('type' => 3)); ?>
<?php $this->endCache(); } ?>
<?/*
<div class="news-block clearfix">

		<div class="header-wr">
			<h3 class="uppercase">Новости магазина</h3>
			<a href="#" class="all-items">Все новости магазина</a>			
		</div>
		
		<div class="news-block-body">
			<ul class="clearfix">
				<li class="news-block-item news-block-item-big">
					<div class="news-block-item-wr">
						<img src="<?=$images_live_url?>images/turbo1.jpg" alt="turbo1.jpg" />
						<div class="text-block-container">
							<p class="text-block">
								<span class="created">29.10.2014</span>
								<a href="" class="item-title">Чип-тюнинг бокс OBD - чипуй сам!</a>
							</p>
						</div>
					</div>
				</li>
				<li class="news-block-item news-block-item-big">
					<div class="news-block-item-wr">
						<img src="<?=$images_live_url?>images/turbo1.jpg" alt="turbo1.jpg" />
						<div class="text-block-container">
							<p class="text-block">
								<span class="created">29.10.2014</span>
								<a href="" class="item-title">Чип-тюнинг бокс OBD - чипуй сам!</a>

							</p>
						</div>
					</div>
				</li>
				
				<li class="news-block-item news-block-item-small">
					<div class="news-block-item-wr">
					<img src="<?=$images_live_url?>images/turbo2.jpg" alt="turbo1.jpg" />
					<p class="text-block">
						<span class="created">29.10.2014</span>
						<a href="" class="item-title">Завершена работа по установки переднего бампера RS4 на AUDI A4 B6 от компании S-TURBO.BY </a>
					</p>
					</div>
				</li>
				<li class="news-block-item news-block-item-small">
					<div class="news-block-item-wr">
					<img src="<?=$images_live_url?>images/turbo3.jpg" alt="turbo1.jpg" />
					<p class="text-block">
						<span class="created">29.10.2014</span>
						<a href="" class="item-title">Чип-тюнинг бокс OBD - чипуй сам!</a>						
					</p>
					</div>
				</li>
				<li class="news-block-item news-block-item-small">
					<div class="news-block-item-wr">
					<img src="<?=$images_live_url?>images/turbo1.jpg" alt="turbo1.jpg" />
					<div class="text-block">
						<span class="created">29.10.2014</span>
						<a href="" class="item-title">Чип-тюнинг бокс OBD - чипуй сам!</a>
					</div>
					</div>
				</li>
				<li class="news-block-item news-block-item-small">
					<div class="news-block-item-wr">
					<img src="<?=$images_live_url?>images/turbo3.jpg" alt="turbo1.jpg" />
					<p class="text-block">
						<span class="created">29.10.2014</span>
						<a href="" class="item-title">Чип-тюнинг бокс OBD - чипуй сам!</a>
					</p>
					</div>
				</li>
				
			</ul>
		</div>
</div>
*/?>

<?/*

<div class="products-on-auto news-block">
	<div class="header-wr">
		<h3 class="ptsans-bold uppercase">Наши товары на вашем авто</h3>
		<a href="#" class="all-items">Открыть галерею</a>
	</div>
	<div class="jcarousel-wrapper">
		<div class="jcarousel jcarousel-products-on-auto">
			<ul class="jcarousel products-on-auto-list">
				<li class="products-on-auto-item floatLeft">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>images/turbo1.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo1.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
				<li class="products-on-auto-item floatLeft ">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>images/turbo2.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo2.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
				<li class="products-on-auto-item floatLeft ">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>mages/turbo3.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo3.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
				<li class="products-on-auto-item floatLeft">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>images/turbo1.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo1.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
				<li class="products-on-auto-item floatLeft ">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>images/turbo2.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo2.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
				<li class="products-on-auto-item floatLeft ">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>images/turbo3.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo3.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
			</ul>
		</div>
		<a href="#" class="jcarousel-control-prev jcarousel-products-on-auto-control-prev sprite">‹</a> <a href="#" class="jcarousel-control-next jcarousel-products-on-auto-control-next sprite">›</a>
	</div>

</div>
*/?>


<div class="content-text">
<?/*
	<h3>ИНТЕРНЕТ-МАГАЗИН S-TURBO.BY</h3>
	<p>S-Turbo.BY –  уникальный на белорусском профессиональном пространстве проект с перспективой роста до крупнейшего в РБ портала специалистов и любителей автотюнинга. В отличие от других подобных тюнинг – магазинов, S-Turbo.BY это беспрецедентный проект, который объединяет в себе сразу несколько видов деятельности.</p>
	<p>•    Интернет - магазин тюнинга<br />Это основная и самая важная часть нашей работы. Мы продаем автоаксессуары для тюнинга от лучших мировых  производителей и с каждым днем наш ассортимент неуклонно растет. Наша цель -  обеспечить достойный выбор товаров по каждому наименованию. Поскольку магазин работает без посредников, цены у нас самые лояльные. Мы работаем по всей Беларуси, поэтому нет необходимости искать другие тюнинг - магазины  в Минске или другом городе! Товар будет доставлен нашим курьером прямо к порогу вашего дома в любую точку страны. Также вы сможете посмотреть какие компании оказывают услуги по ремонту авто.</p>
	*/?>

<h3>Добро пожаловать на наш обновленный сайт S-TURBO.BY</h3>

<p>
	На данный момент магазин находится в стадии наполнения товара, если Вы не нашли нужную Вам запчасть, ее наличие и цену уточняйте у наших менеджеров по номерам магазина.
</p>

<p>В нашем интернет-магазине Вы можете приобрести широкий ассортимент кузовных запчастей, тюнинга и автоаксессуаров!</p>

<p><strong>&nbsp;Нашим покупателям мы предлагаем:&nbsp;</strong><br>
- Самые выгодные цены.<br>
- Оперативную доставку в любой населенный пункт Беларуси в течении 2-3 дней.<br>
- Удобный способ оплаты.<br>
- Гибкую систему скидок для постоянных клиентов.</p>

<p>Мы с вниманием относимся к каждому из наших покупателей и всегда готовы рассмотреть любые пожелания и предложения по улучшению нашей работы.<br>
&nbsp;</p>

<p><strong>Будем рады видеть вас в числе наших клиентов!</strong></p>

<p><strong>С уважением, S-TURBO.BY</strong></p>

</div>

<?php $this->widget('application.components.HowItWorkWidget'); ?>