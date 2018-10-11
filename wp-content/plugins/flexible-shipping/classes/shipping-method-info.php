<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'WPDesk_Flexible_Shipping_Info' ) ) {
	
	class WPDesk_Flexible_Shipping_Info extends WC_Shipping_Method {
		
		/**
		 * WPDesk_Flexible_Shipping_Fake_Method constructor.
		 *
		 * @param int $instance_id
		 */
		public function __construct( $instance_id = 0 ) {
			parent::__construct( $instance_id );
			$this->id           = 'flexible_shipping_info';
			$this->enabled      = 'no';
			$this->method_title = __( 'Flexible Shipping', 'flexible-shipping' );
			
			$this->supports = array(
				'settings',
			);
			
		}
		
		/**
		 * @param array $form_fields
		 * @param bool  $echo
		 *
		 * @return string
		 */
		public function generate_settings_html( $form_fields = array(), $echo = true ) {
			ob_start();
			include( 'views/html-shipping-method-info-description.php' );
			$html = ob_get_clean();
			if ( $echo ) {
				echo $html;
			} else {
				return $html;
			}
		}
		
	}
	
}
