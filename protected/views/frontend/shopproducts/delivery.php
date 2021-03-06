<?php

?>

<div class="product-delivery">
	<h1>Стоимость доставки</h1>
	
	<div class="product-delivery-product-cnt">
		<div class="product-delivery-product-img">
			<img src="<?= (($product_images_liveUrl != '') ? ($product_images_liveUrl . 'thumb_')  : '') .$model->product_image ?>" alt="">
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
					<img alt="" src="<?= $row->ico ?>" style="height: 40px;">
					<div class="cart-block-border-ttl"><?= $row->name ?></div>

					<?php if($row->delivery_free === true)	{	?>
						<p style="color:green;">БЕСПЛАТНО</p>
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
					<?php	}	elseif($row->delivery_normal > 0)	{	?>
						<p class="c_d70000"><?= PriceHelper::formatPrice($row->delivery_normal, 3, 3, $currency_info, true) ?></p>
						<p><?= $row->delivery_normal_lbl ?></p>
						<?php if($row->delivery_quick > 0)	{	?>
							<p class="c_d70000 delivery-quick"><?= PriceHelper::formatPrice($row->delivery_quick, 3, 3, $currency_info, true) ?></p>
							<p><?= $row->delivery_quick_lbl ?></p>
						<?php	}	?>
					<?php	}	else	{	?>
						<p class="c_d70000">НЕ ДОСТАВЛЯЕМ</p>
					<?php	}	?>
				</div>
			</div>
		<?php 	}	?>
	</div>
</div>