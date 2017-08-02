function responsiveWidgets(){
	// alert('jhell');
	jQuery('.la-hover-plugin').css('width', '100%');
	jQuery('.la-hover-plugin').each(function() {
		var current_width = jQuery(this).width();
		var current_height = jQuery(this).height();
		// var current_wraper = jQuery(this).closest('.wcp-caption-plugin');
		jQuery(this).find('.ih-item.square,.ih-item.square .info').css({
			'width': current_width,
			// 'height': current_height
		});
	});
}

var resizeTimer;

jQuery(window).on('resize',function() {
    responsiveWidgets();
});

jQuery(window).load(function($) {
	if (jQuery(window).width()<=1024) {
		jQuery(window).trigger('resize');
	};
		

	// jQuery('.image-flip-up, .image-flip-down, .rotate-image-down, .tilt-image, .image-flip-right, .image-flip-left').closest('.image-caption-box').css('overflow', 'visible');
});