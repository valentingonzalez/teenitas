<?php
require_once( 'wpdesk/class-plugin.php' );
require_once( 'wpdesk/interface-plugin-factory.php' );
require_once( 'flexible-shipping-plugin.php' );


final class WPDesk_Flexible_Shipping_Factory implements WPDesk_Plugin_Factory_1_10 {

	const PHP_EXTENSION = '.php';
	/**
	 * @var WPDesk_Flexible_Shipping_Plugin
	 */
	private static $instance = null;

	/**
	 * Builds instance of plugin. If called more than once then more than one instance is created.
	 *
	 * @return WPDesk_Flexible_Shipping_Plugin
	 */
	public static function build_plugin() {
		$wpdesk_flexible_shipping_plugin_data = array();

		$class_name = apply_filters( self::WPDESK_FILTER_PLUGIN_CLASS, WPDesk_Flexible_Shipping_Plugin::class );

		$plugin_dir = dirname( dirname( __FILE__ ) );
		$plugin_file = trailingslashit( $plugin_dir ) . basename( $plugin_dir ) . self::PHP_EXTENSION;

		return new $class_name( $plugin_file, $wpdesk_flexible_shipping_plugin_data );
	}

	/**
	 * Builds instance if needed and ensures there is only one instance.
	 *
	 * @return WPDesk_Flexible_Shipping_Plugin
	 */
	public static function get_plugin_instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = self::build_plugin();
		}

		return self::$instance;
	}
}