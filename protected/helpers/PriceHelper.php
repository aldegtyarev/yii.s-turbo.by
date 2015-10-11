<?php
class PriceHelper
{
    public static function formatPrice($price = 0, $price_currency = 0, $currency_id = 0)
    { 
        if($currency_id == 0)
			$currency_id = 1;
		
		if($price_currency != 0)
			$price = $price / Yii::app()->params->currency[$price_currency]['rate'];
		
		$price = $price * Yii::app()->params->currency[$currency_id]['rate'];
		
		if( $currency_id == 3) $price = self::ceilPrice($price);	//если выводим в BYR - округляем
		
		$price = number_format(($price), Yii::app()->params->currency[$currency_id]['precision'], '.', ' ');
		
		$price .= Yii::app()->params->currency[$currency_id]['char_code'];
		
		return $price;
    }
	
    public static function ceilPrice($price, $ceil_value = 10000)
    { 
		return (ceil($price / $ceil_value)) * $ceil_value;
    }
	
    public static function roundValue($value = 0)
    { 
		/*
$var=101;
$res=(ceil($var/100))*100;
echo "$res";		
*/
		$precision = -3;
		return round($value, $precision);
    }
}


/*

25 евро
нужно вывести в usd
25 / 0.8772 * 1 = 28.50

25 / 0.8772 * 18000 = 

*/

