<?php
/**
 * Plugin Name: WC RCP Level Pricing
 * Plugin URI: https://dkjensen.com
 * Description: Provides per subscription level product pricing for WooCommerce and Restrict Content Pro
 * Version: 1.0.0
 * Author: David Jensen
 * Author URI: https://dkjensen.com
 * Tested up to: 4.7.2
 *
 * Text Domain: wc-rcp-level-pricing
 * Domain Path: /languages/
 */

if( ! defined( 'ABSPATH' ) ) exit;

if( ! is_plugin_active( 'woocommerce/woocommerce.php') || 
	! is_plugin_active( 'restrict-content-pro/restrict-content-pro.php') ) return;


define( 'WCRCP_LEVEL_PRICING_VER', '1.0.0' );


if( is_admin() ) {
	include_once 'includes/admin/wc-rcp-level-pricing-admin-meta.php';
}else {
	include_once 'includes/wc-rcp-level-pricing-functions.php';
	include_once 'includes/wc-rcp-level-pricing-filters.php';
	include_once 'includes/wc-rcp-level-pricing-hooks.php';
}
