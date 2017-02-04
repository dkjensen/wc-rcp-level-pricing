=== WooCommerce - Restrict Content Pro Level Pricing ===
Contributors: dkjensen
Tested up to: 4.7.2
Stable tag: 1.0.0
License: GPLv2 or later

Provides per subscription level product pricing for WooCommerce and Restrict Content Pro

== Description ==
Integrate your Restrict Content Pro subscription levels with WooCommerce products and variations. This plugin enables the ability to set product and variation pricing per subscription level. 

This is useful for sites that do not necessarily want to give a fixed discount to subscribers but would rather give discounts at the product level, for example.

== Installation ==

1. Upload `woocommerce-restrict-content-pro-level-pricing` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How can I manually display a non-subscriber price? =

You can filter the display price of a product manually by filtering the output.

	global $product;
	
    $price = $product->get_price();
    
    /**
     * @param string $price  Current price to filter
     * @param object $product  Instance of WC_Product or WC_Product_Variation
     */
    $original_price = apply_filters( 'rcp_woocommerce_original_price',  $product->get_price(), $product );


= How can I get the price of specific subscription level manually? =

    /**
     * @param string $price Current price to filter
     * @param object $product  Instance of WC_Product or WC_Product_Variation
     * @param integer $level Subscription level price to return
     */
    $level_price = apply_filters( 'rcp_woocommerce_level_price', $price, $product, 1 );