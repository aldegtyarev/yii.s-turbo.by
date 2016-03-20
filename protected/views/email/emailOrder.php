<? /** @var dpsEmailController $this */
//$this->setLayout( 'emailLayoutTpl' ); // какой макет
//$this->attach( $sFilePath ); // приложим файлик
$params = $app->params;

$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
$total_summ = $total_in_cart['summ'] + $delivery_cost;

$this->setSubject( $app->name . ' заказ №'.$order->id. ' на сумму '. PriceHelper::formatPrice($total_summ, 3, 3, $currency_info, true) . ' принят в обработку' ); // указываем тему

$td_style = 'style="padding:10px;"';
?>
<div style="width:765px;">

	<div style="width:355px;margin-bottom:40px;">
		<img src="<?= $app->getBaseUrl(true)?>/img/logo-email.png" alt="s-turbo.by" style="">
		<span style="display:block;text-align:center;font-style:italic;font-weight:bold;font-family:Tahoma;font-size:14px;color:#747474;"><?= $app->params['siteSlogan'] ?></span>
	</div>

	<p style="font-family:Arial, sans-serif;">Здравствуйте, <?= $model->fio ?>.</p>
	<p style="font-family:Arial, sans-serif">Ваш заказ № <span style="color:#d70000"><?= $order->id ?></span> от <?= $app->dateFormatter->format('d MMMM yyyy', $order->created);?> на сумму <span style="color:#d70000"><?=PriceHelper::formatPrice($total_summ, 3, 3, $currency_info, true)?></span> получен и поступил в обработку.</p>
	<p style="font-family:Arial, sans-serif">В ближайшее время с Вами свяжется наш менеджер.</p>


	<br>
	<br>

	<h3 style="font-family:Arial, sans-serif;font-weight:bold;color:#9F9F9F;text-transform:uppercase;">Данные о покупателе</h3>

	<table>
		<tbody>
			<?php 
				foreach($customer as $attr=>$val)	{
					if($attr == 'type' && $val == Orders::CUSTOMER_TYPE_UR) {	?>
						<tr>
							<td style="vertical-align:top;padding:5px 10px 5px 0;font-family:Arial, sans-serif;color:#000;font-size:14px;font-weight:bold;" colspan="2">ДАННЫЕ ОРГАНИЗАЦИИ</td>
						</tr>
					<?php }	?>					
					<?php if($val != '' && $attr != 'type') {	?>
						<tr>
							<td style="vertical-align:top;padding:5px 10px 5px 0;font-family:Arial, sans-serif;"><?= $model->getAttributeLabel($attr) ?></td>
							<td style="vertical-align:top;padding:5px 10px;font-family:Arial, sans-serif;font-weight:bold"><?= nl2br($val) ?></td>
						</tr>

					<?php }	?>
					<?php if($attr == 'phone1_ur') {	?>
						<tr>
							<td style="vertical-align:top;padding:5px 10px 5px 0;font-family:Arial, sans-serif;color:#000;font-size:14px;font-weight:bold;" colspan="2"><br>КОНТАКТНОЕ ЛИЦО</td>
						</tr>
					<?php }	?>					
				<?php }	?>					

		</tbody>
	</table>
	<br>
	<br>


	<h3 style="font-family:Arial, sans-serif;font-weight:bold;color:#9F9F9F;text-transform:uppercase;">Список товаров</h3>

	<table style="width:100%;">
		<thead>
			<tr>
				<th style="text-align:center;padding:10px 10px 15px 10px;border-bottom:1px solid #f5f5f5;"></th>
				<th style="text-align:left;padding:10px 10px 15px 10px;border-bottom:1px solid #f5f5f5;font-size:12px;font-family:Tahoma, Verdana, sans-serif;">Описание товара</th>
				<th style="text-align:center;padding:10px 10px 15px 10px;border-bottom:1px solid #f5f5f5;font-size:12px;font-family:Tahoma, Verdana, sans-serif;">Количество</th>
				<th style="text-align:center;padding:10px 10px 15px 10px;border-bottom:1px solid #f5f5f5;font-size:12px;font-family:Tahoma, Verdana, sans-serif;">Сумма</th>
			</tr>
		</thead>

		<tbody>
			<?	foreach($positions as $product) {	?>
				<? 				//echo'$modelinfo<pre>';print_r($product);echo'</pre>';die;?>
				<? $product_url = $app->getBaseUrl(true) . $this->createUrl('shopproducts/detail', array('product'=> $product->product_id)); ?>
				<tr>
					<td style="padding:10px 10px 10px 0;" >
						<? 
							if ($product->product_image) {
								echo CHtml::link(CHtml::image($app->getBaseUrl(true) . $params->product_images_liveUrl . 'thumb_'.$product->product_image, $product->product_name, array('style' => "border-radius:4px;width:115px;")), $product->product_url, array('title'=>$product->product_name));
							}	else	{
								echo CHtml::link(CHtml::image($app->getBaseUrl(true) . $params->product_images_liveUrl . 'noimage.jpg', "", array('style' => "border-radius:4px;width:115px;")), $product->product_url, array());											
							}	
						?>									
					</td>
					<td <?=$td_style?> >
						<? echo CHtml::link($product->product_name, ($app->getBaseUrl(true) . $product->product_url), array('title' => $product->product_name, 'style'=>'font-weight:bold;color:#000;font-family:Tahoma, Verdana, sans-serif;')); ?>
						<p style="font-size:10px;color:#000;font-family:Tahoma, Verdana, sans-serif;"><?php echo $product->cart_model_info ?></p>
					</td>

					<td style="padding:10px;text-align:center;font-family:Tahoma, Verdana, sans-serif;" >
						<?php echo CHtml::textField('quantity', $product->getQuantity(), array( 'disabled'=>"disabled", 'style'=>'text-align:center;width:40px;padding:7px;font-family:Tahoma, Verdana, sans-serif;')); ?>
					</td>

					<td <?=$td_style?> >
						<? //$product_price = $product->getSumPrice(); ?>
						<p style="font-size:16px;font-weight:bold;color:#d70000;font-family:Tahoma, Verdana, sans-serif;white-space:nowrap;"><?= PriceHelper::formatPrice((PriceHelper::calculateSummOfPosition($product, $currency_info)), 3, 3, $currency_info, true)?></p>
					</td>
				</tr>

			<?	}	?>
			<tr>
				<td colspan="3"></td>
				<td <?=$td_style?> >
					<p style="font-weight:bold;margin-bottom:10px;font-family:Tahoma, Verdana, sans-serif;">Итого c доставкой</p>
					<p style="font-size:16px;font-weight:bold;color:#d70000;font-family:Tahoma, Verdana, sans-serif;margin:0;white-space:nowrap;"><?=PriceHelper::formatPrice($total_summ, 3, 3, $currency_info, true)?></p>
				</td>
			</tr>

		</tbody>
	</table>
	<table style="width:100%;">	
		<tbody>
			<tr>
				<td style="padding:10px 10px 10px 0;" >Способ доставки</td>
				<td style="padding:10px 10px 10px 0;font-weight:bold;"><?= $delivery_name ?></td>
			</tr>
			<tr>
				<td style="padding:10px 10px 10px 0;" >Способ оплаты</td>
				<td style="padding:10px 10px 10px 0;font-weight:bold;"><?= $payment_name ?></td>
			</tr>
		</tbody>
	</table>

	<br>
	<br>

	<p style="font-family:Arial, sans-serif;">Спасибо за покупки на <a href="<?= $app->getBaseUrl(true)?>"><?= $app->name ?></a></p>
	<p style="font-family:Arial, sans-serif;line-height:22px;">
		<img src="<?= $app->getBaseUrl(true) ?>/img/ico-mts.jpg" alt="мтс" style="width:17px;margin-right:3px;">+ 375 29 530 22 99<br>
		<img src="<?= $app->getBaseUrl(true) ?>/img/ico-velcom.png" alt="велком" style="width:17px;margin-right:3px;">+ 375 44 530 22 99<br>
		<img src="<?= $app->getBaseUrl(true) ?>/img/email-ico1.png" alt="email" style="width:17px;margin-right:3px;"><a href="mailto:info@s-turbo.by">info@s-turbo.by</a>
	</p>
</div>
