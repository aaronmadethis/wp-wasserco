jQuery(document).ready(function($) {
	var win_w = $(window).width(),
		win_h = $(window).height(),
		has_video = $('html.video').length > 0 ? true : false,
		win_ratio,
		orientation,
		is_horizontal,
		is_mobile;

	/* ---------------------------------------------------------------------------------------
	TEST ORIENTATION OF TABLET AND PHONE
	--------------------------------------------------------------------------------------- */
	function doOnOrientationChange(){
		switch(window.orientation){  
			case -90:
			case 90:
				$('body').addClass('landscape').removeClass('portrait');
				orientation = 'landscape';
				break; 
			case 0:
				$('body').addClass('portrait').removeClass('landscape');
				orientation = 'portrait';
				break; 
		}
		win_w = $(window).width();
		win_h = $(window).height();
	}
	window.addEventListener('orientationchange', doOnOrientationChange);
	doOnOrientationChange();

	function check_mobile(){
		is_mobile = win_w < 767 ? true : false;
		return is_mobile;
	}

	/* ---------------------------------------------------------------------------------------
	DROPDOWN FIX FOR IE
	--------------------------------------------------------------------------------------- */
	sfHover = function() {
		var sfEls = document.getElementById("nav").getElementsByTagName("LI");
		for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() {
				this.className+=" sfhover";
			}
			sfEls[i].onmouseout=function() {
				this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
			}
		}
	}
	if (window.attachEvent) window.attachEvent("onload", sfHover);
	

	/* ---------------------------------------------------------------------------------------
	NAV MENU OPEN AND CLOSE
	--------------------------------------------------------------------------------------- */
	// if(win_w < 992){
	// 	$('body').addClass('is-mobile');
	// }

	$('.open-nav-menu, .close-nav-menu').click(function(e) {
	    var open, top;
	    top = $(document).scrollTop();
	    open = $('nav.mobile').is('.nav-menu-open');
	    $('nav.mobile').toggleClass('nav-menu-open', !open);
	    if(win_w < 768){
	     	$('body').toggleClass('is-mobile', !open);
	     }
	    if (!$("html").is(".ie")) {
	        if (open) {
	            setTimeout(function() {
	                return $('.primary-header, .nav-menu').css('top', 0);
	            }, 500);
	        } else {
	            $('.primary-header, .nav-menu').css('top', top);
	        }
	    }
	    e.preventDefault();
	    return e.stopPropagation();
	});
	$('.nav-menu a').click(function(e) {
	    return e.stopPropagation();
	});
	$('.content-wrapper, header').click(function(e) {
	    if ($('nav.mobile').is('.nav-menu-open')) {
	        $('nav.mobile').removeClass('nav-menu-open');
	        return $('.primary-header, .nav-menu').css('top', 0);
	    }
	});

	$('nav.mobile li.menu-item-has-children a').not( 'ul.sub-menu a' ).click(function(e) {
		open = $(this).parent().is('.sub-open');
		if (!open) {
			$('nav.mobile .sub-open').removeClass('sub-open');
			$(this).parent().addClass('sub-open');
		}else{
			$(this).parent().removeClass('sub-open');
		}
		e.preventDefault();
	});


	/* ---------------------------------------------------------------------------------------
	HEIGHT FIX FOR 2UP LAYOUT
	--------------------------------------------------------------------------------------- */
	function set_two_up_height(){
		var h1 = $('.layout_two_up .cta:eq(0)').height(),
			h2 = $('.layout_two_up .cta:eq(1)').height();

		if(h1 > h2){
			$('.layout_two_up .cta:eq(1)').css('height', h1);
		}else if(h2 > h1){
			$('.layout_two_up .cta:eq(0)').css('height', h2);
		}
	}
	if( $('.layout_two_up').length > 0){
		set_two_up_height();
	}

	/* ---------------------------------------------------------------------------------------
	SIMPLE AJAX TO RETURN INVESTMENT IMAGES AND DESCRIPTION
	--------------------------------------------------------------------------------------- */
	var getFull;
	$('.open_overlay').click(function(e) {

		$('#overlay-wrapper').css({'display': 'block'}).stop(false, true).animate({opacity: 1},400);

		if( check_mobile() ){
			var aTag = $("#all-wrapper");
			$('html,body').animate({scrollTop: (aTag.offset().top)},'fast');
		}

		var link = this,
			p_id = $(link).attr('data-post-id');
			data = {
				action: 'amt_investments_overlay',
				the_id: p_id
			}
		/*getFull = $.get(amt_investment_full.ajaxurl, data, function(data){
			open_investment_overlay(data);
		});*/
		getFull = $.get(amt_investment_full.ajaxurl, data)
			.done(function(data){
				open_investment_overlay(data);
			});

		e.preventDefault();
		return e.stopPropagation();
	});

	function open_investment_overlay(item_object){
		var obj = jQuery.parseJSON(item_object);
		console.log(obj);

		$('#overlay-wrapper .preloader_png').fadeOut("fast");

		$('#overlay-wrapper .logo').css('background-image', 'url(' + obj.logo[0] + ')');
		$('#overlay-wrapper .primary').css('background-image', 'url(' + obj.img_pri[0] + ')');
		$('#overlay-wrapper .secondary').css('background-image', 'url(' + obj.img_sec[0] + ')');

		$('#overlay-wrapper .title').html(obj.title);
		// $('#overlay-wrapper .init').html('Initial Investment: ' + obj.init);
		$('#overlay-wrapper .text').html(obj.text);
		$('#overlay-wrapper .button').html('<span></span>Visit ' + obj.title);
		$('#overlay-wrapper .button').attr('href', obj.url);

		//console.log("Button URL: " + obj.url);

		if(obj.url == ""){
			$('#overlay-wrapper .button').css("display", "none");
		}else{
			$('#overlay-wrapper .button').attr("style", " ");
		}
		
		$('#overlay-container').css({'visibility': 'visible'}).stop(true, true).animate({opacity: 1},400, function(){
			$('#overlay-wrapper').css({'display': 'block'}).stop(true, true).animate({opacity: 1},400);
		});	

		$('.overlay-close').click(function(e){
			// getFull.abort();
			close_overlay();
			obj = "";
			e.preventDefault();
			return e.stopPropagation();
		});
		$('.overlay-fill').click(function(e){
			// getFull.abort();
			close_overlay();
			obj = "";
			e.preventDefault();
			return e.stopPropagation();
		});
		getFull.abort();

	}

	function close_overlay(){
		$('#overlay-container').animate({opacity: 0},400, function(){ $(this).css({'visibility': 'visible'}); });
		$('#overlay-wrapper').animate({opacity: 0},400, function(){
			$(this).css({'display': 'none', opacity: 0});
			$('#overlay-wrapper .logo, #overlay-wrapper .primary, #overlay-wrapper .secondary').css('background-image', '');
			$('.caption').html(' ');
			$('#overlay-wrapper .title, #overlay-wrapper .text').html(' ');
			getFull.abort();
			$('#overlay-wrapper .preloader_png').fadeIn("fast");
		}).dequeue();
	}

	/* ---------------------------------------------------------------------------------------
	TEAM BIO SWITCHER
	--------------------------------------------------------------------------------------- */
	function display_team_member(member_id){
		var id = member_id;

		if( $('.team_members .active').length > 0 ){
			$('.team_members .active').animate({opacity: 0},100, function(){
				$(this).css({'visible': 'hidden', opacity: 0}).removeClass('active');
				$('.team_members').find('.' + id).addClass('active').css({'visibility': 'visible'}).animate({opacity: 1},200);
			});
		}else{
			$('.team_members').find('.' + id).addClass('active').css({'visibility': 'visible'}).animate({opacity: 1},200);
		}
		var win_url = window.location.href.split('#')[0],
			final_url = win_url + "#" + id;
		history.pushState({}, 'page', final_url);
	}

	function init_team_member(){
		hash_check();

		$('.team_menu .member_name a, .cell a').click(function(e){
			if ( !$(this).parent().hasClass('active') ) {
				check_grid();
				$('.team_menu').find('.active').removeClass('active');

				var id = $(this).parent().attr('data-id');
				$('.team_menu').find('.' + id).addClass('active');
				display_team_member(id );
				scrollToAnchor();
			}
			e.preventDefault();
		});
	}

	function check_grid(){
		var off = $('.bio_grid').hasClass('off');
		if( !off ){
			$('.bio_grid').animate({opacity: 0},100, function(){
				$(this).css({'display': 'none', opacity: 0}).addClass('off');
				$('.members-wrap').css('position', 'relative');
			});
		}
	}

	function scrollToAnchor(){
	    var aTag = $(".team_members");
	    $('html,body').animate({scrollTop: (aTag.offset().top - 100)},'fast');
	}

	function hash_check(){
		var hash = location.hash.replace('#', '');

		if(hash.length > 0){
			check_grid();
			if( check_mobile() ){
				var aTag = $('.team_members .' + hash);
				$('html,body').animate({scrollTop: (aTag.offset().top)},'fast');
			}else{
				$('.team_menu').find('.' + hash).addClass('active');
				$('.team_members').find('.' + hash).addClass('active').css({'visibility': 'visible'}).animate({opacity: 1},200);
				scrollToAnchor();
			}
		}
	}

	if( $('.team_menu').length > 0 ){
		init_team_member();
	}

	/* ---------------------------------------------------------------------------------------
	TAB SWITCHER
	--------------------------------------------------------------------------------------- */
	function display_tab(tab_index){
		var id = tab_index;

		$('.tabs .active').stop(true, true).animate({opacity: 0},0, function(){
			$(this).css({'visible': 'hidden', opacity: 0}).removeClass('active');
			$('.tabs .single_tab').eq(id).addClass('active').css({'visibility': 'visible'}).stop(true, true).animate({opacity: 1},0);
		});
	}

	function init_tabs(){
		/*var tallest = 0,
			h = 0;

		$('.single_tab').each(function(i){
			if( $(this).height() > h ){
				h = $(this).height();
				tallest = i;
			}
		});
		$('.single_tab').eq(tallest).css('position', 'relative');*/


		$('.tab_nav .tab_menu a').click(function(e){
			if ( !$(this).parent().hasClass('active') ) {
				$('.tab_nav').find('.active').removeClass('active');

				var tab_index = $(this).parent().index();
				$(this).parent().addClass('active');
				display_tab(tab_index);	
			}
			e.preventDefault();
		});
	}

	if( $('.layout_tabs').length > 0 ){
		init_tabs();
	}


	/* ---------------------------------------------------------------------------------------
	WINDOW RATIO
	--------------------------------------------------------------------------------------- */
	function set_window_ratio(){
		win_ratio = win_w / win_h;
		is_horizontal = false;
		
		if(win_ratio < 1) is_horizontal = true;
	}
	set_window_ratio();

	/* ---------------------------------------------------------------------------------------
	WINDOW RESIZE
	--------------------------------------------------------------------------------------- */		
	var rtime = new Date(1, 1, 2000, 12,00,00),
		timeout = false;
		delta = 50;
		
	$(window).resize(function() {
		$('#inset').attr({style: ''});
	    rtime = new Date();
	    if (timeout === false) {
	        timeout = true;
	        setTimeout(resize_end, delta);
	    }
	});

	function resize_end() {
	    if (new Date() - rtime < delta) {
	        setTimeout(resize_end, delta);
	    } else {
	        timeout = false;
	        win_w = $(window).width();
			win_h = $(window).height();
			set_window_ratio();
	    }               
	}

});

