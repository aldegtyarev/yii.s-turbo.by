$(document).ready(function () {
	'use strict';
	
	var max_height = 0,
		elems = null,
		cart_qty = 0,
		cart_form = null,
		cartBlock = $("#cartBlock-cnt"),
		deliveryList = $("#delivery-list"),
		paymentList = $("#payment-list"),
		product_id = 0;
	
	function setDelivery() {
		$.ajax({
			type: 'post',
			url: '/cart/setcostdelivery',
			data: {delivery_id :$('#delivery_id').val(), delivery_quick : $('#delivery_quick').val()},
			dataType: 'json',
			beforeSend: function () {},
			success: function (msg) {
				$('#total-cost-byr').html(msg.cost_byr);
				paymentList.html(msg.payment_html);
				setEqualHeight('.payment-item-cnt');
			}
		});
	}
	
	function setEqualHeight(block) {
		max_height = 0;
		$(block).each(function(){
			if($(this).height() > max_height)
				max_height = $(this).height();
		});

		$(block).css('height', max_height);
		
	}
	
	function updateCart(elem) {
		elem.parent().find('.inputbox-qty').val(cart_qty);
		product_id = cart_form.find('input[name="product_id"]').val();
		$.post(
			cart_form.attr('action'),
			cart_form.serialize(),
			function (data) {
				$('#cart-price-' + product_id).html(data.product_summ);
				cartBlock.html(data.html);
				$('#total-cost-byr').html(data.cost_byr);
				deliveryList.html(data.delivery);
				paymentList.html(data.payment);
				setEqualHeight('.delivery-item-cnt');
				setEqualHeight('.payment-item-cnt');
				$('#delivery_id').val(0);
				$('#payment_id').val(0);
			},
			'json'
		);
		
	}
	
	setEqualHeight('.delivery-item-cnt');
	setEqualHeight('.payment-item-cnt');
	
	$('.cart-qty-dec').on('click', function () {
		cart_form = $(this).parent();
		cart_qty = parseInt($(this).parent().find('.inputbox-qty').val());
		if (cart_qty > 1) {
			cart_qty--;
			updateCart($(this));
		}
		
		return false;
	});
	

	$('.cart-qty-inc').on('click', function () {
		cart_form = $(this).parent();
		cart_qty = parseInt($(this).parent().find('.inputbox-qty').val());
		cart_qty++;
		updateCart($(this));

		return false;
	});
	
	
	deliveryList.on('click', '.delivery-item-cnt', function(){
		if($('#delivery_id').val() != $(this).data('delivery')) {
			
			$('.delivery_type').each(function(){
				$(this).prop('checked', false);
			});
			
			$('.delivery-item-cnt').removeClass('cart-block-border-cnt-selected');

			$(this).addClass('cart-block-border-cnt-selected');

			$('#delivery_id').val($(this).data('delivery'));
			
			if($(this).find('.delivery_type').length > 0) {
				elems = $(this).find('.delivery_type');
				$(elems[0]).prop('checked', true);
			}
			
			$('#delivery_quick').val(0);
			setDelivery();
		}
	});
	
	paymentList.on('click', '.payment-item-enabled', function() {
		if($('#payment_id').val() != $(this).data('payment')) {
			$('.payment-item-cnt').removeClass('cart-block-border-cnt-selected');

			$(this).addClass('cart-block-border-cnt-selected');

			$('#payment_id').val($(this).data('payment'));
		}
	});
	
	
	$('.delivery_type').on('click', function(){
		$('.delivery_type').each(function(){
			$(this).prop('checked', false);
		});
		
		$(this).prop('checked', true);
		
		$('#delivery_quick').val($(this).val());
		setDelivery();
	});
	
	$('#checkout-form').on('submit', function() {
		var res = true,
			scroll_el = null;
		
		$('#delivery-error').hide();
		$('#payment-error').hide();
		
		if($('#delivery_id').val() == '0') {
			res = false;
			
			$('#delivery-error').show();
			
			scroll_el = $('#delivery-list-cnt');
			
			if ($(scroll_el).length != 0)
				$('html, body').animate({ scrollTop: scroll_el.offset().top }, 500);
			
			return res;
		}
		
		if($('#payment_id').val() == '0') {
			res = false;
			$('#payment-error').show();
			scroll_el = $('#payment-list-cnt');
			
			if ($(scroll_el).length != 0)
				$('html, body').animate({ scrollTop: scroll_el.offset().top }, 500);
			
			return res;
			
		}
		
		
		console.log('ssw');
		return res;
	});
	
});