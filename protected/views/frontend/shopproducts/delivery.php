<?php

?>



<div class="product-delivery">
	<h1>Стоимость доставки</h1>
	
	<div class="product-delivery-product-cnt">
		<div class="product-delivery-product-img">
			<img src="<?= $app->params->product_images_liveUrl . 'thumb_'.$model->product_image ?>" alt="">
		</div>
		<div class="product-delivery-product-info">
			<p class="name"><?= $model->product_name ?></p>
			<p class="model"><?= $modelinfoTxt ?></p>
		</div>
	</div>
	<div class="product-delivery-list-cnt">
		<?php foreach($delivery_list as $row)	{	?>
			<div class="delivery-item cart-block-border">
				<div class="delivery-item-cnt cart-block-border-cnt">
					<img alt="" src="<?= $row->ico ?>" style="width: 40px; height: 40px;">
					<div class="cart-block-border-ttl"><?= $row->name ?></div>

					<?php if($row->delivery_free === true)	{	?>
						<p class="c_d70000">БЕСПЛАТНО</p>
					<?php	}	elseif($row->delivery_quick > 0)	{	?>
						<p class="c_d70000">
							<?php
								$deliveryNormal = false;
								$deliveryQuick = false;
								if($delivery_quick == 0 && $delivery_id == $row->id) {
									$deliveryNormal = true;
								} elseif($delivery_quick == 1 && $delivery_id == $row->id) {
									$deliveryQuick = true;
								}
							?>

							<label><?= PriceHelper::formatPrice($row->delivery_normal, 3, 3, $currency_info, true) ?></label>
						</p>
						<p><?= $row->delivery_normal_lbl ?></p>

						<p class="c_d70000 delivery-quick">
							<label><?= PriceHelper::formatPrice($row->delivery_quick, 3, 3, $currency_info, true) ?></label>
						</p>
						<p><?= $row->delivery_quick_lbl ?></p>
					<?php	}	else	{	?>
						<p class="c_d70000"><?= PriceHelper::formatPrice($row->delivery_normal, 3, 3, $currency_info, true) ?></p>
						<p><?= $row->delivery_normal_lbl ?></p>
						<?php if($row->delivery_quick > 0)	{	?>
							<p class="c_d70000 delivery-quick"><?= PriceHelper::formatPrice($row->delivery_quick, 3, 3, $currency_info, true) ?></p>
							<p><?= $row->delivery_quick_lbl ?></p>
						<?php	}	?>
					<?php	}	?>
				</div>
			</div>
		<?php 	}	?>
	</div>
</div>


<script type="text/javascript">
$(document).ready(function () {
	'use strict';
	var max_height = 0;
	
	$('.delivery-item-cnt').each(function(){
		if($(this).height() > max_height)
			max_height = $(this).height();
	});

	$('.delivery-item-cnt').css('height', max_height);
});
</script>