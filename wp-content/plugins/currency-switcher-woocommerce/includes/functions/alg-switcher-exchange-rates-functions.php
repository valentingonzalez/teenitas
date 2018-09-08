<?php
/**
 * Currency Switcher Functions - Exchange Rates
 *
 * @version 2.9.0
 * @since   2.8.0
 * @author  Tom Anbinder
 */

if ( ! function_exists( 'alg_wc_cs_get_exchange_rate_google' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rate_google.
	 *
	 * @version 2.8.2
	 * @since   2.8.2
	 * @see     https://gist.github.com/daveismyname/8067095
	 */
	function alg_wc_cs_get_exchange_rate_google( $currency_from, $currency_to ) {
		$amount = 1;
		$url    = 'https://finance.google.com/finance/converter?a=' . $amount . '&from=' . $currency_from . '&to=' . $currency_to;
		if ( false != ( $response = alg_wc_cs_get_currency_exchange_rates_url_response( $url, false ) ) ) {
			preg_match( "/<span class=bld>(.*)<\/span>/", $response, $converted );
			if ( isset( $converted[1] ) ) {
				if ( $converted = preg_replace( "/[^0-9.]/", "", $converted[1] ) ) {
					if ( $return = round( $converted, ALG_WC_CS_EXCHANGE_RATES_PRECISION ) ) {
						return $return;
					}
				}
			}
		}
		return 0;
	}
}

if ( ! function_exists( 'alg_wc_cs_get_exchange_rate_georgia' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rate_georgia.
	 *
	 * @version 2.9.0
	 * @since   2.9.0
	 */
	function alg_wc_cs_get_exchange_rate_georgia( $currency_from, $currency_to ) {
		if ( ! class_exists( "SoapClient" ) ) {
			return 0;
		}
		$client = new SoapClient( 'https://services.nbg.gov.ge/Rates/Service.asmx?wsdl' );

		$currencies = "{$currency_from},{$currency_to}";
		$result     = $client->GetCurrentRates( array( 'Currencies' => $currencies ) );

		$rate_from = $result->GetCurrentRatesResult->CurrencyRate[0]->Rate;
		$rate_to   = $result->GetCurrentRatesResult->CurrencyRate[1]->Rate;
		if ( ! empty( $rate_from ) && ! empty( $rate_to ) ) {
			$final_rate = round( $rate_to / $rate_from, ALG_WC_CS_EXCHANGE_RATES_PRECISION );
		} else {
			$final_rate = 0;
		}

		return $final_rate;
	}
}

if ( ! function_exists( 'alg_wc_cs_get_exchange_rate_yahoo' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rate_yahoo.
	 *
	 * @version 2.8.0
	 * @since   2.2.0
	 * @todo    use `alg_wc_cs_get_currency_exchange_rates_url_response()`
	 */
	function alg_wc_cs_get_exchange_rate_yahoo( $currency_from, $currency_to ) {
		$currencies = array(
			'currency_from' => array(
				'name'     => $currency_from . '=X',
				'usd_rate' => false,
			),
			'currency_to' => array(
				'name'     => $currency_to . '=X',
				'usd_rate' => false,
			),
		);
		if ( ( $use_curl = function_exists( 'curl_version' ) ) || ini_get( 'allow_url_fopen' ) ) {
			$url = 'https://finance.yahoo.com/webservice/v1/symbols/allcurrencies/quote?format=json';
			if ( $use_curl ) {
				$curl = curl_init( $url );
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
				$response = curl_exec( $curl );
				curl_close( $curl );
			} else { // if ( ini_get( 'allow_url_fopen' ) )
				$response = file_get_contents( $url );
			}
			$response = json_decode( $response );
			if ( ! isset( $response->list->resources ) ) {
				return 0;
			}
			foreach ( $currencies as &$currency ) {
				foreach ( $response->list->resources as $resource ) {
					if ( isset( $resource->resource->fields->symbol ) && $currency['name'] === $resource->resource->fields->symbol ) {
						if ( ! isset( $resource->resource->fields->price ) ) {
							return 0;
						}
						$currency['usd_rate'] = $resource->resource->fields->price;
						break;
					}
				}
			}
		} elseif ( function_exists( 'simplexml_load_file' ) ) {
			$response = simplexml_load_file( 'https://finance.yahoo.com/webservice/v1/symbols/allcurrencies/quote?format=xml' );
			if ( ! isset( $response->resources->resource ) ) {
				return 0;
			}
			foreach ( $currencies as &$currency ) {
				foreach ( $response->resources->resource as $resource ) {
					$price  = false;
					$symbol = false;
					foreach ( $resource->field as $field_obj ) {
						$attributes = $field_obj->attributes();
						switch ( $attributes->name ) {
							case 'symbol':
								$symbol = (string) $field_obj;
								break;
							case 'price':
								$price = (float) $field_obj;
								break;
						}
					}
					if ( false != $symbol && $currency['name'] === $symbol ) {
						if ( ! $price ) {
							return 0;
						}
						$currency['usd_rate'] = $price;
						break;
					}
				}
			}
		}
		return ( false == $currencies['currency_to']['usd_rate'] || false == $currencies['currency_from']['usd_rate'] ? 0 :
			round( ( $currencies['currency_to']['usd_rate'] / $currencies['currency_from']['usd_rate'] ), ALG_WC_CS_EXCHANGE_RATES_PRECISION ) );
	}
}

if ( ! function_exists( 'alg_wc_cs_get_exchange_rate_ecb' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rate_ecb.
	 *
	 * @version 2.8.0
	 * @since   2.2.0
	 */
	function alg_wc_cs_get_exchange_rate_ecb( $currency_from, $currency_to ) {
		$final_rate = 0;
		if ( function_exists( 'simplexml_load_file' ) ) {
			$xml = simplexml_load_file( 'http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml' );
			if ( isset( $xml->Cube->Cube->Cube ) ) {
				if ( 'EUR' === $currency_from ) {
					$EUR_currency_from_rate = 1;
				}
				if ( 'EUR' === $currency_to ) {
					$EUR_currency_to_rate = 1;
				}
				foreach ( $xml->Cube->Cube->Cube as $currency_rate ) {
					$currency_rate = $currency_rate->attributes();
					if ( ! isset( $EUR_currency_from_rate ) && $currency_from == $currency_rate->currency ) {
						$EUR_currency_from_rate = (float) $currency_rate->rate;
					}
					if ( ! isset( $EUR_currency_to_rate ) && $currency_to == $currency_rate->currency ) {
						$EUR_currency_to_rate = (float) $currency_rate->rate;
					}
				}
				if ( isset( $EUR_currency_from_rate ) && isset( $EUR_currency_to_rate ) && 0 != $EUR_currency_from_rate ) {
					$final_rate = round( $EUR_currency_to_rate / $EUR_currency_from_rate, ALG_WC_CS_EXCHANGE_RATES_PRECISION );
				} else {
					$final_rate = 0;
				}
			}
		}
		return $final_rate;
	}
}

if ( ! function_exists( 'alg_wc_cs_get_exchange_rate_fixer_io' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rate_fixer_io.
	 *
	 * @version 2.7.0
	 * @since   2.7.0
	 */
	function alg_wc_cs_get_exchange_rate_fixer_io( $currency_from, $currency_to ) {
		return alg_wc_cs_get_exchange_rate_fixer_io_by_date( $currency_from, $currency_to, 'latest' );
	}
}

if ( ! function_exists( 'alg_wc_cs_get_exchange_rate_fixer_io_by_date' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rate_fixer_io_by_date.
	 *
	 * @version 2.8.0
	 * @since   2.7.0
	 */
	function alg_wc_cs_get_exchange_rate_fixer_io_by_date( $currency_from, $currency_to, $date ) {
		$url = 'https://api.fixer.io/' . $date . '?base=' . $currency_from . '&symbols=' . $currency_to;
		$response = alg_wc_cs_get_currency_exchange_rates_url_response( $url );
		return ( isset( $response->rates->{$currency_to} ) ? $response->rates->{$currency_to} : 0 );
	}
}

if ( ! function_exists( 'alg_wc_cs_get_exchange_rates_servers' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rates_servers.
	 *
	 * @version 2.9.0
	 * @since   2.8.0
	 */
	function alg_wc_cs_get_exchange_rates_servers() {
		return array(
			'ecb'             => __( 'European Central Bank', 'currency-switcher-woocommerce' ),
			'yahoo'           => __( 'Yahoo finance', 'currency-switcher-woocommerce' ),
			'fixer'           => __( 'Fixer.io', 'currency-switcher-woocommerce' ),
			'coinbase'        => __( 'Coinbase', 'currency-switcher-woocommerce' ),
			'coinmarketcap'   => __( 'CoinMarketCap', 'currency-switcher-woocommerce' ),
			'georgia'         => __( 'National Bank of Georgia', 'currency-switcher-woocommerce' ),
//			'google'          => __( 'Google', 'currency-switcher-woocommerce' ),
		);
	}
}

if ( ! function_exists( 'alg_wc_cs_get_exchange_rates_server_title' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rates_server_title.
	 *
	 * @version 2.8.0
	 * @since   2.8.0
	 */
	function alg_wc_cs_get_exchange_rates_server_title( $server_id ) {
		$servers = alg_wc_cs_get_exchange_rates_servers();
		return ( isset( $servers[ $server_id ] ) ? $servers[ $server_id ] : $server_id );
	}
}

if ( ! function_exists( 'alg_wc_cs_get_exchange_rate' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rate.
	 *
	 * @version 2.9.0
	 * @since   2.0.0
	 * @return  float rate on success, else 0
	 */
	function alg_wc_cs_get_exchange_rate( $currency_from, $currency_to ) {
		if ( 'default' === ( $server = get_option( 'alg_currency_switcher_exchange_rate_server_' . $currency_from . '_' . $currency_to, 'default' ) ) ) {
			$server = get_option( 'alg_currency_switcher_exchange_rate_server', 'ecb' );
		}
		$return = 0;
		switch ( $server ) {
			case 'yahoo':
				$return = alg_wc_cs_get_exchange_rate_yahoo( $currency_from, $currency_to );
				break;
			case 'fixer':
				$return = alg_wc_cs_get_exchange_rate_fixer_io( $currency_from, $currency_to );
				break;
			case 'coinbase':
				$return = alg_wc_cs_get_exchange_rate_coinbase( $currency_from, $currency_to );
				break;
			case 'coinmarketcap':
				$return = alg_wc_cs_get_exchange_rate_coinmarketcap( $currency_from, $currency_to );
				break;
			case 'georgia':
				$return = alg_wc_cs_get_exchange_rate_georgia( $currency_from, $currency_to );
			break;
			/* case 'google':
				$return = alg_wc_cs_get_exchange_rate_google( $currency_from, $currency_to );
				break; */
			default: // 'ecb'
				$return = alg_wc_cs_get_exchange_rate_ecb( $currency_from, $currency_to );
		}
		$return = apply_filters( 'alg_wc_cs_get_exchange_rate', $return, $server, $currency_from, $currency_to );
		if ( 'default' === get_option( 'alg_currency_switcher_exchange_rate_offset_type_' . $currency_from . '_' . $currency_to, 'default' ) ) {
			$offset = get_option( 'alg_currency_switcher_exchange_rate_offset', 0 );
		} else {
			$offset = get_option( 'alg_currency_switcher_exchange_rate_offset_' . $currency_from . '_' . $currency_to, 0 );
		}
		return ( 0 != $offset ? ( $offset / 100 * $return + $return ) : $return );
	}
}

if ( ! function_exists( 'alg_wc_cs_get_currency_exchange_rates_url_response' ) ) {
	/*
	 * alg_wc_cs_get_currency_exchange_rates_url_response.
	 *
	 * @version 2.8.2
	 * @since   2.8.0
	 */
	function alg_wc_cs_get_currency_exchange_rates_url_response( $url, $do_json_decode = true ) {
		$response = '';
		if ( function_exists( 'curl_version' ) ) {
			$curl = curl_init( $url );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
			$response = curl_exec( $curl );
			curl_close( $curl );
		} elseif ( ini_get( 'allow_url_fopen' ) ) {
			$response = file_get_contents( $url );
		}
		return ( '' != $response ? ( $do_json_decode ? json_decode( $response ) : $response ): false );
	}
}

if ( ! function_exists( 'alg_wc_cs_get_exchange_rate_coinmarketcap' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rate_coinmarketcap.
	 *
	 * @version 2.8.0
	 * @since   2.8.0
	 * @see     https://coinmarketcap.com/api/
	 * @todo    (maybe) `limit=0`
	 */
	function alg_wc_cs_get_exchange_rate_coinmarketcap( $currency_from, $currency_to, $try_reverse = true ) {
		$return = 0;
		if ( false != ( $response = alg_wc_cs_get_currency_exchange_rates_url_response( 'https://api.coinmarketcap.com/v1/ticker/?convert=' . $currency_to ) ) && is_array( $response ) ) {
			foreach ( $response as $pair ) {
				if ( isset( $pair->symbol ) && $currency_from === $pair->symbol ) {
					$att = 'price_' . strtolower( $currency_to );
					$return = ( isset( $pair->{$att} ) ? $pair->{$att} : 0 );
					break;
				}
			}
		}
		if ( 0 == $return && $try_reverse ) {
			$return = alg_wc_cs_get_exchange_rate_coinmarketcap( $currency_to, $currency_from, false );
			if ( 0 != $return ) {
				$return = round( ( 1 / $return ), ALG_WC_CS_EXCHANGE_RATES_PRECISION );
			}
		}
		return $return;
	}
}

if ( ! function_exists( 'alg_wc_cs_get_exchange_rate_coinbase' ) ) {
	/*
	 * alg_wc_cs_get_exchange_rate_coinbase.
	 *
	 * @version 2.8.0
	 * @since   2.8.0
	 */
	function alg_wc_cs_get_exchange_rate_coinbase( $currency_from, $currency_to ) {
		$response = alg_wc_cs_get_currency_exchange_rates_url_response( "https://api.coinbase.com/v2/exchange-rates?currency=$currency_from" );
		return ( isset( $response->data->rates->{$currency_to} ) ? $response->data->rates->{$currency_to} : 0 );
	}
}

if ( ! function_exists( 'alg_wc_cs_update_the_exchange_rates' ) ) {
	/**
	 * alg_wc_cs_update_the_exchange_rates.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @todo    add price filter widget and sorting by price support
	 */
	function alg_wc_cs_update_the_exchange_rates() {
		$currency_from = get_option( 'woocommerce_currency' );
		foreach ( alg_get_enabled_currencies() as $currency ) {
			if ( $currency_from != $currency ) {
				$the_rate = alg_wc_cs_get_exchange_rate( $currency_from, $currency );
				if ( 0 != $the_rate ) {
					update_option( 'alg_currency_switcher_exchange_rate_' . $currency_from . '_' . $currency, $the_rate );
				}
			}
		}
		/*
		if ( 'yes' === get_option( 'alg_price_by_country_price_filter_widget_support_enabled', 'no' ) ) {
			alg_update_products_price_by_country();
		}
		*/
	}
}

if ( ! function_exists( 'alg_wc_cs_get_currency_exchange_rate' ) ) {
	/**
	 * alg_wc_cs_get_currency_exchange_rate.
	 *
	 * @version 2.2.4
	 * @since   2.2.4
	 */
	function alg_wc_cs_get_currency_exchange_rate( $currency_code ) {
		$currency_from = get_option( 'woocommerce_currency' );
		return ( $currency_from == $currency_code ) ? 1 : get_option( 'alg_currency_switcher_exchange_rate_' . $currency_from . '_' . $currency_code, 1 );
	}
}
