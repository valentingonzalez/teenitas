<?php

function flexible_shipping_get_all_shipping_methods() {
	/*
	$all_shipping_methods = WC()->shipping()->get_shipping_methods();
	if ( empty( $all_shipping_methods ) ) {
		$all_shipping_methods = WC()->shipping()->load_shipping_methods();
	}
	*/
	$all_shipping_methods = WC()->shipping()->load_shipping_methods();
	return $all_shipping_methods;
}


function flexible_shipping_method_selected_in_cart( $shipping_method_integration ) {
	global $woocommerce;
	$shippings = $woocommerce->session->get('chosen_shipping_methods');
	$all_shipping_methods = flexible_shipping_get_all_shipping_methods();
	$flexible_shipping = $all_shipping_methods['flexible_shipping'];
	$flexible_shipping_rates = $flexible_shipping->get_all_rates();
	foreach ( $shippings as $id => $shipping ) {
		if ( isset( $flexible_shipping_rates[$shipping] ) ) {
			$shipping_method = $flexible_shipping_rates[$shipping];
			if ( $shipping_method['method_integration'] == $shipping_method_integration ) {
				return $shipping_method;
			}
		}
	}
	return false;
}

function flexible_shipping_method_selected( $order, $shipping_method_integration ) {
	if ( is_numeric( $order ) ) {
		$order = wc_get_order( $order );
	}
	$shippings = $order->get_shipping_methods();
	$all_shipping_methods = flexible_shipping_get_all_shipping_methods();
	if ( isset( $all_shipping_methods['flexible_shipping'] ) ) {
		$flexible_shipping_rates = $all_shipping_methods['flexible_shipping']->get_all_rates();
		foreach ( $shippings as $id => $shipping ) {
			if ( isset( $flexible_shipping_rates[ $shipping['method_id'] ] ) ) {
				$shipping_method = $flexible_shipping_rates[ $shipping['method_id'] ];
				if ( $shipping_method['method_integration'] == $shipping_method_integration ) {
					return $shipping_method;
				}
			}
		}
	}
	return false;
}

function flexible_shipping_get_integration_for_method( $method_id ) {
	$all_shipping_methods = flexible_shipping_get_all_shipping_methods();
	if ( isset( $all_shipping_methods['flexible_shipping'] ) ) {
		$flexible_shipping_rates = $all_shipping_methods['flexible_shipping']->get_all_rates();
		if ( isset( $flexible_shipping_rates[$method_id] ) ) {
			return $flexible_shipping_rates[$method_id]['method_integration'];
		}
	}
	return false;
}

if ( !function_exists('wpdesk_redirect') ) {
	function wpdesk_redirect( $redirect ) {
		if ( 1==1 && headers_sent() ) {
			?>
			<span><?php printf( __( 'Redirecting. If page not redirects click %s here %s.', 'flexible-shipping'), '<a href="' . $redirect . '" >', '</a>' ); ?></span>

			<script>
                parent.location.replace('<?php echo $redirect; ?>');
			</script>
			<?php
		}
		else {
			wp_safe_redirect($redirect);
		}
		exit;
	}
}

if ( !function_exists( 'wpdesk__' ) ) {
	function wpdesk__( $text, $domain ) {
		if ( function_exists( 'icl_sw_filters_gettext' ) ) {
			return icl_sw_filters_gettext( $text, $text, $domain, $text );
		}
		if ( function_exists( 'pll__' ) ) {
			return pll__( $text );
		}
		return __( $text, $domain );
	}
}

if ( !function_exists( 'wpdesk__e' ) ) {
	function wpdesk__e( $text, $domain ) {
		echo wpdesk__( $text, $domain );
	}
}


