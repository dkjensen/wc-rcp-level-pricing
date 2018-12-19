<?php

if( ! defined( 'ABSPATH' ) ) exit;

function wc_rcp_level_pricing_woocommerce_get_price( $price, $product ) {
	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $product ) ) ) {
		$price = $level_price;
    }
 
	return $price;
}
add_filter( 'woocommerce_product_get_price', 'wc_rcp_level_pricing_woocommerce_get_price', 110, 2 );
add_filter( 'woocommerce_product_variation_get_price', 'wc_rcp_level_pricing_woocommerce_get_price', 110, 2 );



function wc_rcp_level_pricing_woocommerce_get_regular_price( $price, $product ) {
	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $product, '', false ) ) ) {
		$price = $level_price;
	}

	return $price;
}
add_filter( 'woocommerce_product_get_regular_price', 'wc_rcp_level_pricing_woocommerce_get_regular_price', 110, 2 );
add_filter( 'woocommerce_product_variation_get_regular_price', 'wc_rcp_level_pricing_woocommerce_get_regular_price', 110, 2 );


function wc_rcp_level_pricing_woocommerce_get_sale_price( $price, $product ) {
	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $product, '', true ) ) ) {
		$price = $level_price;
	}

	return $price;
}
add_filter( 'woocommerce_product_get_sale_price', 'wc_rcp_level_pricing_woocommerce_get_sale_price', 110, 2 );
add_filter( 'woocommerce_product_variation_get_sale_price', 'wc_rcp_level_pricing_woocommerce_get_regular_price', 110, 2 );


function wc_rcp_level_pricing_woocommerce_variation_prices_hash( $hash ) {
	if( function_exists( 'rcp_get_subscription_id' ) ) {
		if( rcp_get_subscription_id() ) {
			$hash[] = '_rcp_level_' . absint( rcp_get_subscription_id() );
		}
	}

	return $hash;
}
add_filter( 'woocommerce_get_variation_prices_hash', 'wc_rcp_level_pricing_woocommerce_variation_prices_hash' );


function wc_rcp_level_pricing_woocommerce_variation_price( $price, $variation, $product ) {
	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $variation, '' ) ) ) {
		$price = $level_price;
	}

	return $price;
}
add_filter( 'woocommerce_variation_prices_price', 'wc_rcp_level_pricing_woocommerce_variation_price', 10, 3 );


function wc_rcp_level_pricing_woocommerce_variation_regular_price( $price, $variation, $product ) {
	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $variation, '', false ) ) ) {
		$price = $level_price;
	}

	return $price;
}
add_filter( 'woocommerce_variation_prices_regular_price', 'wc_rcp_level_pricing_woocommerce_variation_regular_price', 10, 3 );


function wc_rcp_level_pricing_woocommerce_variation_sale_price( $price, $variation, $product ) {
	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $variation, '', true ) ) ) {
		$price = $level_price;
	}

	return $price;
}
add_filter( 'woocommerce_variation_prices_sale_price', 'wc_rcp_level_pricing_woocommerce_variation_sale_price', 10, 3 );


function wc_rcp_level_pricing_woocommerce_coupon_is_valid( $valid, $coupon ) {
	$exclude_levels = (array) get_post_meta( $coupon->get_id(), 'exclude_subscription_levels', true );

	if( in_array( absint( rcp_get_subscription_id() ), $exclude_levels ) ) {
		$valid = false;
	}

	return $valid;
}
add_filter( 'woocommerce_coupon_is_valid', 'wc_rcp_level_pricing_woocommerce_coupon_is_valid', 10, 2 );