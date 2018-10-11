<?php
	$pl = get_locale() === 'pl_PL';
	$youtube_url = 'https://www.youtube.com/embed/qsFvYoiNDgU';
	$general_settings_url = $pl ? 'https://www.wpdesk.pl/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=general-settings#Ustawienia_glowne' : 'https://www.wpdesk.net/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=general-settings#General_Settings';
	$adding_a_shipping_method_url = $pl ? 'https://www.wpdesk.pl/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=adding-a-shipping-method#Metody_wysylki' : 'https://www.wpdesk.net/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=adding-a-shipping-method#Shipping_Methods';
	$currency_support_url = $pl ? 'https://www.wpdesk.pl/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=currency-support#Waluty' : 'https://www.wpdesk.net/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=currency-support#Currency_Support';
	$weight_based_shipping_url = $pl ? 'https://www.wpdesk.pl/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=weight-based-shipping#Koszt_na_wage' : 'https://www.wpdesk.net/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=weight-based-shipping#Weight_Based_Shipping';
	$shipping_insurance_url = $pl ? 'https://www.wpdesk.pl/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=shipping-insurance#Ubezpieczenie_przesylki' : 'https://www.wpdesk.net/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=shipping-insurance#Shipping_Insurance';
	$conditional_cash_on_delivery_url = $pl ? 'https://www.wpdesk.pl/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=conditional-cash-on-delivery#Przesylka_za_pobraniem' : 'https://www.wpdesk.net/docs/flexible-shipping-pro-woocommerce-docs/?utm_source=flexible-shipping-info&utm_medium=link&utm_campaign=flexible-shipping-resources-box&utm_content=conditional-cash-on-delivery#Conditional_Cash_on_Delivery';
?>
</table>

<div class="inspire-settings flexible-shipping-info">
	<div class="inspire-main-content">
		<ol>
			<li>
				<?php
				echo sprintf(
					__( 'To add first Flexible Shipping method go to %sShipping zones%s and add Flexible Shipping to a shipping zone.', 'flexible-shipping' ),
					'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=shipping&section' ) . '">',
					'</a>'
				);
				?>
			</li>

			<li><?php _e( 'You can start the configuration by clicking the Flexible Shipping link in the Shipping methods table.', 'flexible-shipping' ); ?></li>
		</ol>

		<h4><?php _e( 'Quick Video Overview', 'flexible-shipping' ); ?></h4>

		<div class="flexible-shipping-video">
			<?php /* <iframe src="<?php echo $youtube_url?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="flexible-shipping-video"></iframe> */ ?>
			<iframe width="720" height="405" src="<?php echo $youtube_url?>?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</div>
	</div>

	<div class="inspire-sidebar">
		<div class="metabox-holder">
			<div class="stuffbox">
				<h3 class="hndle"><?php _e( 'More resources', 'flexible-shipping' ); ?></h3>

				<div class="inside">
					<ul>
						<li><a href="<?php echo $general_settings_url; ?>"><?php _e( 'General Settings', 'flexible-shipping' ); ?></a></li>
						<li><a href="<?php echo $adding_a_shipping_method_url; ?>"><?php _e( 'Adding a shipping method', 'flexible-shipping' ); ?></a></li>
						<li><a href="<?php echo $currency_support_url; ?>"><?php _e( 'Currency Support', 'flexible-shipping' ); ?></a></li>
						<li><a href="<?php echo $weight_based_shipping_url; ?>"><?php _e( 'Weight Based Shipping', 'flexible-shipping' ); ?></a></li>
						<li><a href="<?php echo $shipping_insurance_url; ?>"><?php _e( 'Shipping Insurance', 'flexible-shipping' ); ?></a></li>
						<li><a href="<?php echo $conditional_cash_on_delivery_url; ?>"><?php _e( 'Conditional Cash on Delivery', 'flexible-shipping' ); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.woocommerce-save-button').hide();
    })
</script>
<table>
