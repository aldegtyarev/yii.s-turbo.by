$(document).ready(function () {
	'use strict';
	
	var max_height = 0,
		elems = null,
		cart_qty = 0,
		cart_form = null,
		cartBlock = $("#cartBlock-cnt"),
		deliveryList = $("#delivery-list"),
		deliveryItem = null,
		paymentList = $("#payment-list"),
		paymentItem = null,
		product_id = 0;
	
	function setDelivery() {
	    var deliveryId = $('#delivery_id').val();

        if (deliveryId == '2') {
            $('.js-row__post-code').show();
        } else {
            $('.js-row__post-code').hide();
        }

		$.ajax({
			type: 'post',
			url: '/cart/setcostdelivery',
			data: {delivery_id : deliveryId, delivery_quick : $('#delivery_quick').val()},
			dataType: 'json',
			beforeSend: function () {},
			success: function (msg) {
				$('#total-cost-byr').html(msg.cost_byr);
				$('#total-cost-txt').html('Итого с доставкой');
				paymentList.html(msg.payment_html);
				setEqualHeight('#payment-list', '.payment-item-cnt');
			}
		});
	}
	
	function setEqualHeight(parent_block, block) {
		max_height = 0;
		$(parent_block).find(block).each(function(){
			if($(this).height() > max_height)
				max_height = $(this).height();
		});
		$(parent_block).find(block).css('height', max_height);
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
				
				setEqualHeight('#delivery-list-cnt', '.cart-block-border-ttl a');
				setEqualHeight('#delivery-list-cnt', '.delivery-item-cnt');
				setEqualHeight('#payment-list', '.payment-item-cnt');
			},
			'json'
		);
	}
	
	setEqualHeight('#delivery-list-cnt', '.cart-block-border-ttl a');
	setEqualHeight('#delivery-list-cnt', '.delivery-item-cnt');
	setEqualHeight('#payment-list', '.payment-item-cnt');
	
	
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

	$('#delivery-list-cnt').on('click', '.delivery_type', function () {
		deliveryItem = $(this).closest('.delivery-item-cnt');

		$('.delivery_type').each(function(){
			$(this).prop('checked', false);
		});

		$(this).prop('checked', true);

		$('#delivery_quick').val($(this).val());

		if($('#delivery_id').val() != deliveryItem.data('delivery')) {
			$('.delivery-item-cnt').removeClass('cart-block-border-cnt-selected');
			deliveryItem.addClass('cart-block-border-cnt-selected');
			$('#delivery_id').val(deliveryItem.data('delivery'));			
		}
		setDelivery();
	});
	
	$('#payment-list').on('click', '.payment_type', function () {
		paymentItem = $(this).closest('.payment-item-cnt');
		if(paymentItem.hasClass('payment-item-enabled')) {
			$('.payment_type').each(function(){
				$(this).prop('checked', false);
			});
			$(this).prop('checked', true);
			$('#payment_id').val(paymentItem.data('payment'));
			$('.payment-item-cnt').removeClass('cart-block-border-cnt-selected');
			paymentItem.addClass('cart-block-border-cnt-selected');
		} else {
			return false;
		}
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

		if($('#delivery_id').val() == 2) {
		    var $postCode = $('#' + $('#checkoutType input:checked').val()).find('.post-code');

            $postCode.removeClass('error');
		    // console.log($('#checkoutType input:checked').val());
            if($postCode.val() == '') {
                $postCode.addClass('error');
                scroll_el = $postCode;

                if ($(scroll_el).length != 0)
                    $('html, body').animate({ scrollTop: scroll_el.offset().top }, 500);

                res = false;

                return res;
            }
            // return false;
        }
		
		if($('#payment_id').val() == '0') {
			res = false;
			$('#payment-error').show();
			scroll_el = $('#payment-list-cnt');
			
			if ($(scroll_el).length != 0)
				$('html, body').animate({ scrollTop: scroll_el.offset().top }, 500);
			
			return res;
			
		}
		return res;
	});

    $('#checkoutType input').on('change', function () {
        $('#checkout-form .checkout-cnt').hide();
        $('#' + $(this).val()).show();
    });

    $('.na_osnovanii_radio').on('click', function () {
        var selected = parseInt($(this).val());

        switch (selected) {
            case 2:
                $('#doverennost_text_cnt').show();
                $('#svidetelstvo_text_cnt').hide();
                $('#svidetelstvo_text_cnt').val('');
                break;
            case 3:
                $('#svidetelstvo_text_cnt').show();
                $('#doverennost_text_cnt').hide();
                $('#doverennost_text_cnt').val('');
                break;
            default:
                $('#doverennost_text_cnt').hide();
                $('#doverennost_text_cnt').val('');
                $('#svidetelstvo_text_cnt').hide();
                $('#svidetelstvo_text_cnt').val('');
        }
    });
});