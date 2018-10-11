<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'wpdesk_is_plugin_active' ) ) {
	/**
	 * @param $plugin_file
	 *
	 * @return bool
	 * @deprecated 1.10 Use requirement class
	 */
	function wpdesk_is_plugin_active( $plugin_file ) {
		return WPDesk_Requirement_Checker_1_10::is_wp_plugin_active($plugin_file);
	}
}
