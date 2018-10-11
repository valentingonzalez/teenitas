jQuery(document).on('ready', function($) {
    "use strict";
    jQuery('[data-modal]').click(function(e) {
        e.preventDefault();
        var scrollBarWidth = window.innerWidth - document.body.offsetWidth;
        var $modal = jQuery(jQuery(this).attr('href'));
		jQuery(document.body).css('margin-right', scrollBarWidth).addClass('showing-modal');
		$modal.parent().fadeIn();
		$modal.fadeIn();
		jQuery('.modal-wrapper').fadeIn().bind('click', function() {
            closeModal($modal);
        })
        $modal.children('.close-btn').mousedown(function(e) {
            closeModal($modal);
        })
        $modal.parent().bind('click', function(e) {
            if (e.target !== this)
                return;
            closeModal($modal);
        })
		$modal.parent().addClass('open');
    })
    function closeModal($modal) {
		jQuery(document.body).css('margin-right', '').removeClass('showing-modal');
		$modal.parent().fadeOut();
		$modal.fadeOut();
        jQuery('#modal-overlay').fadeOut().unbind('click');
        $modal.children('.close-modal').unbind('mousedown');
		$modal.parent().removeClass('open');
    }
});