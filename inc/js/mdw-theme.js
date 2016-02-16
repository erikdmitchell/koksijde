/**
 * supporter functions for our theme
 */

jQuery(window).load(function() {

	jQuery('.mdw-wp-slider').mdwSlider();

});
/**
 * when a panel item (mobile nav) with children is clicked, this changes the +/- icon
 */
jQuery(document).on('click','.mdw-wp-theme-mobile-menu .panel-heading.menu-item-has-children a,.mdw-wp-theme-mobile-menu .panel-collapse .panel-heading a', function(e) {
	var $this=jQuery(this);

	if ($this.hasClass('collapsed')) {
		$this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
	} else {
		$this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
	}
});

/**
 * back to top button function
 */
jQuery(document).ready(function($){
	// browser window scroll (in pixels) after which the "back to top" link is shown
	var offset = 300,
		//browser window scroll (in pixels) after which the "back to top" link opacity is reduced
		offset_opacity = 1200,
		//duration of the top scrolling animation (in ms)
		scroll_top_duration = 700,
		//grab the "back to top" link
		$back_to_top = $('.mdw-back-to-top');

	//hide or show the "back to top" link
	$(window).scroll(function(){
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('btt-is-visible') : $back_to_top.removeClass('btt-is-visible btt-fade-out');
		if( $(this).scrollTop() > offset_opacity ) {
			$back_to_top.addClass('btt-fade-out');
		}
	});

	//smooth scroll to top
	$back_to_top.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({
			scrollTop: 0 ,
		 	}, scroll_top_duration
		);
	});

});

/**
 * sets the height of our carousel slider
 * because we need it to be responsive, this gets the height of the image and sizes accordingly
 * works on window load and resize
 */
(function($) {
	$.fn.mdwSlider=function(options) {
		var opts=$.extend({
			$item : $('.mdw-wp-slider .carousel-inner > .item'),
			$img : $('.mdw-wp-slider .carousel-inner > .item > img')
		}, options);

		var init = function() {
			setItemHeight();
		};

		var setItemHeight = function() {
			var maxHeight=9999;

			// gets the max height by finidng the smallest image size //
			opts.$img.each(function() {
				if ($(this).actual('outerHeight') && $(this).actual('outerHeight')<=maxHeight) {
					maxHeight=$(this).actual('outerHeight');
				}
			});

			// sets each item with out max height //
			opts.$item.each(function() {
				opts.$item.css({
					height : maxHeight
				});
			});

		};

		$(window).on('resize',function() {
			setItemHeight();
		});

		init();

	};
})(jQuery);

/**
 * this swaps out our caret and the position of our dropdown if the element is offscreen
 */
(function($) {

	$(".dropdown li").on('mouseenter mouseleave', function (e) {

		if ($(this).hasClass('dropdown')) {
			var $currentCaret=$(this).children('a').find('span');
			var $nextDropdownMenu=$(this).children('ul.dropdown-submenu');

			if ($nextDropdownMenu.is(':off-right')) {
				$nextDropdownMenu.addClass('flip-left');

				if ($currentCaret.hasClass('right-caret')) {
					$currentCaret.removeClass('right-caret').addClass('left-caret');
				}
			}
		}

	});

})(jQuery);

/*
 * jQuery offscreen plugin
 *
 * Filters that detect when an element is partially or completely outside
 * of the viewport.
 *
 *	Usage:
 *
 *		$('#element').is(':off-bottom')
 *
 * The above example returns true if #element's bottom edge is even 1px past
 * the bottom part of the viewport.
 *
 * Copyright Cory LaViska for A Beautiful Site, LLC. (http://www.abeautifulsite.net/)
 *
 * Licensed under the MIT license: http://opensource.org/licenses/MIT
 *
*/
(function($) {
	$.extend($.expr[':'], {
		'off-top': function(el) {
			return $(el).offset().top < $(window).scrollTop();
		},
		'off-right': function(el) {
			return $(el).offset().left + $(el).outerWidth() - $(window).scrollLeft() > $(window).width();
		},
		'off-bottom': function(el) {
			return $(el).offset().top + $(el).outerHeight() - $(window).scrollTop() > $(window).height();
		},
		'off-left': function(el) {
			return $(el).offset().left < $(window).scrollLeft();
		}
	});
})(jQuery);