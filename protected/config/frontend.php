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
					'<_action:(news|our)>/<alias:.+>'=>'pages/<_action>',
					'<_action:(delivery|payment|guarantee|contacts|about|townslist|news|our)>'=>'pages/<_action>',
					
					//'shop/<path:.+>'=>'/shopcategories/show',
					
					// category4615/marka31/model34/year35.html
					// category4615/marka31/model34/year35/engine110.html
					// category4615/marka31/model34/year35/type9.html
					// category4615/marka31/model34/year35/index.html
					
					
					
					//'addtocart'=>'cart/addtocart',
					//'showcart'=>'cart/showcart',
					'<path:.+cart>'=>'cart/<path>',
					//'<path:.+-detail>'=>'shopproducts/detail',
					'product/buyoneclick'=>'shopproducts/buyoneclick',
					'product/<product>'=>'shopproducts/detail',
					
					'category<id:.+>/marka<marka:.+>/model<model:.+>/year<year:.+>'=>'shopcategories/show',
					
					'category/index'=>'shopcategories/index',
					
					'category<id:.+>/bodyset<bodyset:.+>'=>'shopcategories/show',
					//'category<id:.+>/body<body:.+>'=>'shopcategories/show',
					//'category<id:.+>/firm<firm:.+>'=>'shopcategories/show',
					'category<id:.+>/type<type:.+>'=>'shopcategories/show',
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