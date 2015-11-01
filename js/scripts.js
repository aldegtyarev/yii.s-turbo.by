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
		timeOut = null;
			
	$('.sidebar-banner a').click(function () {

	});
	
	//console.log(window_height);
	
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
		
		$.ajax({
			type: 'post',
			url: to_cart_form.attr('action'),
			data: {product_id : to_cart_form.find('.product_id').val(),	quantity : to_cart_form.find('.quantity').val()},
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
	
	$('.nav-tabs a').on('click', function(){
		switch_tabs(jQuery(this));
		/*
		var obj = jQuery(this);
		//$('.tab-pane').hide();
		//$('.nav-tabs li').removeClass("selected");
		var id = jQuery(this).attr("href");
		console.log(obj);
		console.log(id);
		$(id).show();
		obj.parent().addClass("selected");
		*/
		return false
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
	});
	
	$('#buy-in-one-click-btn').on('click', function() {
		$('#buy-in-one-click-err').hide();
		$('#buy-in-one-click-ok').hide();
		
		if($('#buy-in-one-click-input').val() == '') {
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
	
	$('#firm').on('change', function() {
		$('#select-view-form').submit();
	});
	
	$('.modal-url').on('click', function() {
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
	
	$("#listView").on('mouseover', '.product-list-item-row .product-image', function() {
		parent_el = $(this).parent();
		hovered_img = $(this);
		hovered = true;
		
		timeOut = setTimeout(function(){
			if(hovered === true) {					
				popup_gallery.html(('<span class="preloaderBig"></span>' + parent_el.find('.popup-prod-img').html()));
				popup_img = popup_gallery.find('.popup-full-img');
				loadGalleryImg(hovered_img, popup_img,  parent_el);
			}
		}, 500);
	});
	
	$("#listView").on('mouseover', ".add-prod-img", function() {
		parent_el = $(this).parent().parent().parent();
		hovered_img = $(this);
		hovered = true;
		
		timeOut = setTimeout(function(){
			if(hovered === true) {
				popup_gallery.html(('<span class="preloaderBig"></span>' + parent_el.find('.popup-prod-img').html()));
				popup_img = popup_gallery.find('.popup-full-img');
				loadGalleryImg(hovered_img, hovered_img, parent_el);
			}
		}, 500);
	});
	
	$("#listView").on('mouseout', '.product-list-item-row .product-image, .add-prod-img', function() {		
		hovered = false;
		clearTimeout(timeOut)

		setTimeout(checkHover, 100);
		//checkHover();
	});	
	
	popup_gallery.hover(
		function() {
			hovered = true;
		},
		function() {
			hovered = false;
			setTimeout(checkHover, 1000);
		}
	);
	
	//навели мышь на миниатюру в окне просмотра фоток
    popup_gallery.on('mouseover', '.popup-thmb-img', function () {		
		popup_img = popup_gallery.find('.popup-full-img');
		showFullImg($(this));
    });
	
	
	function loadGalleryImg(elem, imgElem, parentElem) {
		if(hovered === true) {
			preloaderBig = popup_gallery.find('.preloaderBig');
			popup_top = parentElem.offset().top - 100;
			if((popup_top + popupBlockHeight) > ($(window).scrollTop() + window_height))	{
				popup_top = $(window).scrollTop() + window_height - popupBlockHeight;
			} else if(popup_top < $(window).scrollTop()) {
				popup_top = $(window).scrollTop() + 10;
			}
			
			popup_gallery.css('top', popup_top);
			popup_gallery.css('left', (parentElem.offset().left + 220));

			popup_tmb_img = popup_gallery.find('.popup-thmb-img');

			showFullImg(imgElem);

			popup_tmb_img.each(function(){
				$(this).attr('src', $(this).data('thmbsrc'));
			});

			popup_gallery.fadeIn(300);
			hovered = true;			
		}
	}
	
	function showFullImg(imgElem) {
		popup_img.attr('src', imgElem.data('fullsrc'));
		popup_img.hide();
		popup_img.load(function() {
			//console.log($(this).width() + ' | ' + $(this).height());
			//console.log(popup_gallery.height());
			preloaderBig.hide();
			popup_img.show();
			preloaderBig.css('width',$(this).width());
			preloaderBig.css('height',$(this).height());
			popup_gallery.animate({
    			//width : ($(this).width() + 20),
    			width : ($(this).width()),
     			//height : (popup_img.height() + 20)				
			});
		});
		
		preloaderBig.show();
	}
	
	
});

function ClosePopUp() {
	'use strict';
	$.fancybox.close();
}

function switch_tabs(obj)
{
	$('.tab-pane').hide();
	$('.nav-tabs li').removeClass("selected");
	var id = obj.attr("href");
	//console.log(obj);
	//console.log(id);
	$(id).show();
	obj.parent().addClass("selected");
}