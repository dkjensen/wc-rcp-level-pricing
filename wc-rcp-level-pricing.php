<?php
/**
 * Plugin Name: WooCommerce - Restrict Content Pro Level Pricing
 * Plugin URI: https://seattlewebco.com
 * Description: Provides per subscription level product pricing for WooCommerce and Restrict Content Pro
 * Version: 1.0.5
 * Author:  Seattle Web Co.
 * Author URI: https://seattlewebco.com
 * Contributors: seattlewebco, dkjensen
 * Tested up to: 5.2.5
 * WC requires at least: 3.0.0
 * WC tested up to: 3.8
 *
 * Text Domain: wc-rcp-level-pricing
 * Domain Path: /languages/
 */


define( 'WCRCP_LEVEL_PRICING_VER', '1.0.4' );

if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
	require_once ABSPATH . '/wp-admin/includes/plugin.php';
}

if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) || 
	! is_plugin_active( 'restrict-content-pro/restrict-content-pro.php' ) ) return;


if ( is_admin() ) {
	include_once 'includes/admin/wc-rcp-level-pricing-admin-meta.php';
} else {
	include_once 'includes/wc-rcp-level-pricing-functions.php';
	include_once 'includes/wc-rcp-level-pricing-filters.php';
	include_once 'includes/wc-rcp-level-pricing-hooks.php';
}
