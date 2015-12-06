var modal = null,
	phone_mask = '+375 (99) 999-99-99',
	time_to_call_input = 'Звоните: с 99:99 по 99:99';

function switch_tabs(obj) {
	'use strict';
	
	$('.tab-pane').hide();
	$('.nav-tabs li').removeClass("selected");
	var id = obj.attr("href");
	//console.log(obj);
	//console.log(id);
	$(id).show();
	obj.parent().addClass("selected");
}


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
		to_cart_form = null,
		popup_gallery = $('#popup-gallery'),
		popup_top = 0,
		preloaderBig = null,
		popup_img = null,
		popup_tmb_img = null,
		hovered = false,
		window_height = $(window).height(),
		parent_el = null,
		hovered_img = null,
		popupBlockHeight = 580,
		timeOut = null,
		to_cart_product_id = '',
		cartBlock = $("#cartBlock-cnt"),
		product_image = null,
		product_id;
	
	function showFullImg(imgElem) {
		popup_img.attr('src', imgElem.data('fullsrc'));
		popup_img.hide();
		popup_img.load(function () {
			//console.log($(this).width() + ' | ' + $(this).height());
			//console.log(popup_gallery.height());
			preloaderBig.hide();
			popup_img.show();
			preloaderBig.css('width', $(this).width());
			preloaderBig.css('height', $(this).height());
			popup_gallery.animate({
    			width: ($(this).width())
			});
		});
		
		preloaderBig.show();
	}
	
	function loadGalleryImg(elem, imgElem, parentElem) {
		if (hovered === true) {
			preloaderBig = popup_gallery.find('.preloaderBig');
			popup_top = parentElem.offset().top - 100;
			if ((popup_top + popupBlockHeight) > ($(window).scrollTop() + window_height)) {
				popup_top = $(window).scrollTop() + window_height - popupBlockHeight;
			} else if (popup_top < $(window).scrollTop()) {
				popup_top = $(window).scrollTop() + 10;
			}
			
			popup_gallery.css('top', popup_top);
			popup_gallery.css('left', (parentElem.offset().left + 220));

			popup_tmb_img = popup_gallery.find('.popup-thmb-img');

			showFullImg(imgElem);

			popup_tmb_img.each(function () {
				$(this).attr('src', $(this).data('thmbsrc'));
			});

			popup_gallery.fadeIn(300);
			hovered = true;
		}
	}
			
	$('.sidebar-banner a').click(function () {

	});
	
	//console.log(window_height);
	
	//выравниваем высоту блоков новостей
	if ($('.news-block-item-small').html() !== undefined) {
		max_height = 0;
		$('.news-block-item .text-block').each(function () {
			if ($(this).height() > max_height) {
				max_height = $(this).height();
			}
		});
		$('.news-block-item-small .text-block').css('height', max_height);
	}
	
	menu_cat_li_a.on('click', function () {		//кликнули на пункт бокового меню
		var elem = $(this).parent('li').find('ul');
		if (elem.length) {
			$(this).next('ul').slideToggle();
			return false;
		}
	});
	
	
	addtocart.on('click', function () {		//добавляем товар в корзину
		to_cart_form = $(this).parent('form');
		cart_msg = to_cart_form.find('.cart-msg');
		to_cart_process = to_cart_form.find('.to-cart-process');
		
		to_cart_product_id = to_cart_form.find('.product_id').val();
		
		$.ajax({
			type: 'post',
			url: to_cart_form.attr('action'),
			data: {product_id : to_cart_product_id,	quantity : to_cart_form.find('.quantity').val()},
			dataType: 'json',
			beforeSend: function () {
				//to_cart_process.slideDown();
			},
			success: function (msg) {
				if (msg.res === 'ok') {
					to_cart_process.hide();
					//cart_msg.html(msg.message);
					//cart_msg.show();
					
					$('#products-count').html(msg.total);
					$('#cart-total').html(msg.summ);
					$('#cartBlock-cnt').html(msg.html);
					
					product_image = $('#product-image-' + to_cart_product_id);
					
					product_image.clone().appendTo('#product-image-cnt-' + to_cart_product_id)
						.css({'position' : 'absolute', 'z-index' : '10000', 'left' : product_image.offset()['left'], 'top':product_image.offset()['top']})
						.animate({	opacity: 0.05,
									left: cartBlock.offset()['left'],
									top: cartBlock.offset()['top'],
									position: 'absolute',
									width: 20
								 }, 1000, 	function() {
							$(this).remove();
						}
					);
					
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
		});
	
	products_on_auto_item_a.hover(
		function () {
			$(this).children('.hover-span').fadeIn(200);
		},
		function () {
			$(this).children('.hover-span').fadeOut(200);
		}
	);
	
//	$('.advantages-item-cnt').on('click', function () {
//		$(this).children().children().find('.advantages-item-detail').click();
//		//console.log($(this).children().children().find('.advantages-item-detail'));
//		//return false;
//	});

	$('.nav-tabs a').on('click', function () {
		switch_tabs($(this));
		return false;
	});

	switch_tabs($('.nav-tabs .defaultTab'));
	
    $('#search-auto-form').on('change', '#select-marka', function () {
		//$(this).parent().parent().parent().addClass('step-selected');
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
		$(this).parent().parent().parent().addClass('step-selected');
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
	
    $('#search-auto-form').on('change', '#select-year', function () {
		$(this).parent().parent().parent().addClass('step-selected');
		$('#searchautoform').submit();
    });
	
    $('#search-auto-form').on('click', '#clear-search-auto', function () {
		$('input[name="clear-search-auto"]').val(1);
		$('#searchautoform').submit();
		
    });
	
	$('.cart-qty-dec').on('click', function () {
		cart_form = $(this).parent();
		cart_qty = parseInt($(this).parent().find('.inputbox-qty').val());
		if (cart_qty > 1) {
			cart_qty--;
			$(this).parent().find('.inputbox-qty').val(cart_qty);
			product_id = cart_form.find('input[name="product_id"]').val();
			$.post(
				cart_form.attr('action'),
				cart_form.serialize(),
				function (data) {
					$('#cart-price-' + product_id).html(data.product_summ);
					$('#total-cost-usd').html(data.cost_byr);
					//$('#total-cost-byr').html(data.cost_byr);
				},
				'json'
			);
		}
		
		return false;
	});
	

	$('.cart-qty-inc').on('click', function () {
		cart_form = $(this).parent();
		cart_qty = parseInt($(this).parent().find('.inputbox-qty').val());
		cart_qty++;
		$(this).parent().find('.inputbox-qty').val(cart_qty);
		product_id = cart_form.find('input[name="product_id"]').val();
        $.post(
            cart_form.attr('action'),
            cart_form.serialize(),
            function (data) {
				$('#cart-price-' + product_id).html(data.product_summ);
				$('#total-cost-usd').html(data.cost_byr);
				//$('#total-cost-byr').html(data.cost_byr);
            },
			'json'
        );
		return false;
	});
	
	$('#buy-in-one-click-btn').on('click', function () {
		$('#buy-in-one-click-err').hide();
		$('#buy-in-one-click-ok').hide();
		
		if ($('#buy-in-one-click-input').val() === '') {
			$('#buy-in-one-click-err').slideDown();
		} else {
			$.ajax({
				type: 'post',
				url: '/product/buyoneclick',
				data: {product_id : $('input[name="product_id"]').val(), phone : $('#buy-in-one-click-input').val()},
				beforeSend: function () {
					$('#buy-in-one-click-sending').show();
				},
				success: function (msg) {
					$('#buy-in-one-click-sending').hide();
					$('#buy-in-one-click-ok').slideDown();
				}
			});
		}
		return false;
	});
	
	/*
	$('.select-view-btn').on('click', function(e) {
		e.preventDefault();
		$('#select-view').val($(this).data('view'));
		$('#change-view').val(1);
		$('#select-view-form').submit();
		return false;
	});
	*/
	
	$('#firm').on('change', function () {
		$('#select-view-form').submit();
	});
	
	$('.modal-url').on('click', function () {
		$(this).attr('href', ($(this).attr('href') + '?modal=1'));
	});
	
	
	function checkHover() {
		if (hovered === false) {
			popup_gallery.hide();
			popup_gallery.html('');
			popup_gallery.css('width', '670px');
			popup_gallery.css('height', 'auto');
		}
	}
	
	$("#listView").on('mouseover', '.product-list-item-row .product-image', function () {
		if (!$(this).hasClass('page-image')) {
			parent_el = $(this).parent();
			hovered_img = $(this);
			hovered = true;

			timeOut = setTimeout(function () {
				if (hovered === true) {
					popup_gallery.html(('<span class="preloaderBig"></span>' + parent_el.find('.popup-prod-img').html()));
					popup_img = popup_gallery.find('.popup-full-img');
					loadGalleryImg(hovered_img, popup_img,  parent_el);
				}
			}, 500);
		}
	});
	
	$("#listView").on('mouseover', ".add-prod-img", function () {
		parent_el = $(this).parent().parent().parent();
		hovered_img = $(this);
		hovered = true;
		
		timeOut = setTimeout(function () {
			if (hovered === true) {
				popup_gallery.html(('<span class="preloaderBig"></span>' + parent_el.find('.popup-prod-img').html()));
				popup_img = popup_gallery.find('.popup-full-img');
				loadGalleryImg(hovered_img, hovered_img, parent_el);
			}
		}, 500);
	});
	
	$("#listView").on('mouseout', '.product-list-item-row .product-image, .add-prod-img', function () {
		hovered = false;
		clearTimeout(timeOut);

		setTimeout(checkHover, 100);
		//checkHover();
	});
	
	popup_gallery.hover(
		function () {
			hovered = true;
		},
		function () {
			hovered = false;
			setTimeout(checkHover, 1000);
		}
	);
	
	//навели мышь на миниатюру в окне просмотра фоток
    popup_gallery.on('mouseover', '.popup-thmb-img', function () {
		popup_img = popup_gallery.find('.popup-full-img');
		showFullImg($(this));
    });
	
	
	$("#consultant-call").fancybox({
		padding : 20,
		
		afterShow: function() {
			//console.log(current);
			//console.log($('body').find('.fancybox-inner').html());
			$('body').find('.fancybox-inner').find('.phone-input').mask(phone_mask);
			$('body').find('.fancybox-inner').find('.time-to-call-input').mask(time_to_call_input);
		}		
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
		//$('#checkout-form .checkout-cnt').hide();
		//$('#' + $(this).val()).show();
		
    });
	
	
	
	
	
});

function ClosePopUp() {
	'use strict';
	$.fancybox.close();
}

function sendBackCall(el) {
	'use strict';
	var form = $(el).closest('form');
	
	modal = form.parent().parent();
	
	$.post(
		form.attr('action'),
		form.serialize(),
		function (data) {
			modal.html(data);
			modal.find('.phone-input').mask(phone_mask);
			modal.find('.time-to-call-input').mask(time_to_call_input);
		}
	);
	//console.log('sendBackCall');
	return false;
}
