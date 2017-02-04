<?php

if( ! defined( 'ABSPATH' ) ) exit;

if( ! function_exists( 'rcp_woocommerce_get_member_price' ) ) :

/**
 * Return the subscription level price given the product and subscription level ID
 * 
 * @param  object $product 
 * @param  integer $level 
 * @param  boolean $sale 
 * @return mixed String on success or false on failure
 */
function rcp_woocommerce_get_member_price( $product, $level = '', $sale = true ) {
	if( $product && function_exists( 'rcp_get_subscription_id' ) ) {
		$level         = $level === '' ? absint( rcp_get_subscription_id() ) : absint( $level );
		$product_id    = $product->is_type( 'variation' ) ? $product->get_variation_id() : $product->id;

		$regular_price = get_post_meta( $product_id, '_rcp_level_price_' . $level, true );
		$sale_price    = get_post_meta( $product_id, '_rcp_level_sale_price_' . $level, true );

		if( ! isset( $regular_price ) || $regular_price == '' ) {
			return false;
		}

		if( $sale && $sale_price !== '' && $sale_price < $regular_price ) {
			return wc_format_decimal( $sale_price );
		}

		return wc_format_decimal( $regular_price );
	}

	return false;
}

endif;