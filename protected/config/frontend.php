<?php
return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),
	require_once(dirname(__FILE__).'/currency.php'),
    
    array(
        
        
        // стандартный контроллер
        //'defaultController' => 'catalogcategories',
        
        // компоненты
        'components'=>array(


			// uncomment the following to enable URLs in path-format
			
			'urlManager'=>array(
				'class'=>'UrlManager',
				'showScriptName'=>false,
				'urlFormat'=>'path',
				'urlSuffix' => '.html',
				'rules'=>array(
					'<_action:(companies|contact|feedback)>'=>'site/<_action>',
					'oplata-i-dostavka'=>'site/oplataidostavka',
					//'companyes'=>'companies/index',
					
					//'shop/<path:.+>'=>'/shopcategories/show',

					//'addtocart'=>'cart/addtocart',
					//'showcart'=>'cart/showcart',
					'<path:.+cart>'=>'cart/<path>',
					//'<path:.+-detail>'=>'shopproducts/detail',
					'product/<product>'=>'shopproducts/detail',
					'category/index'=>'shopcategories/index',
					'category<id:.+>/type<type:.+>'=>'shopcategories/show',
					'category<id:.+>/body<body:.+>'=>'shopcategories/show',
					'category<id:.+>/firm<firm:.+>'=>'shopcategories/show',
					'category<id:.+>/engine<engine:.+>'=>'shopcategories/show',
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