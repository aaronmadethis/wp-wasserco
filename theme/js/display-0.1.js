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

