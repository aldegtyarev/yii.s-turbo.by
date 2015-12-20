<?php foreach($rows as $row)	{	?>
	<div class="delivery-item cart-block-border">
		<div class="delivery-item-cnt cart-block-border-cnt <?php if($delivery_id == $row->id) echo 'cart-block-border-cnt-selected'; ?>" data-delivery="<?= $row->id ?>">
			<img alt="" src="<?= $row->ico ?>" style="width: 40px; height: 40px;">
			<div class="cart-block-border-ttl"><?= $row->name ?></div>

			<?php if($row->delivery_free === true)	{	?>
				<p class="c_d70000">БЕСПЛАТНО</p>
			<?php	}	elseif($row->delivery_quick > 0)	{	?>
				<p class="c_d70000">
					<?/*<input type="radio" name="delivery_quick[<?= $row->id ?>]" id="delivery-normal-<?= $row->id ?>" class="delivery_type" value="0">*/?>
					<?php
						$deliveryNormal = false;
						$deliveryQuick = false;
						//echo $delivery_id . ' '.$row->id;
						if($delivery_quick == 0 && $delivery_id == $row->id) {
							$deliveryNormal = true;
						} elseif($delivery_quick == 1 && $delivery_id == $row->id) {
							$deliveryQuick = true;
						}
					?>
					<?php echo CHtml::radioButton('delivery_quick['.$row->id.']', $deliveryNormal, array('id'=>'delivery-normal-'.$row->id, 'class'=>'delivery_type', 'value'=>0))?>

					<label for="delivery-normal-<?= $row->id ?>"><?= PriceHelper::formatPrice($row->delivery_normal, 3, 3, $currency_info, true) ?></label>
				</p>
				<p>Доставка 2-3 дня</p>

				<p class="c_d70000 delivery-quick">
					<?/*<input type="radio" name="delivery_quick[<?= $row->id ?>]" id="delivery-quick-<?= $row->id ?>" class="delivery_type" value="1">*/?>
					<?php echo CHtml::radioButton('delivery_quick['.$row->id.']', $deliveryQuick, array('id'=>'delivery-quick-'.$row->id, 'class'=>'delivery_type', 'value'=>1))?>
					<label for="delivery-quick-<?= $row->id ?>"><?= PriceHelper::formatPrice($row->delivery_quick, 3, 3, $currency_info, true) ?></label>
				</p>
				<p>Доставка ускоренная</p>
				
			<?php	}	else	{	?>
				<p class="c_d70000"><?= PriceHelper::formatPrice($row->delivery_normal, 3, 3, $currency_info, true) ?></p>
				<p>Доставка 2-3 дня</p>
				<?php if($row->delivery_quick > 0)	{	?>
					<p class="c_d70000 delivery-quick"><?= PriceHelper::formatPrice($row->delivery_quick, 3, 3, $currency_info, true) ?></p>
					<p>Доставка ускоренная</p>
				<?php	}	?>
			<?php	}	?>
		</div>
	</div>
<?php 	}	?>
