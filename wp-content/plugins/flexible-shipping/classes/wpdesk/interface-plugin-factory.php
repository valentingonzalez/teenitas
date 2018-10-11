<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( !interface_exists( 'WPDesk_Plugin_Factory_1_10' ) ) {
	interface WPDesk_Plugin_Factory_1_10 {
		const WPDESK_FILTER_PLUGIN_CLASS = 'wpdesk_plugin_class';

		static function build_plugin();

		static function get_plugin_instance();
	}
}