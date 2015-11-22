<?php
class PriceHelper
{
    public static function formatPrice($price = 0, $price_currency = 0, $currency_id = 0, $currency_info = null, $ceil_price = false)
    { 
        if(is_null($currency_info)) $currency_info = Currencies::model()->loadCurrenciesList();
		
		//echo'<pre>';print_r($currency_info);echo'</pre>';die;
		
		if($currency_id == 0)
			$currency_id = 1;
		
		if($price_currency != 0)
			$price = $price / $currency_info[$price_currency]['currency_value'];
		
		$price = $price * $currency_info[$currency_id]['currency_value'];
		
		if( $currency_id == 3 && $ceil_price == true) $price = self::ceilPrice($price);	//если выводим в BYR - округляем
		
		$price = number_format(($price), $currency_info[$currency_id]['precision'], '.', ' ');
		
		$price .= $currency_info[$currency_id]['currency_code'];
		
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

