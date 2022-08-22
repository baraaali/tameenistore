if($('body').width() < 500){
    if($('.category_index_offers').hasClass('w100')){
        $('.category_index_offers').removeClass('w100')
    }
}

$('.furnished_content').hide();
var only_cat_id = $('.only_cat_id').val();
var WebLang = $('#webLang').attr('data-lang');
// Banners show or hidden
if($('body').width() > 500) {
}else {
	$('.browse_categories').show();
	$('.search_panel').show();
}
var aa = $('#if_favorite_delete_class').hasClass('active');
if($('body').width() < 500){
	$('body').removeClass('barriable');
}

var l = window.location;
var pageName = (function () {
    var a = window.location.href,
        b = a.lastIndexOf("/");
    return a.substr(b + 1);
}());
var url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[0];
var base_url = '';

if (url == 'http://localhost/') {
    base_url = 'http://localhost/mzadqatar/public';
} else {
    base_url = url;
}

if(window.location.pathname.indexOf('/products/') != '-1'){
	//	for comments section load gif of products page
    $('#comment-list').html('<div style="width: min-content;\n' +
        'margin: 0px auto;">' +
        '<img src="'+base_url+'/assets/images/wait.gif" style="width: 150px">' +
        '</div>')
}

$(document).ready(function () {
	$('.icon_load_version').trigger('click',function(){});
	$('body').bind('touchover click','.category_drop_down_ul',function(){
		$('.mega-menu').toggleClass('open');
	});
	$('body').on('click','.open_sub_menu_in_header',function(){
		$('#header-menu').toggleClass('in');
	});

	$('#formsearch').on('submit', function (e) {
		var lang = $("input[name=lang]").val();
		var price_from = $("input[name=price_from]").val();
		var category = $('#category').val();
		if (category == 1) {
			var man_from = $("input[name=manfactureYearFrom]").val();
			var man_to = $("input[name=manfactureYearTo]").val();
			var km_from = $("input[name=kmFrom]").val();
			var km_to = $("input[name=kmTo]").val();
			if (Number(man_from) > Number(man_to)) {
				if (lang == 'en') {
					$('#manfactureYear-error').text('invalid  range ');
				} else {
					$('#manfactureYear-error').text('اختر المدي الصحيح ');
				}
				e.preventDefault();
			}
			if (Number(km_from) > Number(km_to)) {
				if (lang == 'en') {
					$('#km-error').text('invalid range  ');
				} else {
					$('#km-error').text('اختر المدي الصحيح ');
				}
				e.preventDefault();
			}
		}
		var price_to = $("input[name=price_to]").val();
		if (Number(price_from) > Number(price_to)) {
			if (lang == 'en') {
				$('#price-error').text('invalid  range ');
			} else {
				$('#price-error').text('اختر المدي الصحيح ');
			}
			e.preventDefault();
		} else {
			$('#price-error').hide();
		}
	});
	$('#formreport').on('submit', function (e) {
		var product = $('#product').val();
		var token = $("input[name=_token]").val();
		var reason = $("input[name=reason]").val();
		var lang = $("input[name=lang]").val();
		var comment_msg;
		var user_msg;
		if (lang == 'en') {
			comment_msg = 'please select your reason';
			user_msg = 'login in firstly';
		} else {
			comment_msg = 'من فضلك اختر السبب';
			user_msg = 'لا بد ان تكون مسجل';
		}
		e.preventDefault();
		if (user == '') {
			$("#offer-report-modal").modal('hide');
			$('#modeltext').html(user_msg);
			$("#myModalSuccess").modal().show();
		}
		else if (reason == '' || reason == null) {
			$("#offer-report-modal").modal('hide');
			$('#modeltext').html(comment_msg);
			$("#myModalSuccess").modal().show();
		}
		else {
			$.ajax({
				type: 'post',
				url: base_url + '/add_report',
				data: {
					user: user, _token: token, product: product, reason: reason
				},
				success: function (result) {
					$("#offer-report-modal").modal('hide');
					$("#myModalSuccess").modal().show();
				}
			});
		}
	});
	$("#showclickbutton").click(function () {
		$('#showclick').hide();
		$('#showphone').show();
	});
	$("#previous").click(function () {
		$('#step1').addClass("active");
		$('#step2').removeClass("active");
	});
	$("#submitform").click(function () {
		if (pageName == 'add') {
			var img = $('#mainimage').val();
			var lang = $('#lang').val();
			var warningtext = '';
			if (lang == 'ar') {
				warningtext = 'يجب اختيار الصورة الرئيسية ';
			} else {
				warningtext = 'You Should Choose Main Image  ';
			}
			if (img == null || img == '') {
				$('#mainwarnning').text(warningtext);
			} else {
				$('#mainwarnning').text('');
				$("#signupForm").submit();
			}
		} else {
			$("#signupForm").submit();
		}
	});
	$("#nextwizard").click(function () {
		$('#valid').val("");
		validationform();
		if ($('#valid').val() == 0) {
			var lang = $('#lang').val();
			if (lang == 'en') {
				var str_en = $('#name_en').val();
				var str2_en = $('#descentext').val();
				if (str_en.length <= 20 && str2_en.length <= 500) {
					$('#step2').addClass("active");
					$('#step1').removeClass("active");
				}
				else {
					if (str_en.length > 20) {
						$('#name_en-error').show();
						$('#name_en-error').text('Title  must be less than letters');
					}
					if (str2_en.length > 500) {
						$('#descentext-error').show();
						$('#descentext-error').text('Details  must be less than 500 Letters');
					}
				}
			}
			else if (lang == 'ar') {
				var str_en = $('#name_ar').val();
				var str2_en = $('#descartext').val();
				if (str_en.length <= 20 && str2_en.length <= 500) {
					$('#step2').addClass("active");
					$('#step1').removeClass("active");
				}
				else {
					if (str_en.length > 20) {
						$('#name_ar-error').show();
						$('#name_ar-error').text('يجب ان تكون عدد الحروف اقل من عشرون حرفا');
					}
					if (str2_en.length > 500) {
						$('#descartext-error').show();
						$('#descartext-error').text('عدد حرف التفاصيل يجب ان تكون اقل من 500 حرف');
					}
				}
			}
			else {
				var str_ar = $('#name_ar').val();
				var str2_ar = $('#descartext').val();
				var str_en = $('#name_en').val();
				var str2_en = $('#descentext').val();
				if (str_en.length <= 20 && str2_en.length <= 500 && str_ar.length <= 20 && str2_ar.length <= 500) {
					$('#step2').addClass("active");
					$('#step1').removeClass("active");
				}
				else {
					if (str_ar.length > 20) {
						$('#name_ar-error').show();
						$('#name_ar-error').text('يجب ان تكون عدد الحروف اقل من عشرون حرفا');
					}
					if (str2_ar.length > 500) {
						$('#descartext-error').show();
						$('#descartext-error').text('عدد حرف التفاصيل يجب ان تكون اقل من 500 حرف');
					}
					if (str_en.length > 20) {
						$('#name_en-error').show();
						$('#name_en-error').text('Title  must be less than letters');
					}
					if (str2_en.length > 500) {
						$('#descentext-error').show();
						$('#descentext-error').text('Details  must be less than 500 Letters');
					}
				}
			}
		}
	});

	$("#langauge").change(function () {
		var value = $('#langauge').val();

		if (value == 'ar') {

			$('#nameen').hide();
			$('#descen').hide();
			$('#name_en_inp').val('');
			$('#desc_en').val('');

			$('#namear').show();
			$('#descar').show();
			$('#name_ar_inp').val('');
			$('#desc_ar').val('');
		}
		else if (value == 'en') {

			$('#namear').hide();
			$('#descar').hide();
			$('#name_ar_inp').val('');
			$('#desc_ar').val('');

			$('#nameen').show();
			$('#descen').show();
			$('#name_en_inp').val('');
			$('#desc_en').val('');
		}
		else {

			$('#namear').show();
			$('#descar').show();
			$('#nameen').show();
			$('#descen').show();
		}
	});

	function validationlenth() {
		var nameen_len = $('#name_en').length();
	}
	function sleep(milliseconds) {
		var start = new Date().getTime();
		for (var i = 0; i < 1e7; i++) {
			if ((new Date().getTime() - start) > milliseconds) {
				break;
			}
		}
	}
	if($('body').width() < 500 || $('body').width() == 500){
		// borders();
		$('.span_sort').css('color','#555');
		$('.grid-view').removeClass('hidden');
		$('.list-view').removeClass('hidden');
	}
	$(window).resize(function(){
		if($('body').width() < 767){
			$('.one_version_style').trigger('click',function(){});
			if($('.two_click_icon').hasClass('active')) {
				$('.two_click_icon').removeClass('active');
				$('.one_version_style').addClass('active');
			}
		}
		if($('body').width() < 500 || $('body').width() == 500){
			$('.search_panel').show();
			$('.browse_categories').show();
			$('.span_sort').css('color','#555');
			$('.grid-view').removeClass('hidden');
			$('.list-view').removeClass('hidden');
			if($('.show_filters').hasClass('red')){
				$('.panel_prace_style').css({
					display : 'block'
				});
			}else {
				$('.dynamic_children').css({
					// display : 'none'
				});
			}
			$('body').removeClass('barriable');
			// if($('.mobile_cat_menu').hasClass('open')){
			//     $('.only_height_header').addClass('get_height');
			// }
		}
		if($('body').width() > 500){
			// $('.filter-params').fadeIn();
			$('.search_panel').hide();
			$('.browse_categories').hide();
			$('.span_sort').css('color','#337ab7');
			$('.grid-view').removeClass('hidden');
			$('.list-view').removeClass('hidden');
			// $('.click_icon_two_style').removeAttr('style');
			$('.resize_width_info').removeAttr('style');
			$('.dynamic_children').css({
				display : 'block'
			});
			$('.panel_prace_style').css({
				display : 'none'
			});
			$('body').addClass('barriable');
		}
	});
	// search Filters show or hidden
	$('body').on('click','.show_filters', function(){
		$('.show_filters').removeAttr('style');
		if($.trim($('.get_show_more_text').text()) == 'Show more' || $.trim($('.get_show_more_text').text()) == 'عرض المزيد'){
			(WebLang == 'en') ? $('.get_show_more_text').text('Show less') : $('.get_show_more_text').text('عرض الأقل');
        }else {
            (WebLang == 'en') ? $('.get_show_more_text').text('Show more') : $('.get_show_more_text').text('عرض المزيد');
		}
        //
		$('.dynamic_children').toggle();
		$(".fa-arrow-down").toggle();
		$(".fa-arrow-up").toggle();
		// $(".show_filters").toggleClass('red');
		$('.panel_prace_style').toggle();

		 setTimeout(function(){
			 $('.show_filters').css({
				background : '#5688a9',
				color: '#fff',
			});
		 },200);
	});

	/*$('.tag').keyup(function() {
		var tag = $(this).val()
		var key = $('.hidden-cat-id').val()

		if (tag.length >= 1) {
			$.ajax({
				method: "GET",
				url: "/search_tags",
				data: { tag: tag, key: key },
				success: function (result) {

					$('#tags_div').fadeIn()

					if (result.html == "") {

						if (WebLang == 'en') {
							$('#tags_div').html("<h3 style='text-align: center'>No advertisments found</h3>")
						} else {
							$('#tags_div').html("<h3 style='text-align: center'>لا يوجد اعلانات </h3>")
						}
					} else {

						$('#tags_div').html(result.html)
					}
				}
			})
		} else {

			$('#tags_div').html('')
			$('#tags_div').fadeOut()
		}
	})

	$('body').on('click', function() {
		$('#tags_div').fadeOut()
	})

	$('body').on('click', '#tags_div', function (event) {
		event.stopPropagation()
	})

	$('body').on('click', '.tag', function (event) {
		event.stopPropagation()
	})*/

    $('body').on('click' , '.header_search_icon' , function(){
        if($('.tag').val() != ''){
            if($('.search_header').first().attr('href')){
                window.location.href = $('.search_header').first().attr('href');
			}else {
				$('#head_form').submit();
			}
        }else {

        }
    })
	// click Css

	if($('#favorite-offers-container').hasClass('list')){
		$('#favorite-offers-container').removeClass('list')
		$('#favorite-offers-container').addClass('grid');
	}
	// where
	if($('.advertis_favorites_two_icon').hasClass('active')){
		$('.advertis_favorites_two_icon').removeClass('active')
		$('.advertis_favorites_one_icon').addClass('active')
	}
	$('.edit_size_img').css({
		width : '100% !important',
	});
	$('body').on('click','.one_version_style',function(){
        var token = $("input[name=_token]").val();
        $.ajax({
            type: 'post',
            url: base_url + '/set_grid_or_list',
            data: {
                _token: token,view : 'grid'
            },
            success: function (result) {

            }
        });

		if($('#offers-container').hasClass('list')){
            $('#offers-container').removeClass('list')
            $('#offers-container').addClass('grid')
		}
		// var top_adv2 = $('.top_adv2');
		// if(top_adv2.hasClass('top_adv2')){
		// 	top_adv2.addClass('top_adv');
		// 	top_adv2.removeClass('top_adv2');
		// }
		var wClass = $('.category_index_offers').hasClass('w100');
		if(wClass === true) {
			$('.category_index_offers').removeClass('w100');
		}
		$('.category_big_container').removeClass('only_padding');

        if($('.search_input_value').length != 0){
            $('.search_input_value').val('grid')
        }else {
            $('.buttons_for_open_inputs').after('<input type="hidden" name="style" class="search_input_value" value="grid">')
        }
	});

	$('body').on('click','.two_click_icon',function(){
        var token = $("input[name=_token]").val();
        $.ajax({
            type: 'post',
            url: base_url + '/set_grid_or_list',
            data: {
                _token: token,view : 'list'
            },
            success: function (result) {

            }
        });

        if($('#offers-container').hasClass('grid')){
            $('#offers-container').removeClass('grid')
            $('#offers-container').addClass('list')
        }
		// var top_adv = $('.top_adv');
		// if(top_adv.hasClass('top_adv')){
		// 	top_adv.addClass('top_adv2');
		// 	top_adv.removeClass('top_adv');
		// }
		var wClass = $('.category_index_offers').hasClass('w100');
		if(wClass === false) {
			$('.category_index_offers').addClass('w100');
		}

        if($('.search_input_value').length != 0){
			$('.search_input_value').val('list')
		}else {
            $('.buttons_for_open_inputs').after('<input type="hidden" name="style" class="search_input_value" value="list">')
        }

	});
	$('body').on('click','.download_app_click_div',function(){
		$('.download_app_click_div').toggle();
	})
	$('body').on('click','.li_click_app_download',function(){
		$('.download_icons_li').toggle();
	});
	$('body').on('click','.sub_menu_one_two',function(){
		$('.sub_menu_one_two').removeClass('color_one_two_icons_color');
        $('.js_png_color_mobile').removeClass('filter_png_color');
		$(this).toggleClass('color_one_two_icons_color');
	});
	$('body').on('click','.span_sort',function(){
		$(this).toggleClass('open');
	});
	$('.remove_banner_div').remove()
	$('body').on('click', '#header_notifications',function(){
		$('.profile_ul_navbar li').each(function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$(this).children('a').attr('aria-expanded',false);
				$('#notifications').addClass('active in');
			}
		});
		$('.profile_ul_navbar > li > a').each(function(){
			$('#'+$(this).attr('class')).removeClass('active in');
			if($(this).hasClass('notifications')){
				$(this).parent().addClass('active');
				$(this).attr('aria-expanded',true);
			}
			$('#notifications').addClass('active in');
		})
	});
	$('body').on('click', '#header_advertisments',function(){
		$('.profile_ul_navbar li').each(function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$(this).children('a').attr('aria-expanded',false);
				$('#advertisments').addClass('active in');
			}
		});
		$('.profile_ul_navbar > li > a').each(function(){
			$('#'+$(this).attr('class')).removeClass('active in');
			if($(this).hasClass('advertisments')){
				$(this).parent().addClass('active');
				$(this).attr('aria-expanded',true);
			}
			$('#advertisments').addClass('active in');
		})
	});
	$('body').on('click', '#header_favorite',function(){
		$('.profile_ul_navbar li').each(function(){

			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$(this).children('a').attr('aria-expanded',false);
				$('#favorite').addClass('active in');
			}
		});
		$('.profile_ul_navbar > li > a').each(function(){
			$('#'+$(this).attr('class')).removeClass('active in');
			if($(this).hasClass('favorite')){
				$(this).parent().addClass('active');
				$(this).attr('aria-expanded',true);
			}
			$('#favorite').addClass('active in');
		})
	});
	$('body').on('click',function () {
		if($('body').hasClass('barried')){
			$('body').removeClass('barried');
		}
	});
	$('body').on('click', '#mega-menu',function (event) {
		event.stopPropagation();
	});
	$('body').on('click','.js_background',function(){
		$('.js_background').removeClass('active');
        $('.js_background').removeAttr('style');
        $('.js_background').css({
            background: '#5688a9',
		});
		$(this).addClass('active');
        $(this).css({
            background: '#898989',
        });


	});
	$('body').on('click','.select_type',function(){
		$(this).toggleClass('open');
	})
	$('body').on('click','.js_png_color_mobile',function(){
        $('.sub_menu_one_two').removeClass('color_one_two_icons_color');
        $('.js_png_color_mobile').removeClass('filter_png_color');
		$(this).toggleClass('filter_png_color');
	});
	$('body').on('click','.mobile_download_li',function(){
		$('.mobile_download_div').toggle();
	});
	$('body').on('click','.header_cat_panel_mobile' , function(){
		if($(this).css('color') == 'rgb(177, 32, 118)'){
            $(this).css({color : '#64777d'});
		}else {
			$(this).removeAttr('style')
		}

		if($('#header-menu').hasClass('in')){
            $('#header-menu').removeClass('in')
		}


	});
	// if length == 0 , remove border -> div
	var filter_props_last = $('.mobile_v_props_border').last().next().length;
	if(filter_props_last == 0){
		$('.mobile_v_props_border').last().remove();
	}

	var category_list = true;
	$('body').on('click','#show_category_list' , function(){
        if(category_list) {

            $('#mega-menu').append(
            	'<div id="remove_load_parent_div">' +
					'<div class="load_category_list_mini_div">' +
						'<img src="'+base_url+'/assets/images/ajax-loader.gif" class="load_category_list_img" width="50" height="50">' +
					'</div>' +
				'</div>'
			);

            var token = $("input[name=_token]").val();
            $.ajax({
                type: 'post',
                url: base_url + '/get_category_list',
                data: {
                    _token: token,category_list:category_list
                },
                success: function (result) {
                    if(result === null){

                    }else if(typeof result == 'string'){
                        result = JSON.parse(result);
                    }
                    if (result.success) {
                        category_list = false;

                        $('#remove_load_parent_div').remove()
                        $('#category_list').html(result.html)

                    }
                }
            });
		}
	});


	/*mobile view search in header*/

	if(WebLang == 'en'){
        var search_text = 'Search';
	}else {
        var search_text = 'بحث';
	}
	$('body').on('click','.mobile_header_search',function(){
        $('body').attr('style','position:relative;')
		$('body').append('<div class="append_div_mobile_view_for_search" style="cursor: pointer">' +
							'<form class="append_div_mobile_view_for_search_form" method="POST" action="'+base_url+'search_tags" style="cursor: pointer">' +
								'<input type="text" name="tag" maxlength="45" class="append_div_mobile_view_for_search_form_input" placeholder="'+search_text+'">' +
								'<button type="submit" class="btn btn-primary append_div_mobile_view_for_search_form_button">'+search_text+'</button>' +
							'</form>' +
						'</div>')
    })


    /*mobile view search in header*/


    $('body').on('click','.append_div_mobile_view_for_search_form',function(e){
        e.stopPropagation();
    });
    $('body').on('click','.append_div_mobile_view_for_search',function(e){
        $('.append_div_mobile_view_for_search').remove();
    });
    /*mobile view search in header*/

	if (WebLang == 'en') {
		var element = $("#div-gpt-ad-5214826-4")
	} else {
		var element = $("#div-gpt-ad-3268511-4")
	}

	setTimeout(function(){
		var iFrameHeight = element.children().children().attr('height')


		if (iFrameHeight == 600) {
			$("#second_banner").css("height", "600px")
		}
	}, 2300);
});