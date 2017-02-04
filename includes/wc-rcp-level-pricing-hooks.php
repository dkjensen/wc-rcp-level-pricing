<?php

if( ! defined( 'ABSPATH' ) ) exit;

function wc_rcp_level_pricing_woocommerce_get_price( $price, $product ) {
	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $product ) ) ) {
		$price = $level_price;
	}

	return $price;
}
add_filter( 'woocommerce_get_price', 'wc_rcp_level_pricing_woocommerce_get_price', 110, 2 );



function wc_rcp_level_pricing_woocommerce_get_regular_price( $price, $product ) {
	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $product, '', false ) ) ) {
		$price = $level_price;
	}

	return $price;
}
add_filter( 'woocommerce_get_regular_price', 'wc_rcp_level_pricing_woocommerce_get_regular_price', 110, 2 );



function wc_rcp_level_pricing_woocommerce_get_sale_price( $price, $product ) {
	if( false !== ( $level_price = rcp_woocommerce_get_member_price( $product, '', true ) ) ) {
		$price = $level_price;
	}

	return $price;
}
add_filter( 'woocommerce_get_sale_price', 'wc_rcp_level_pricing_woocommerce_get_sale_price', 110, 2 );



function wc_rcp_level_pricing_woocommerce_available_variation( $params, $product, $variation ) {
	$params['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';

	return $params;
}
add_filter( 'woocommerce_available_variation', 'wc_rcp_level_pricing_woocommerce_available_variation', 110, 3 );



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


function wc_rcp_level_pricing_woocommerce_variation_prices( $prices, $product, $display ) {
	return $prices;
}
add_filter( 'woocommerce_variation_prices', 'wc_rcp_level_pricing_woocommerce_variation_prices', 10, 3 );



function wc_rcp_level_pricing_woocommerce_coupon_is_valid( $valid, $coupon ) {
	$exclude_levels = (array) get_post_meta( $coupon->id, 'exclude_subscription_levels', true );

	if( in_array( absint( rcp_get_subscription_id() ), $exclude_levels ) ) {
		$valid = false;
	}

	return $valid;
}
add_filter( 'woocommerce_coupon_is_valid', 'wc_rcp_level_pricing_woocommerce_coupon_is_valid', 10, 2 );


/*
function wc_rcp_level_pricing_woocommerce_get_price_html( $price, $product ) {
	return 123 . $price;
}
add_filter( 'woocommerce_get_price_html', 'wc_rcp_level_pricing_woocommerce_get_price_html', 110, 2 );





function wc_rcp_level_pricing_woocommerce_get_variation_price( $price, $product, $min_or_max, $display ) {
	foreach( $product->get_children() as $variation_id ) {
		$variation = $product->get_child( $variation_id );

		if( $variation ) {
			$price = get_post_meta( $variation_id, '_variable_rcp_level_price_' . rcp_get_subscription_id(), true );
		}
	}

	return 1;
}
add_filter( 'woocommerce_get_variation_price', 'wc_rcp_level_pricing_woocommerce_get_variation_price', 110, 4 );
add_filter( 'woocommerce_get_variation_regular_price', 'wc_rcp_level_pricing_woocommerce_get_variation_price', 110, 4 );






function wc_rcp_level_pricing_woocommerce_wc_price( $return, $price, $args ) {
	return $return;
}
add_filter( 'wc_price', 'wc_rcp_level_pricing_woocommerce_wc_price', 110, 3 );


function wc_rcp_level_pricing_woocommerce_get_price_html_from_to( $price, $from, $to, $product ) {
	return 123;
}
add_filter( 'woocommerce_get_price_html_from_to', 'wc_rcp_level_pricing_woocommerce_get_price_html_from_to', 110, 4 );

function wc_rcp_level_pricing_woocommerce_get_variation_price_html( $price, $product ) {
	return wc_price( 123 );
}
add_filter( 'woocommerce_get_variation_price_html', 'wc_rcp_level_pricing_woocommerce_get_variation_price_html', 110, 2 );

*/
