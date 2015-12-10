<?php
class PriceHelper
{
    public static function formatPrice($price = 0, $price_currency = 0, $currency_id = 0, $currency_info = null, $ceil_price = false, $unformatted = false)
    { 
        if(is_null($currency_info)) $currency_info = Currencies::model()->loadCurrenciesList();
		
		//echo'<pre>';print_r($currency_info);echo'</pre>';die;
		
		if($currency_id == 0)
			$currency_id = 1;
		
		if($price_currency != 0)
			$price = $price / $currency_info[$price_currency]['currency_value'];
		
		$price = $price * $currency_info[$currency_id]['currency_value'];
		
		if( $currency_id == 3 && $ceil_price == true) $price = self::ceilPrice($price);	//если выводим в BYR - округляем
		
		if($unformatted == true) return number_format(($price), $currency_info[$currency_id]['precision'], '.', '');;
		
		$price = number_format(($price), $currency_info[$currency_id]['precision'], '.', ' ');
		
		$price .= $currency_info[$currency_id]['currency_code'];
		
		return $price;
    }
		
    public static function ceilPrice($price, $ceil_value = 5000)
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
	
	public static function calculateTotalInCart($positions, $currency_info, $to_currency = 3)
	{
		$summ = 0;
		$qty = $qtyTotal = 0;
		
		foreach($positions as $position) {
			$price = self::getPricePosition($position);
			$qty = $position->getQuantity();
			$qtyTotal = $qtyTotal + $qty;
			$summ += $qty * self::formatPrice($price, $position->currency_id, $to_currency, $currency_info, true, true);
		}
		
		$res = array(
			'summ' => $summ,
			'qtyTotal' => $qtyTotal,
		);
		return $res;
	}
	
	public static function calculateSummOfPosition($position, $currency_info, $to_currency = 3)
	{
		$price = self::getPricePosition($position);
		$qty = $position->getQuantity();
		
		//echo'<pre>';print_r($price . ' | ' . $position->currency_id);echo'</pre>';//die;
		
		if($to_currency == 3) $ceil_price = true;
			else $ceil_price = false;
		
		return $qty * self::formatPrice($price, $position->currency_id, $to_currency, $currency_info, $ceil_price, true);
	}
	
	public static function getPricePosition($position)
	{
		if($position->product_override_price > 0) $price = $position->product_override_price;
			else $price = $position->product_price;
		
		return $price;
		
	}
}


/*

25 евро
нужно вывести в usd
25 / 0.8772 * 1 = 28.50

25 / 0.8772 * 18000 = 

*/

