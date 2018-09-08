<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    global $post, $product;
    if ( ! $product->is_in_stock() ) return;
    $sale_price = get_post_meta( $product->get_id(), '_price', true);
    $regular_price = get_post_meta( $product->get_id(), '_regular_price', true);
    if (empty($regular_price)){ //then this is a variable product
        $available_variations = $product->get_available_variations();
        $variation_id=$available_variations[0]['variation_id'];
        $variation = new WC_Product_Variation( $variation_id );
        $regular_price = $variation ->get_regular_price();
        $sale_price = $variation ->get_sale_price();
    }
    $sale = ceil(( ($regular_price - $sale_price) / $regular_price ) * 100);
?>
<?php if ( !empty( $regular_price ) && !empty( $sale_price ) && $regular_price > $sale_price ) : ?>
    <?php echo
        apply_filters( 'woocommerce_sale_flash', '<div class="onsale"><span>' . $sale . '%</span><span>'.__('off' , 'blance').'</span></div>', $post, $product );
    ?>
<?php endif; ?>