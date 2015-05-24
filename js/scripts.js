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
		window_height = $(window).height();
			
	$('.sidebar-banner a').click(function () {

	});
	
	console.log(window_height);
	
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
	
	
	function checkHover() {
		if (hovered === false) {
			popup_gallery.hide();
			popup_gallery.html('');
			popup_gallery.css('width', 'auto');
			popup_gallery.css('height', 'auto');
		}
	}
	
	$(".product-image").on('mouseover', function() {
		//console.log('over');
		popup_gallery.html(('<span class="preloaderBig"></span>' + $(this).parent().find('.popup-prod-img').html()));
		
		popup_img = popup_gallery.find('.popup-full-img');
		loadGalleryImg($(this), popup_img, $(this).parent() );
		/*
		preloaderBig = popup_gallery.find('.preloaderBig');
		
		popup_top = $(this).parent().offset().top - 100;
		popup_gallery.css('top', ($(this).parent().offset().top - 100));
		popup_gallery.css('left', ($(this).parent().offset().left + 220));
		
		popup_img = popup_gallery.find('.popup-full-img');
		popup_tmb_img = popup_gallery.find('.popup-thmb-img');
		popup_img.attr('src', popup_img.data('fullsrc'));
		popup_img.hide();		
		popup_img.load(function(){
			preloaderBig.hide();
			popup_img.show();
			preloaderBig.css('width',popup_img.width());
			preloaderBig.css('height',popup_img.height());
			popup_gallery.animate({
    			width : (popup_img.width() + 20),
     			//height : (popup_img.height() + 20)				
			});
			
		});
		
		preloaderBig.show();
		
		popup_tmb_img.each(function(){
			$(this).attr('src', $(this).data('thmbsrc'));
		});
		
		popup_gallery.fadeIn(300);
		hovered = true;
		*/
	});
	
	$(".add-prod-img").on('mouseover', function() {
		popup_gallery.html(('<span class="preloaderBig"></span>' + $(this).parent().parent().parent().find('.popup-prod-img').html()));
		
		popup_img = popup_gallery.find('.popup-full-img');
		
		loadGalleryImg($(this), $(this), $(this).parent().parent().parent());		
	});
	
	$(".product-image, .add-prod-img").on('mouseout', function() {
		hovered = false;
		setTimeout(checkHover, 500);
	});	
	
	popup_gallery.hover(
		function() {
			hovered = true;
		},
		function() {
			hovered = false;
			setTimeout(checkHover, 500);
		}
	);
	
	//навели мышь на миниатюру в окне просмотра фоток
    popup_gallery.on('mouseover', '.popup-thmb-img', function () {		
		popup_img = popup_gallery.find('.popup-full-img');
		showFullImg($(this));
    });
	
	
	function loadGalleryImg(elem, imgElem, parentElem) {
		preloaderBig = popup_gallery.find('.preloaderBig');
		
		popup_top = parentElem.offset().top - 100;
		popup_gallery.css('top', (parentElem.offset().top - 100));
		popup_gallery.css('left', (parentElem.offset().left + 220));
		
		popup_tmb_img = popup_gallery.find('.popup-thmb-img');
		
		showFullImg(imgElem);
		
		popup_tmb_img.each(function(){
			$(this).attr('src', $(this).data('thmbsrc'));
		});
		
		popup_gallery.fadeIn(300);
		hovered = true;
	}
	
	function showFullImg(imgElem) {
		popup_img.attr('src', imgElem.data('fullsrc'));
		popup_img.hide();
		//console.log(popup_img);
		popup_img.load(function() {
			console.log($(this).width() + ' | ' + $(this).height());
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
	$('.tab-content').hide();
	$('.tabs li').removeClass("selected");
	var id = obj.attr("rel");
	$('#'+id).show();
	obj.parent().addClass("selected");
}