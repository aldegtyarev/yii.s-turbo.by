<?php
return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),
    
    array(
        
        
        // стандартный контроллер
        //'defaultController' => 'catalogcategories',
        
        // компоненты
        'components'=>array(
			// uncomment the following to enable URLs in path-format
/*
			'urlManager'=>array(
				'class'=>'UrlManager',
				'showScriptName'=>false,
				'urlFormat'=>'path',
				'urlSuffix' => '.html',
				'rules'=>array(
					//'shop/<path:.+>'=>'/shopcategories/show',

					//'addtocart'=>'cart/addtocart',
					//'showcart'=>'cart/showcart',
					'<path:.+cart>'=>'cart/<path>',
					'<path:.+-detail>'=>'shopproducts/detail',
					'<path:.+>'=>'shopcategories/show',
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

        ),
    )
);
?>