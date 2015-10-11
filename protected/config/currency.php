<?php
return array(
	'params'=>array(
		'usd_rate' => 18000,		// курс USD
		
		'currency' => array(
			1 => array (				// курс USD
				'char_code' => ' у.е.',
				'rate' => 1,
				'precision'	=> 1,
				'adm_code' => '$',
			),

			2 => array (				// курс EUR к USD
				'char_code' => ' EUR',
				'rate' => 0.8772,
				'precision'	=> 1,
				'adm_code' => '€',
			),

			3 => array (				// курс BYR к USD
				'char_code' => '',
				'rate' => 18000,
				'precision'	=> 0,
				'adm_code' => 'р',
			),
		),
	),	
)
	
?>