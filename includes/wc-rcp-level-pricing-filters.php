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
	remove_filter( 'woocommerce_product_get_sale_price', 'wc_rcp_level_pricing_woocommerce_get_sale_price', 110, 2 );

	$price = $product->get_price();

	add_filter( 'woocommerce_get_price', 'wc_rcp_level_pricing_woocommerce_get_price', 110, 2 );
	add_filter( 'woocommerce_get_regular_price', 'wc_rcp_level_pricing_woocommerce_get_regular_price', 110, 2 );
	add_filter( 'woocommerce_product_get_sale_price', 'wc_rcp_level_pricing_woocommerce_get_sale_price', 110, 2 );

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
	remove_filter( 'wc_rcp_level_pricing_current_user', 'rcp_woocommerce_user_allowed_discount', 10, 1 );

	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $product, $level ) ) ) {
		$price = $level_price;
	}

	add_filter( 'wc_rcp_level_pricing_current_user', 'rcp_woocommerce_user_allowed_discount', 10, 1 );

	return $price;
}
add_filter( 'rcp_woocommerce_level_price', 'rcp_woocommerce_level_price', 10, 3 );




/**
 * Check if the user is permitted to receive a membership discount
 * before grabbing the discounted price
 * 
 * @param integer $user_id 
 * @param integer $level 
 * @return bool
 */
function rcp_woocommerce_user_allowed_discount( $allowed ) {
	$sub_status = rcp_get_status();

	if( ! in_array( $sub_status, array( 'active', 'free' ) ) ) {
		return false;
	}

	if( rcp_is_trialing() ) {
		if( apply_filters( 'wc_rcp_level_pricing_disallow_trial', true ) ) {
			return false;
		}
	}

	return true;
}
add_filter( 'wc_rcp_level_pricing_current_user', 'rcp_woocommerce_user_allowed_discount', 10, 1 );