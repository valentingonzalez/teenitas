<?php
require_once( 'wpdesk/class-plugin.php' );

class WPDesk_Flexible_Shipping_Plugin extends WPDesk_Plugin_1_10 {

	/**
	 * @var string
	 */
	private $scripts_version = '60';

	/**
	 * @var WPDesk_Flexible_Shipping_Admin_Notices
	 */
	public $admin_notices;

	/**
	 * Is order processed on checkout?
	 *
	 * @var bool
	 */
	private $is_order_processed_on_checkout = false;
	
	/**
	 * WPDesk_Flexible_Shipping_Plugin constructor.
	 *
	 * @param $base_file
	 * @param $plugin_data
	 */
	public function __construct( $base_file, $plugin_data ) {
		$this->plugin_namespace   = 'flexible-shipping';
		$this->plugin_text_domain = 'flexible-shipping';

		$this->plugin_has_settings  = false;
		$this->default_settings_tab = 'welcome';

		parent::__construct( $base_file, $plugin_data );

		if ( $this->plugin_is_active() ) {
			$this->init();
			$this->hooks();
		}
	}

	/**
	 *
	 */
	private function load_dependencies() {
		require_once('shipment/cpt-shipment.php');
		new WPDesk_Flexible_Shipping_Shipment_CPT( $this );

		require_once('manifest/cpt-shipping-manifest.php');
		new WPDesk_Flexible_Shipping_Shipping_Manifest_CPT( $this );

		require_once('shipment/ajax.php');
		new WPDesk_Flexible_Shipping_Shipment_Ajax( $this );

		require_once('shipment/class-shipment.php');
		require_once('shipment/interface-shipment.php');
		require_once('shipment/functions.php');

		require_once('manifest/class-manifest.php');
		require_once('manifest/interface-manifest.php');
		require_once('manifest/functions.php');
		require_once('manifest/class-manifest-fs.php');

		require_once('bulk-actions.php');
		new WPDesk_Flexible_Shipping_Bulk_Actions();

		require_once('order-add-shipping.php');
		new WPDesk_Flexible_Shipping_Add_Shipping();

		require_once( 'shipping-method.php' );
		require_once( 'shipping-method-info.php' );

		require_once( 'flexible-shipping-export.php' );
		new WPDesk_Flexible_Shipping_Export( $this );

		require_once( 'multilingual.php' );
		new WPDesk_Flexible_Shipping_Multilingual( $this );

		require_once( 'multicurrency.php' );
		new WPDesk_Flexible_Shipping_Multicurrency( $this );

		require_once( 'admin-notices.php' );
		$this->admin_notices = new WPDesk_Flexible_Shipping_Admin_Notices( $this );
	}

	/**
	 *
	 */
	public function init() {
		$this->load_dependencies();
	}

	/**
	 *
	 */
	public function hooks() {
		parent::hooks();
		
		add_filter( 'woocommerce_shipping_methods', array( $this, 'woocommerce_shipping_methods_filter' ), 10, 1 );
		
		add_action( 'admin_init', array( $this, 'session_init') );

		add_action( 'woocommerce_after_shipping_rate', array( $this, 'woocommerce_after_shipping_rate' ), 10, 2 );

		add_action( 'flexible_shipping_method_rate_id', array( $this, 'flexible_shipping_method_rate_id' ), 9999999, 2 );

		add_filter( 'woocommerce_shipping_chosen_method', array( $this, 'woocommerce_shipping_chosen_method' ), 10, 2);

		add_action( 'woocommerce_checkout_update_order_meta', array(
			$this,
			'add_flexible_shipping_order_meta_on_checkout_woo_pre_27'
		) );

		add_action( 'woocommerce_checkout_create_order', array(
			$this,
			'add_flexible_shipping_order_meta_on_checkout'
		) );

		add_filter( 'option_woocommerce_cod_settings', array( $this, 'option_woocommerce_cod_settings' ) );

	}
	
	/**
	 * @param $methods
	 *
	 * @return mixed
	 */
	public function woocommerce_shipping_methods_filter( $methods ) {
		$methods['flexible_shipping'] = 'WPDesk_Flexible_Shipping';
		$methods['flexible_shipping_info'] = 'WPDesk_Flexible_Shipping_Info';
		return $methods;
	}
	
	
	/**
	 * @param array $value
	 *
	 * @return array
	 */
	public function option_woocommerce_cod_settings( $value ) {
		if ( is_checkout() ) {
			if (
				!empty( $value )
				&& is_array( $value )
				&& $value['enabled'] == 'yes'
				&& !empty( $value['enable_for_methods'] )
				&& is_array( $value['enable_for_methods'] )
			) {
				foreach ( $value['enable_for_methods'] as $method ) {
					if ( $method == 'flexible_shipping' ) {
						$all_fs_methods = flexible_shipping_get_all_shipping_methods();
						$all_shipping_methods = flexible_shipping_get_all_shipping_methods();
						$flexible_shipping = $all_shipping_methods['flexible_shipping'];
						$flexible_shipping_rates = $flexible_shipping->get_all_rates();
						foreach ( $flexible_shipping_rates as $flexible_shipping_rate ) {
							$value['enable_for_methods'][] = $flexible_shipping_rate['id_for_shipping'];
						}
						break;
					}
				}
			}
		}
		return $value;
	}

	/**
	 *
	 */
	public function session_init() {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		if ( ! session_id() ) {
			session_start();
		}
	}

	/**
	 * Add flexible shipping order meta on checkout.
	 *
	 * @param WC_Order $order Order.
	 */
	public function add_flexible_shipping_order_meta_on_checkout( WC_Order $order ) {
		if ( ! $this->is_order_processed_on_checkout ) {
			$this->is_order_processed_on_checkout = true;
			$order_shipping_methods               = $order->get_shipping_methods();
			foreach ( $order_shipping_methods as $shipping_id => $shipping_method ) {
				if ( isset( $shipping_method['item_meta'] )
				     && isset( $shipping_method['item_meta']['_fs_method'] )
				) {
					$fs_method = $shipping_method['item_meta']['_fs_method'];
					if ( ! empty( $fs_method['method_integration'] ) ) {
						$order->add_meta_data( '_flexible_shipping_integration', $fs_method['method_integration'] );
					}
				}
			}
		}
	}

	/**
	 * Add flexible shipping order meta on checkout (for WooCommerce versions before 2.7).
	 *
	 * @param int $order_id Order id.
	 */
	public function add_flexible_shipping_order_meta_on_checkout_woo_pre_27( $order_id ) {
		if ( version_compare( WC_VERSION, '2.7', '<' ) ) {
			if ( ! $this->is_order_processed_on_checkout ) {
				$this->is_order_processed_on_checkout = true;
				$order                                = wc_get_order( $order_id );
				$order_shipping_methods               = $order->get_shipping_methods();
				foreach ( $order_shipping_methods as $shipping_id => $shipping_method ) {
					if ( isset( $shipping_method['item_meta'] )
					     && isset( $shipping_method['item_meta']['_fs_method'] )
					     && isset( $shipping_method['item_meta']['_fs_method'][0] )
					) {
						$fs_method = unserialize( $shipping_method['item_meta']['_fs_method'][0] );
						if ( ! empty( $fs_method['method_integration'] ) ) {
							add_post_meta( $order->id, '_flexible_shipping_integration', $fs_method['method_integration'] );
						}
					}
				}
			}
		}
	}

	/**
	 * @param $method
	 * @param $available_methods
	 *
	 * @return mixed
	 */
	function woocommerce_shipping_chosen_method( $method, $available_methods ) {
		$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods', array() );
		if ( isset( $chosen_shipping_methods[0] ) ) {
			foreach ($available_methods as $available_method ) {
				if ( $available_method->id ==
				     $chosen_shipping_methods[0] ) {
					$method = $available_method->id;
					break;
				}
			}
		}
		return $method;
	}

	/**
	 * @param $hooq
	 */
	public function admin_enqueue_scripts( $hooq ) {
		$current_screen = get_current_screen();
		if ( $current_screen->id === 'woocommerce_page_wc-settings' || $current_screen->id === 'edit-shop_order' || $current_screen->id === 'shop_order' ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_register_script( 'fs_admin', trailingslashit( $this->get_plugin_assets_url() ) . 'js/admin' . $suffix . '.js', array( 'jquery' ), $this->scripts_version );
			wp_localize_script( 'fs_admin', 'fs_admin', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			));
			wp_enqueue_script( 'fs_admin' );
			wp_enqueue_style( 'fs_admin', trailingslashit( $this->get_plugin_assets_url() ) . 'css/admin' . $suffix . '.css', array(), $this->scripts_version );
			wp_enqueue_style( 'fs_font', trailingslashit( $this->get_plugin_assets_url() ) . 'css/font' . $suffix . '.css', array(), $this->scripts_version );
		}
	}

	/**
	 * @param array $links
	 *
	 * @return array
	 */
	public function links_filter( $links ) {
		$docs_link = get_locale() === 'pl_PL' ? 'https://www.wpdesk.pl/docs/flexible-shipping-pro-woocommerce-docs/' : 'https://www.wpdesk.net/docs/flexible-shipping-pro-woocommerce-docs/';
		$support_link = get_locale() === 'pl_PL' ? 'https://www.wpdesk.pl/support/' : 'https://www.wpdesk.net/support';

		$docs_link .= '?utm_source=wp-admin-plugins&utm_medium=quick-link&utm_campaign=flexible-shipping-docs-link';

		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=shipping&section=flexible_shipping_info') . '">' . __( 'Settings', 'flexible-shipping' ) . '</a>',
			'<a href="' . $docs_link . '">' . __( 'Docs', 'flexible-shipping' ) . '</a>',
			'<a href="' . $support_link . '">' . __( 'Support', 'flexible-shipping' ) . '</a>',
		);
		$pro_link = get_locale() === 'pl_PL' ? 'https://www.wpdesk.pl/sklep/flexible-shipping-pro-woocommerce/' : 'https://www.wpdesk.net/products/flexible-shipping-pro-woocommerce/';
		$utm = '?utm_source=wp-admin-plugins&utm_medium=link&utm_campaign=flexible-shipping-plugins-upgrade-link';

		if ( ! wpdesk_is_plugin_active( 'flexible-shipping-pro/flexible-shipping-pro.php' ) )
			$plugin_links[] = '<a href="' . $pro_link . $utm . '" target="_blank" style="color:#d64e07;font-weight:bold;">' . __( 'Upgrade', 'flexible-shipping' ) . '</a>';
		return array_merge( $plugin_links, $links );
	}


	/**
	 * @param WC_Shipping_Rate $method
	 * @param int $index
	 */
	public function woocommerce_after_shipping_rate( $method, $index ) {
		if ( $method->method_id == 'flexible_shipping' ) {
			$description = WC()->session->get('flexible_shipping_description_' . $method->id, false );
			if ( $description && $description != '' ) {
				echo $this->load_template(
					'flexible-shipping/after-shipping-rate',
					'cart/',
					array(
						'method_description' 	=> $description,
					)
				);
			}
		}
	}

	/**
	 * @param string $method_id
	 * @param array $shipping_method
	 *
	 * @return string
	 */
	public function flexible_shipping_method_rate_id( $method_id, array $shipping_method ) {
		if ( isset( $shipping_method['id_for_shipping'] ) && $shipping_method['id_for_shipping'] != '' ) {
			$method_id = $shipping_method['id_for_shipping'];
		}
		return $method_id;
	}

}
