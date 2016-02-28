<?php
return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),
	require_once(dirname(__FILE__).'/currency.php'),
    
    array(
        
        
        // стандартный контроллер
        //'defaultController' => 'catalogcategories',
        
        // компоненты
        'components'=>array(
			'session' => array(
				'class' => 'system.web.CHttpSession',
				//'sessionName' => 'SID',
				'timeout' => 60 * 24 * 30,
//				'cookieParams' => array (
//					'lifetime' => 31536000,
//					'path' => '/',
//					'httponly' => 'on',
//				),
			),
			
			
			// uncomment the following to enable URLs in path-format
			
			'urlManager'=>array(
				'class'=>'UrlManager',
				'showScriptName'=>false,
				'urlFormat'=>'path',
				'urlSuffix' => '.html',
				'rules'=>array(
					'<_action:(news|our)>/<alias:.+>'=>'pages/<_action>',
					'<_action:(dostavka|oplata|garantiya|kontakty|onas|townslist|news|our)>'=>'pages/<_action>',
					'<_action:(backcall)>'=>'site/<_action>',
					
					
					'korzina'=>'cart/showcart',
					'<path:.+cart>'=>'cart/<path>',

					'<_action:(lastviewed)>'=>'shopproducts/<_action>',
					'product/buyoneclick'=>'shopproducts/buyoneclick',
					'product/dostavka/<id:.+>'=>'shopproducts/delivery',
					
					
					'product/marka<marka:.+>/model<model:.+>/year<year:.+>/<product:.+>'=>'shopproducts/detail',
					'product/<uni:.+>/<product:.+>'=>'shopproducts/detail',
					//'product/<product>'=>'shopproducts/detail',
					
					'category/marka<marka:.+>/model<model:.+>/year<year:.+>'=>'shopcategories/index',
					
					'category<id:.+>/marka<marka:.+>/model<model:.+>/year<year:.+>/type<type:.+>'=>'shopcategories/show',
					'category<id:.+>/marka<marka:.+>/model<model:.+>/year<year:.+>/engine<engine:.+>'=>'shopcategories/show',
					'category<id:.+>/marka<marka:.+>/model<model:.+>/year<year:.+>/bodyset<bodyset:.+>'=>'shopcategories/show',
					'category<id:.+>/marka<marka:.+>/model<model:.+>/year<year:.+>'=>'shopcategories/show',
					
					'category/index'=>'shopcategories/index',
					
					'category<id:.+>/type<type:.+>'=>'shopcategories/show',
					'category<id:.+>'=>'shopcategories/show',
					
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
			),
			/**/


			// mailer
			'mailer'=>array(
				'pathViews' => 'application.views.backend.email',
				'pathLayouts' => 'application.views.email.backend.layouts'
			),
			
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning',
					),
					// uncomment the following to show log messages on web pages
					/*
					array(
						'class'=>'CWebLogRoute',
					),
					/**/
				),
			),
			

        ),
    )
);
?>