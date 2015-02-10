<?php
return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),
    
    array(
        // стандартный контроллер
        //'defaultController' => 'catalogitems',
        
        // компоненты
        'components'=>array(
            
            // пользователь
            'user'=>array(
                'loginUrl'=>array('/site/login'),
            ),
			

			// mailer
			'mailer'	=>	array	(
										'pathViews' => 'application.views.backend.email',
										'pathLayouts' => 'application.views.email.backend.layouts'
									),
			
			'image'	=>	array	(
									'class'=>'application.extensions.image.CImageComponent',
									// GD or ImageMagick
									'driver'=>'GD',
									// ImageMagick setup path
									'params'=>array('directory'=>'/opt/local/bin'),
								),
			

        ),
		
		'params'=>array	(
			'pageSize' => 25,
			'selectPageCount' => array(
				'20' => '25',
				'30' => '30',
				'50' => '75',
				'100' => '100',
				'500' => '500',
				'1000000' => 'Все',
			),		
		),		
    )
);
?>