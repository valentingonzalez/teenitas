(function($) {
	
	'use strict';
	
	// Extend core script
	$.extend($.nmTheme, {
		
		/**
		 *	Initialize cart scripts
		 */
		cart_init: function() {
			var self = this;
			
            
			// Init quantity buttons
            if($('body').hasClass('woocommerce-cart')) {
               self.quantityInputsBindButtons($('.woocommerce')); 
            }
            /* Bind: "added_to_cart" event (products can be added via cross sells) */
            self.$body.on('added_to_cart', function() {
                // Is the quick-view visible?
                if ($('#jws-quickview').is(':visible')) {
                    self.cartTriggerUpdate();
                }
            });  
            
		},
        
        
        /**
		 *	Trigger update button
		 */
        cartTriggerUpdate: function() {
            // Get original update button
            var $wooUpdateButton = $('div.woocommerce > form input[name="update_cart"]');

            // Remove "disabled" state/attribute
            $wooUpdateButton.prop('disabled', false);

            // Trigger "click" event
            setTimeout(function() { // Use a small timeout to make sure the element isn't disabled
                $wooUpdateButton.trigger('click');
            }, 100);
        }
		
	});
	
	// Add extension so it can be called from $.nmThemeExtensions
	$.nmThemeExtensions.cart = $.nmTheme.cart_init;
	
})(jQuery);