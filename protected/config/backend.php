<?php
return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),
    require_once(dirname(__FILE__).'/currency.php'),
    
    array(
        // стандартный контроллер
        'defaultController' => 'shopcategories',
        //'defaultController' => 'companiescategories',
		
		'aliases' => array(
			'bootstrap' => 'application.modules.bootstrap'
		),
		
		'import' => array(

			'bootstrap.behaviors.*',
			'bootstrap.helpers.*',
			'bootstrap.widgets.*'
		),		
        
        // компоненты
        'components'=>array(
            
            // пользователь
            'user'=>array(
                'loginUrl'=>array('/site/login'),
            ),
			

			// mailer
			'mailer' => array (
				'pathViews' => 'application.views.backend.email',
				'pathLayouts' => 'application.views.email.backend.layouts'
			),
			
			'image' => array (
				'class'=>'application.extensions.image.CImageComponent',
				// GD or ImageMagick
				'driver'=>'GD',
				// ImageMagick setup path
				'params'=>array('directory'=>'/opt/local/bin'),
			),
			
			'bootstrap' => array(
				'class' => 'bootstrap.components.BsApi'
			),
			
			'BsHtml' => array(
				'class' => 'bootstrap.helpers.BsHtml'
			),			
			

        ),
		
		'params'=>array	(
			'product_tmb_params' => array('width' => 220, 'height' => 165),	//параметры для создания миниатюр
			'category_tmb_params' => array('width' => 220, 'height' => 165),	//параметры для создания миниатюр
			'page_tmb_params' => array('width' => 260, 'height' => 195),	//параметры для создания миниатюр
			'pagination' => array(	//параметры для пагинации
				'products_per_page' => 60,
				'models_per_page' => 100,
			),	
			
			'pageSize' => 25,
			'selectPageCount' => array(
				'20' => '25',
				'30' => '30',
				'50' => '75',
				'100' => '100',
				'500' => '500',
				'1000000' => 'Все',
			),

			//проценты для изменения цены товара
			'price_change' => array(
				100 => 'Исходная',
				10 => '+10%',
				7 => '+7%',
				5 => '+5%',
				3 => '+3%',
				0 => 'Без скидки',
				-2 => '-2%',
				-5 => '-5%',
				-7 => '-7%',
				-10 => '-10%',
			),

			//проценты для изменения цены товара для фейковой скидки
			'price_change_fake' => array(
				0 => 'Без скидки',
				-2 => '-2%',
				-5 => '-5%',
				-7 => '-7%',
				-10 => '-10%',
			),
		),
    )
);
?>