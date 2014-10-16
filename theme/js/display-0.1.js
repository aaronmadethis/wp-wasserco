jQuery(document).ready(function($) {
	var win_w = $(window).width(),
		win_h = $(window).height(),
		has_video = $('html.video').length > 0 ? true : false,
		win_ratio,
		orientation,
		is_horizontal;

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

		var link = this,
			p_id = $(link).attr('data-post-id');
			data = {
				action: 'amt_investments_overlay',
				the_id: p_id
			}
		getFull = $.get(amt_investment_full.ajaxurl, data, function(data){
			open_investment_overlay(data);
		});

		e.preventDefault();
	});

	function open_investment_overlay(item_object){
		var obj = jQuery.parseJSON(item_object);
		console.log(obj);

		$('#overlay-wrapper .logo').css('background-image', 'url(' + obj.logo[0] + ')');
		$('#overlay-wrapper .primary').css('background-image', 'url(' + obj.img_pri[0] + ')');
		$('#overlay-wrapper .secondary').css('background-image', 'url(' + obj.img_sec[0] + ')');

		$('#overlay-wrapper .title').html(obj.title);
		$('#overlay-wrapper .init').html('Initial Investment: ' + obj.init);
		$('#overlay-wrapper .text').html(obj.text);
		$('#overlay-wrapper .button').html('<span></span>Visit ' + obj.title);
		$('#overlay-wrapper .button').attr('href', obj.url);
		
		$('#overlay-container').css({'visibility': 'visible'}).stop(true, true).animate({opacity: 1},400, function(){
			$('#overlay-wrapper').css({'display': 'block'}).stop(true, true).animate({opacity: 1},400);
		});	

		$('.overlay-close').click(function(e){
			getFull.abort();
			close_overlay();
			e.preventDefault();
		});
		$('.overlay-fill').click(function(e){
			getFull.abort();
			close_overlay();
			e.preventDefault();
		});

	}

	function close_overlay(){
		$('#overlay-container').animate({opacity: 0},400, function(){ $(this).css({'visibility': 'visible'}); });
		$('#overlay-wrapper').animate({opacity: 0},400, function(){
			$(this).css({'display': 'none', opacity: 0});
			$('#overlay-wrapper .logo, #overlay-wrapper .primary, #overlay-wrapper .secondary').css('background-image', '');
			$('.caption').html(' ');
			$('#overlay-wrapper .title, #overlay-wrapper .text').html(' ');
		});
	}

	/* ---------------------------------------------------------------------------------------
	TEAM BIO SWITCHER
	--------------------------------------------------------------------------------------- */
	function display_team_member(member_id){
		var id = member_id;

		$('.team_members .active').stop(true, true).animate({opacity: 0},400, function(){
			$(this).css({'visible': 'hidden', opacity: 0}).removeClass('active');
			$('.team_members').find('.' + id).addClass('active').css({'visibility': 'visible'}).stop(true, true).animate({opacity: 1},400);
		});
	}

	function init_team_member(){
		$('.team_menu .member_name a').click(function(e){
			if ( !$(this).parent().hasClass('active') ) {
				$('.team_menu').find('.active').removeClass('active');

				var id = $(this).parent().attr('data-id');
				$(this).parent().addClass('active');
				display_team_member(id );	
			}
			e.preventDefault();
		});
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

