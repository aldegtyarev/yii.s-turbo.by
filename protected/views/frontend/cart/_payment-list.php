<?php foreach($rows as $row)	{	?>
	<?php
		$classes = array(
			'payment-item-cnt',
			'cart-block-border-cnt',
		);
		//echo'<pre>';print_r($row->relations);echo'</pre>';
		if(!isset($row->relations[$delivery_id])) {
			$classes[] = 'cart-block-border-cnt-disabled';
		}	else	{
			$classes[] = 'cart-block-border-cnt-enabled';
			$classes[] = 'payment-item-enabled';
		}
								 
		if($payment_id == $row->id) $classes[] = 'cart-block-border-cnt-selected';
								 
	?>
	<div class="payment-item cart-block-border">
		<div class="<?php echo implode(' ', $classes); ?>" data-payment="<?= $row->id ?>">
			<img alt="" src="<?= $row->ico ?>" style="height: 40px;">
			<div class="cart-block-border-ttl">
				<?php
					$active = false;
					if($payment_id == $row->id) $active = true;
				?>
					<?php echo CHtml::radioButton('payment-type', $active, array('id'=>'payment-'.$row->id, 'class'=>'payment_type', 'value'=>0))?>
					<a href="<?= $this->createUrl('pages/oplata', array('tab'=>$row->id)) ?>" class="fancybox1 fancybox.ajax" rel="nofollow"><?= $row->name ?></a>
			</div>
		</div>
	</div>
<?php 	}	?>
