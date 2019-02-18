(function($) {
	var date = new Date();
	date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
	jQuery(document).on('click', '.language .dropdown-menu .dropdown-item', function() {
		var lang = jQuery(this).data('lang');
		var host = window.location.host;
		var locationHost = window.location.protocol + '//' + host;
		$.cookie(
			"language", 
			lang, 
			{
				path: "/", 
				domain: host,
				expires: date//,
				//secure: true
			}
		);
		location.reload();
	});
	jQuery(document).on('mouseenter', '.dropdown', function() {
		jQuery(this).find('.btn-cafemart').addClass('active');
	});
	jQuery(document).on('mouseleave', '.dropdown', function() {
		jQuery(this).find('.btn-cafemart').removeClass('active');
	});
})(jQuery);