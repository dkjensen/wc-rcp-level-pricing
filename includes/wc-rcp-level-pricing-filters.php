<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Filter to get the original product price (non-subscriber)
 * 
 * @param  object $product 
 * @return string
 */
function rcp_woocommerce_original_price( $price = '', $product ) {
	if( ! method_exists( $product, 'get_price' ) ) {
		return $price;
	}

	remove_filter( 'woocommerce_get_price', 'wc_rcp_level_pricing_woocommerce_get_price', 110, 2 );
	remove_filter( 'woocommerce_get_regular_price', 'wc_rcp_level_pricing_woocommerce_get_regular_price', 110, 2 );
	remove_filter( 'woocommerce_get_sale_price', 'wc_rcp_level_pricing_woocommerce_get_sale_price', 110, 2 );

	$price = $product->get_price();

	add_filter( 'woocommerce_get_price', 'wc_rcp_level_pricing_woocommerce_get_price', 110, 2 );
	add_filter( 'woocommerce_get_regular_price', 'wc_rcp_level_pricing_woocommerce_get_regular_price', 110, 2 );
	add_filter( 'woocommerce_get_sale_price', 'wc_rcp_level_pricing_woocommerce_get_sale_price', 110, 2 );

	return $price;
}
add_filter( 'rcp_woocommerce_original_price', 'rcp_woocommerce_original_price', 10, 2 );


/**
 * Filter to get the product price for a subscription level
 * 
 * @param  string $price 
 * @param  object $product 
 * @param  integer $level 
 * @return string
 */
function rcp_woocommerce_level_price( $price, $product, $level = '' ) {
	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $product, $level ) ) ) {
		$price = $level_price;
	}

	return $price;
}
add_filter( 'rcp_woocommerce_level_price', 'rcp_woocommerce_level_price', 10, 3 );