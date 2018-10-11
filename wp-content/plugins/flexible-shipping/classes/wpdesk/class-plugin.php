<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

require_once 'functions.php';

if ( ! class_exists( 'WPDesk_Plugin_1_10' ) ) {

	require_once 'class-settings.php';

	/**
	 * Base plugin class for WP Desk plugins
	 *
	 * @author Grzegorz
	 *
	 */
	class WPDesk_Plugin_1_10 {

		const VERSION = '1.10';

		/** @var bool  */
		protected $plugin_is_active = true;

		/** @var array */
		protected $default_view_args;

		/** @var string  */
		public $plugin_namespace = 'wpdesk_plugin';

		/** @var string  */
		public $plugin_text_domain = 'wpdesk-plugin';

		/** @var bool  */
		public $plugin_has_settings = false;

		/** @var string */
		public $plugin_path;

		/** @var string */
		public $template_path;

		/** @var string */
		public $plugin_file_path;

		/** @var string */
		public $plugin_url;

		/** @var bool  */
		public $settings_url = false;

		/** @var bool  */
		public $docs_url = false;

		/** @var string  */
		public $default_settings_tab = 'general';

		public $settings_hooks = null;

		/** @var WPDesk_Settings_1_10 */
		public $settings = null;

		/** @var array  */
		public $options = null;

		protected function __construct( $base_file, $plugin_data = false ) {
			$this->init_base_variables( $base_file );
			if ( $this->plugin_is_active ) {
				if ( $this->plugin_has_settings ) {
					$this->settings = new WPDesk_Settings_1_10( $this, $this->get_namespace(), $this->default_settings_tab );
					$this->options  = $this->settings->get_settings();
				}
			}
			$this->hooks();
		}

		/**
		 * @return bool
		 */
		public function plugin_is_active() {
			return $this->plugin_is_active;
		}

		/**
		 * @return WPDesk_Settings_1_10
		 */
		public function get_settings() {
			return $this->settings;
		}

		/**
		 * @param $key
		 * @param $default
		 *
		 * @return mixed
		 */
		public function get_option( $key, $default ) {
			return $this->settings->get_option( $key, $default );
		}

		/**
		 * @return $this
		 */
		public function get_plugin() {
			return $this;
		}

		/**
		 * @return string
		 */
		public function get_text_domain() {
			return $this->plugin_text_domain;
		}

		/**
		 * @return void
		 */
		public function load_plugin_text_domain() {
			$wpdesk_translation = load_plugin_textdomain( 'wpdesk-plugin', false, $this->get_namespace() . '/classes/wpdesk/lang/' );
			$plugin_translation = load_plugin_textdomain( $this->get_text_domain(), false, $this->get_namespace() . '/lang/' );
		}

		/**
		 * @param string $base_file
		 */
		public function init_base_variables( $base_file ) {
			// Set Plugin Path
			$this->plugin_path = dirname( $base_file );

			// Set Plugin URL
			$this->plugin_url = plugin_dir_url( $base_file );

			$this->plugin_file_path = $base_file;

			$this->template_path = $this->get_namespace();

			$this->default_view_args = array(
				'plugin_url' => $this->get_plugin_url()
			);

		}

		/**
		 * @return void
		 */
		public function hooks() {

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

			add_action( 'plugins_loaded', array( $this, 'load_plugin_text_domain' ) );

			add_filter( 'plugin_action_links_' . plugin_basename( $this->get_plugin_file_path() ), array(
				$this,
				'links_filter'
			) );

		}

		/**
		 *
		 * @return string
		 */
		public function get_plugin_url() {
			return esc_url( trailingslashit( $this->plugin_url ) );
		}

		public function get_plugin_assets_url() {
			return esc_url( trailingslashit( $this->get_plugin_url() . 'assets' ) );
		}

		/**
		 * @return string
		 */
		public function get_template_path() {
			return trailingslashit( $this->template_path );
		}

		/**
		 * @return string
		 */
		public function get_plugin_file_path() {
			return $this->plugin_file_path;
		}

		/**
		 * @return string
		 */
		public function get_namespace() {
			return $this->plugin_namespace;
		}

		/**
		 * @return null
		 */
		public function get_settings_hooks() {
			return $this->settings_hooks;
		}


		/**
		 * Renders end returns selected template
		 *
		 * @param string $name name of the template
		 * @param string $path additional inner path to the template
		 * @param array $args args accesible from template
		 *
		 * @return string
		 */
		public function load_template( $name, $path = '', $args = array() ) {
			$plugin_template_path = trailingslashit( $this->plugin_path ) . 'templates/';

			// Look within passed path within the theme - this is priority.
			$template = locate_template(
				array(
					trailingslashit( $this->get_template_path() ) . trailingslashit( $path ) . $name . '.php',
				)
			);

			if ( ! $template ) {
				$template = $plugin_template_path . trailingslashit( $path ) . $name . '.php';
			}

			extract( $args );
			ob_start();
			include( $template );

			return ob_get_clean();
		}


		public function admin_enqueue_scripts( $hooq ) {
		}

		public function wp_enqueue_scripts() {
		}

		/**
		 * action_links function.
		 *
		 * @access public
		 *
		 * @param mixed $links
		 *
		 * @return array
		 */
		public function links_filter( $links ) {

			$support_link = get_locale() === 'pl_PL' ? 'https://www.wpdesk.pl/support/' : 'https://www.wpdesk.net/support';

			$plugin_links = array(
				'<a href="' . $support_link . '">' . __( 'Support', 'wpdesk-plugin' ) . '</a>',
			);
			$links        = array_merge( $plugin_links, $links );

			if ( $this->docs_url ) {
				$plugin_links = array(
					'<a href="' . $this->docs_url . '">' . __( 'Docs', 'wpdesk-plugin' ) . '</a>',
				);
				$links        = array_merge( $plugin_links, $links );
			}

			if ( $this->settings_url ) {
				$plugin_links = array(
					'<a href="' . $this->settings_url . '">' . __( 'Settings', 'wpdesk-plugin' ) . '</a>',
				);
				$links        = array_merge( $plugin_links, $links );
			}

			return $links;
		}

	}

}
