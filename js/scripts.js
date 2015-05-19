$(document).ready(function () {
	'use strict';
	
	var menu_cat_li_a = $(".menu-cat li a"),
		addtocart = $(".addtocart"),
		max_height = 0,
		products_on_auto_item_a = $('.products-on-auto-item a'),
		cart_qty = 0,
		cart_form = null,
		to_cart_process = null,
		cart_msg = null,
		to_cart_form = null;
			
	$('.sidebar-banner a').click(function () {

	});
	
	//выравниваем высоту блоков новостей
	if($('.news-block-item-small').html() != undefined)	{
		max_height = 0;
		$('.news-block-item .text-block').each(function(){
			if($(this).height() > max_height) {
				max_height = $(this).height();
			}
		});
		$('.news-block-item-small .text-block').css('height', max_height);
	}
	
	menu_cat_li_a.on('click', function () {		//кликнули на пункт бокового меню
		//$(this).parent('li').addClass("asdsad11");
		var elem = $(this).parent('li').find('ul');
		//console.log(elem.length);
		
		if (elem.length) {
			//console.log('1111');
			$(this).next('ul').slideToggle();
			return false;
		}
	});
	
	
	addtocart.on('click', function () {		//добавляем товар в корзину
		to_cart_form = $(this).paren('form');
		cart_msg = to_cart_form.find('.cart-msg');
		to_cart_process = to_cart_form.find('.to-cart-process');
		
		$.ajax({
			type: 'post',
			url: to_cart_form.attr('action'),
			data: {product_id : $('#product_id').val(),	quantity : $('#quantity').val()},
			dataType: 'json',
			beforeSend: function () {
				to_cart_process.slideDown();
			},
			success: function (msg) {
				if (msg.res === 'ok') {
					to_cart_process.hide();
					cart_msg.html(msg.message);
					cart_msg.show();
					
					$('#products-count').html(msg.total);
					$('#cart-total').html(msg.summ);
				}
			}
		});
		return false;
	});
	
	products_on_auto_item_a.on('hover',
		function () {
			$(this).children('.hover-span').fadeIn(200);
		},
		function () {
			$(this).children('.hover-span').fadeOut(200);
		}
	);
	
	products_on_auto_item_a.hover(
		function () {
			$(this).children('.hover-span').fadeIn(200);
		},
		function () {
			$(this).children('.hover-span').fadeOut(200);
		}
	);
	
	$('.tabs a').click(function(){
		switch_tabs(jQuery(this));
	});

	switch_tabs($('.defaultTab'));
	
    $('#search-auto-form').on('change', '#select-marka', function () {
		$.ajax({
			type: 'post',
			url: '/shopmodelsauto/descendants',
			data: {model_id : $(this).val(), level : 1},
			beforeSend: function () {},
			success: function (msg) {
				$('#select-model-wr').html(msg);
				$('#select-model-wr select').styler();
				$('#select-year-wr').html('<select name="select-year" id="select-year"><option value="">Выберите год</option></select>');
				$('#select-year-wr select').styler();
			}
		});
		
    });
	
    $('#search-auto-form').on('change', '#select-model', function () {
		$.ajax({
			type: 'post',
			url: '/shopmodelsauto/descendants',
			data: {model_id : $(this).val(), level : 2},
			beforeSend: function () {},
			success: function (msg) {
				$('#select-year-wr').html(msg);
				$('#select-year-wr select').styler();
			}
		});
		
    });
	
    $('#search-auto-form').on('click', '#clear-search-auto', function () {
		$('input[name="clear-search-auto"]').val(1);
		$('#searchautoform').submit();
		
    });
	
	$('.cart-qty-dec').on('click', function() {
		cart_form = $(this).parent();
		cart_qty = parseInt($(this).parent().children('.inputbox-qty').val());
		if(cart_qty > 1) {
			cart_qty--;
			$(this).parent().children('.inputbox-qty').val(cart_qty);
			$.post(
				cart_form.attr('action'),
				cart_form.serialize(),
				function (data) {
					$('#total-cost-usd').html(data.cost_usd);
					$('#total-cost-byr').html(data.cost_byr);
				},
				'json'
			);
		}
		
		return false;
	})
	

	$('.cart-qty-inc').on('click', function() {
		cart_form = $(this).parent();
		cart_qty = parseInt($(this).parent().children('.inputbox-qty').val());
		cart_qty++;
		$(this).parent().children('.inputbox-qty').val(cart_qty);
        $.post(
            cart_form.attr('action'),
            cart_form.serialize(),
            function (data) {
				$('#total-cost-usd').html(data.cost_usd);
				$('#total-cost-byr').html(data.cost_byr);
            },
			'json'
        );
		return false;
	})
	
	
	
});

function ClosePopUp() {
	'use strict';
	$.fancybox.close();
}

function switch_tabs(obj)
{
	$('.tab-content').hide();
	$('.tabs li').removeClass("selected");
	var id = obj.attr("rel");
	$('#'+id).show();
	obj.parent().addClass("selected");
}