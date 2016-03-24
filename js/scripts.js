var modal = null,
	phone_mask = '+375 (99) 999-99-99',
	time_to_call_input = 'Звоните: с 99:99 по 99:99';

function switch_tabs(obj) {
	'use strict';
	
	$('.tab-pane').hide();
	$('.nav-tabs li').removeClass("selected");
	var id = obj.attr("href");
	$(id).show();
	obj.parent().addClass("selected");
}

function setEqualHeight(block) {
	'use strict';
	var max_height = 0;
	$(block).each(function(){

		if($(this).height() > max_height)
			max_height = $(this).height();
	});
	$(block).css('height', max_height);
}


$(document).ready(function () {
	'use strict';
	
	var menu_cat_li_a = $("#categories-menu li ul li a"),
		menu_cat_main = $("#categories-menu > li > a"),
		
		max_height = 0,
		products_on_auto_item_a = $('.products-on-auto-item a'),
		to_cart_process = null,
		cartBlock = $("#cartBlock-cnt"),
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
		checkhover = null,
		to_cart_product_id = '',
		product_image = null,
		product_id = 0,
		$central_cnt = $('#central-cnt'),
		block_to_load = null,
		cnt_to_load = '',
		categoryProducts_cnt = " #content-wr > *",
		central_cnt = " #central-cnt > *",
		scroll_el = null,
		scroll_el_pos = 0,
		model_is_change = false,
		scroll_to_block = false,
		simple_page = false,
		addtocart_enable = true,
		is_bodyset_change = false,
		// запоминаем текущую страницу и их максимальное количество
		page = 0,
		pageCount = 0,
		loadingFlag = false,
		csrfTokenName = '',
		csrfToken = '',
		pagination_url = '',
		show_prod_images = true;
		
	
	function showFullImg(imgElem) {
		popup_img.attr('src', imgElem.data('fullsrc'));
		popup_img.hide();

		popup_img.load(function () {
			preloaderBig.hide();
			popup_img.show();
			//console.log(popup_img.width());
			if(popup_img.width() != 0) {
				//preloaderBig.css('width', $(this).width());
				preloaderBig.css('width', popup_img.width());
				//preloaderBig.css('height', $(this).height());
				preloaderBig.css('height', popup_img.height());

				popup_gallery.animate({
					//width: ($(this).width())
					width: (popup_img.width())
				});
			}
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
			
	function ya_share_init() {
		var og_img = $('#og_image').val(),
			og_type = $('#og_type').val(),
			og_url = $('#og_url').val(),
			og_title = $('#og_title').val(),
			og_description = $('#og_description').val();
		
		var share = Ya.share2('my-share', {
			content: {
				type: og_type,
				url: og_url,
				title: og_title,
				description: og_description,
				image: og_img
			}
			// здесь вы можете указать и другие параметры
		});
	}

	function checkHover() {
		if (hovered === false) {
			popup_gallery.hide();
			popup_gallery.html('');
			popup_gallery.css('width', '670px');
			popup_gallery.css('height', 'auto');
		}
	}

	//setEqualHeight('.cart-block-border-ttl');
	//setEqualHeight('.delivery-item-cnt');


	$(".fancybox-delivery").fancybox({
		padding : 20,
		helpers: {
			overlay: {
				locked: false
			}
		},
		beforeShow: function(current, previous) {
	 		setEqualHeight('.fancybox-inner .cart-block-border-ttl');
			setEqualHeight('.fancybox-inner .delivery-item-cnt');
	 	}
	});


		
	if ($('#pageCount_input').length != 0) {
		page = parseInt($('#page_input').val());
		pageCount = parseInt($('#pageCount_input').val());
		csrfTokenName = $('#csrfTokenName').val();
		csrfToken = $('#csrfToken').val();
		pagination_url = $('#pagination-url').val();
	}
	
	$('#central-cnt').on('click', '#categories-menu li ul li a', function (e) {		//кликнули на пункт бокового меню
		var elem = $(this).parent('li').find('ul');
		
		e.preventDefault();
		
		if (elem.length) {
			$(this).next('ul').slideToggle();
			return false;
		} else {
			$('#searchautoform').attr('action', $(this).attr('href'));
			if($(this).parent().hasClass('bodyset')) {
				is_bodyset_change = true;
				$('#search-auto-form').find('#select-year').val($(this).parent().data('body_id')).trigger('refresh');
				$('#search-auto-form').find('#select-year').change();
				return false;
			}
			scroll_el = $('#search-auto-block');
			scroll_el_pos = scroll_el.offset().top;
			$("#categories-menu li ul li a").each(function () {
				if($(this).parent().hasClass('cat-4623') && $(this).parent().children('ul').is(':visible')) {
					$(this).parent().children('ul').css('display', 'block');
				}
				$(this).parent().removeClass('active');
			});
			$(this).parent('li').addClass('active');
			scroll_to_block = true;
			$('#searchautoform').attr('action', $(this).attr('href'));
			History.pushState(null, document.title, $(this).attr('href'));			
		}
		return false;
	});
	
	$('#central-cnt').on('click', "#categories-menu > li > a", function () {		//кликнули на главный пункт бокового меню
		return false;
	});
	
	$("#central-cnt").on('click', '.product-types-block a, .related_categories a', function (e) {
		e.preventDefault();
		$('#searchautoform').attr('action', $(this).attr('href'));		
		History.pushState(null, document.title, $(this).attr('href'));
		scroll_el = $("#central-cnt");
		scroll_el_pos = scroll_el.offset().top;
		scroll_to_block = false;
	});
	
	$("#central-cnt").on('click', '.related_categories a', function (e) {
		var url = $(this).attr('href'),
			link = $('#central-cnt').find('#categories-menu li ul li.'+$(this).data('cat')).children('a');
		e.preventDefault();

		link.attr('href', url);
		link.click();

		/*
		$('#central-cnt').find('#categories-menu li ul li a').each(function(){
			if($(this).attr('href') == url) {
				$(this).click();
				return false;
			}
		})
		*/
		return false;
	});

	$("#central-cnt").on('click', '.page-item-more, .page-readmode, .all-items, .page-title, .page-image, .product-title, .product-detail, .switch-view', function (e) {
		e.preventDefault();
		History.pushState(null, document.title, $(this).attr('href'));
		scroll_el = $('#search-auto-block');
		scroll_el_pos = scroll_el.offset().top;
		scroll_to_block = true;
	});
	
	$("#central-cnt").on('click', '.addtocart', function (e) {		//добавляем товар в корзину
		e.preventDefault();
		if(addtocart_enable === true) {
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
					addtocart_enable = false;
				},
				success: function (msg) {
					if (msg.res === 'ok') {
						to_cart_process.hide();

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
					addtocart_enable = true;
				}
			});
		}
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
			beforeSend: function () { $('#select-model-loading').show(); },
			success: function (msg) {
				$('#select-model-loading').hide();
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
			beforeSend: function () { $('#select-year-loading').show(); },
			success: function (msg) {
				$('#select-year-loading').hide();
				$('#select-year-wr').html(msg);
				$('#select-year-wr select').styler();
			}
		});
    });
	
    $('#search-auto-form').on('change', '#select-year', function () {
		if($(this).val() != '') {
			$(this).parent().parent().parent().addClass('step-selected');
			var form = $(this).closest('form');
			$.post(
				form.attr('action'),
				form.serialize(),
				function (data) {
					History.pushState(null, document.title, data);
					scroll_el = $('#search-auto-block');
					scroll_el_pos = scroll_el.offset().top;
					scroll_to_block = true;
					$('#searchautoform').attr('action', data);
				}
			);
			model_is_change = true;
		}
    });
	
    $('#search-auto-form').on('click', '#clear-search-auto', function () {
		$('input[name="clear-search-auto"]').val(1);
		$('#searchautoform').submit();
		
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
	
	$('#firm').on('change', function () {
		$('#select-view-form').submit();
	});
	
	$('#content-cnt').on('click', '.modal-url', function () {
		$(this).attr('href', ($(this).attr('href') + '?modal=1'));
	});
	
	
	$("#central-cnt").on('mouseover', '.product-list-item-row .product-image', function () {
		if (!$(this).hasClass('page-image') && show_prod_images === true) {
			parent_el = $(this).parent();
			hovered_img = $(this);
			hovered = true;

			//clearTimeout(timeOut);
			//clearTimeout(checkhover);


			//timeOut = setTimeout(function () {
				if (hovered === true) {
					popup_gallery.html(('<span class="preloaderBig"></span>' + parent_el.find('.popup-prod-img').html()));
					popup_img = popup_gallery.find('.popup-full-img');
					loadGalleryImg(hovered_img, popup_img,  parent_el);
				}
			//}, 500);
		}
	});
	
	$("#central-cnt").on('mouseover', ".add-prod-img", function () {
		parent_el = $(this).parent().parent().parent();
		hovered_img = $(this);
		hovered = true;



		timeOut = setTimeout(function () {
			if (hovered === true) {
				popup_gallery.html(('<span class="preloaderBig"></span>' + parent_el.find('.popup-prod-img').html()));
				popup_img = popup_gallery.find('.popup-full-img');
				//loadGalleryImg(hovered_img, hovered_img, parent_el);
				showFullImg(hovered_img);
			}
		}, 500);
	});
	
	$("#central-cnt").on('mouseout', '.product-list-item-row .product-image, .add-prod-img', function () {
		hovered = false;
		//clearTimeout(timeOut);
		//clearTimeout(checkhover);

		checkhover = setTimeout(checkHover, 100);
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
	
	$("#central-cnt").on('mouseover', '.product-detail-tile', function () {
		$(this).parent().parent().parent().find('.product-title').css('text-decoration','underline');
	});
	$("#central-cnt").on('mouseout', '.product-detail-tile', function () {
		$(this).parent().parent().parent().find('.product-title').css('text-decoration','none');
	});
	
	
	$("#consultant-call").fancybox({
		padding : 0,
		afterShow: function() {
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
    });
	
	$('#central-cnt').on('click', '#showMore', function() {
		// защита от повторных нажатий
		if (!loadingFlag)
		{
			// выставляем блокировку
			loadingFlag = true;

			// отображаем анимацию загрузки
			$('#central-cnt').find('#loading').show();
			$('#central-cnt').find('#showMore').hide();

			$.ajax({
				type: 'post',
				//url: window.location.href,
				url: pagination_url,
				data: {
					showmore: 1,
					// передаём номер нужной страницы методом POST
					page: page + 1,
					YII_CSRF_TOKEN: csrfToken
				},
				success: function(data)
				{
					// увеличиваем номер текущей страницы и снимаем блокировку
					page++;                            
					loadingFlag = false;                            

					// прячем анимацию загрузки
					$('#central-cnt').find('#loading').hide();
					$('#central-cnt').find('#showMore').show();

					// вставляем полученные записи после имеющихся в наш блок
					$('#central-cnt').find('#listView').append(data);

					// если достигли максимальной страницы, то прячем кнопку
					if (page >= pageCount)
						$('#central-cnt').find('#showMore').hide();
				}
			});
		}
		return false;
	})
	
	
	History.Adapter.bind(window, 'statechange',function(e){
		var State = History.getState();
		loadPage(State.url);
	});
	
	function loadPage(url) {
		document.onmousewheel = document.onwheel = function(){
			return false;
		};
		
		show_prod_images = false;
		
		if(model_is_change === true) {
			if(is_bodyset_change === true) {
				block_to_load = $("#central-cnt #categories-menu");
				cnt_to_load = "#central-cnt #categories-menu > *";
			} else {
				block_to_load = $central_cnt;
				cnt_to_load = central_cnt;
			}
			$('#clear-search-auto').show();
		} else {
			block_to_load = $central_cnt.find('#content-wr');
			if(simple_page === false) cnt_to_load = categoryProducts_cnt;
				else cnt_to_load = '';
		}

		block_to_load.load(url + cnt_to_load, function(responseTxt) {
			document.title = $(responseTxt).filter('title').text();

			$('#central-cnt').find('.pager').hide();
			ya_share_init();
			block_to_load.find(".fancybox").fancybox({
				padding : 0,
				helpers: {
					overlay: {
						locked: false
					}
				}
			});

			block_to_load.find(".fancybox1").fancybox({
				padding : 20,
				helpers: {
					overlay: {
						locked: false
					}
				}
			});

			block_to_load.find(".fancybox-delivery").fancybox({
				padding : 20,
				helpers: {
					overlay: {
						locked: false
					}
				},
				beforeShow: function(current, previous) {
					setEqualHeight('.fancybox-inner .cart-block-border-ttl');
					setEqualHeight('.fancybox-inner .delivery-item-cnt');
				}
			});


			if ($('.jcarousel-products-on-auto').length != 0) {
				$('.jcarousel-products-on-auto').jcarousel({
					wrap: 'circular',
					visible: 1
				});

				$('.jcarousel-products-on-auto-control-prev')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						target: '-=1'
					});

				$('.jcarousel-products-on-auto-control-next')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						target: '+=1'
					});
			}
			
			if ($(scroll_el).length != 0) {
				if(scroll_to_block === true) {
					if($('#content-wr').find('#scroll_to_engine').val() == '1') {
						var menu_item = $('.sideLeft .cat-4622'),
							select_str = '';
						
						scroll_el_pos = menu_item.offset().top;
						$('.sideLeft .cat-4623').find('li').each(function() {
							if($(this).hasClass('bodyset')) {
								select_str = 'Для точного поиска, выберите КУЗОВ';
							}
						});
						
						if(select_str === '') {
							select_str = 'Для точного поиска, выберите ДВИГАТЕЛЬ';
						}
						
						$('#select_engine_notice span').text(select_str);
						
						$('html, body').animate({ scrollTop: scroll_el_pos }, 900, function(){
							$('#select_engine_notice').css('top', (scroll_el_pos + 50));
							$('#select_engine_notice').fadeIn();
							
							document.onmousewheel=document.onwheel=function(){ 
								return true;
							};					
						});
						
					} else {
						$('html, body').animate({ scrollTop: scroll_el_pos }, 900, function(){
							document.onmousewheel=document.onwheel=function(){ 
								return true;
							};
							//$('#content-wr').find("#productdetails-view-tab").yiitab();

							$('#content-wr').on('click', '#productdetails-view-tab .tabs > li > a', function() {
								var tabs = $(this).parent().parent().parent(),
									id = $(this).attr("href");


								tabs.find('.tabs > li > a').removeClass("active");
								$(this).addClass("active");

								tabs.find('.view').hide();
								$(id).show();

								console.log(id);
								return false;
							});

							
						});
						
					}
					
				} else {
					document.onmousewheel=document.onwheel=function(){ 
						return true;
					};					
				}
				scroll_to_block = false;
			}

			$('.fancybox-wrap .fancybox-close').click();
			
			model_is_change = false;
			simple_page = false;
			show_prod_images = true;
			is_bodyset_change = false;
			
			if ($('#central-cnt').find('#pageCount_input').length != 0) {
				page = parseInt($('#central-cnt').find('#page_input').val());
				pageCount = parseInt($('#central-cnt').find('#pageCount_input').val());
				csrfTokenName = $('#central-cnt').find('#csrfTokenName').val();
				csrfToken = $('#central-cnt').find('#csrfToken').val();
				pagination_url = $('#central-cnt').find('#pagination-url').val();
				
			}
			
			if ($('#central-cnt').find('.pager').length != 0) {
				$('#central-cnt').find('.pager').hide();
			}
			
			
			$.get(
				'/site/renderlastviewed',
				function (data) {
					$('#last-viewed-cnt').html(data);
				}
			);
			
		});
	}	
	
	
});

$(window).load(function () {
	var child_categories_title = $('.child-categories .product-title'),
		max_height = 0;
	
	child_categories_title.each(function () {
		if ($(this).height() > max_height) {
			max_height = $(this).height();
		}
	});
	child_categories_title.css('height', max_height);
	
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
	
});

function ClosePopUp() {
	'use strict';
	$.fancybox.close();
}

function sendBackCall(el) {
	'use strict';
	var form = $(el).closest('form');
	
	modal = form.parent().parent().parent();
	
	$.post(
		form.attr('action'),
		form.serialize(),
		function (data) {
			modal.html(data);
			modal.find('.phone-input').mask(phone_mask);
			modal.find('.time-to-call-input').mask(time_to_call_input);
		}
	);
	return false;
}
