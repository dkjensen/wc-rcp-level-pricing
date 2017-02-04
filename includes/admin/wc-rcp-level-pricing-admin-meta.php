<?php

if( ! defined( 'ABSPATH' ) ) exit;

function wc_rcp_level_pricing_woocommerce_edit_product_simple() {
	global $post;

	if( function_exists( 'rcp_get_subscription_levels' ) ) {
    	$levels = rcp_get_subscription_levels();

    	if( ! empty( $levels ) ) {
    		foreach( $levels as $level ) :
    			$field_name  = 'rcp_level_price_' . $level->id;
    			$field_value = get_post_meta( $post->ID, '_rcp_level_price_' . $level->id, true );

    			$sale_field_name  = 'rcp_level_sale_price_' . $level->id;
    			$sale_field_value = get_post_meta( $post->ID, '_rcp_level_sale_price_' . $level->id, true );
    		?>
    		
    		<div class="rcp-woocommerce-level-pricing" style="overflow: hidden;">
	    		<div class="form-row rcp-level-price form-row-first">
		    		<p class="form-field">
		    			<label for="<?php print $field_name; ?>"><?php printf( '%s %s', esc_attr( $level->name ), __( 'Price', 'wc-rcp-level-pricing' ) ); ?> (<?php print get_woocommerce_currency_symbol(); ?>)</label>
		    			<input type="text" class="wc_input_price" style="" name="<?php print $field_name; ?>" id="<?php print $field_name; ?>" value="<?php print esc_attr( $field_value ); ?>">
		    		</p>
	    		</div>
	    		<div class="form-row rcp-level-price form-row-last">
		    		<p class="form-field">
		    			<label for="<?php print $sale_field_name; ?>"><?php printf( '%s %s', esc_attr( $level->name ), __( 'Sale Price', 'wc-rcp-level-pricing' ) ); ?> (<?php print get_woocommerce_currency_symbol(); ?>)</label>
		    			<input type="text" class="wc_input_price" style="" name="<?php print $sale_field_name; ?>" id="<?php print $sale_field_name; ?>" value="<?php print esc_attr( $sale_field_value ); ?>">
		    		</p>
	    		</div>
    		</div>

    		<?php
    		endforeach;
    	}
    }
}
add_action( 'woocommerce_product_options_pricing', 'wc_rcp_level_pricing_woocommerce_edit_product_simple', 5 );


function wc_rcp_level_pricing_woocommerce_save_product( $product_id ) {
	if( function_exists( 'rcp_get_subscription_levels' ) ) {
    	$levels = rcp_get_subscription_levels();

    	if( ! empty( $levels ) ) {
    		foreach( $levels as $level ) {
    			$regular_price = (string) isset( $_POST['rcp_level_price_' . $level->id] ) ? wc_clean( $_POST['rcp_level_price_' . $level->id] )           : '';
				$sale_price    = (string) isset( $_POST['rcp_level_sale_price_' . $level->id] ) ? wc_clean( $_POST['rcp_level_sale_price_' . $level->id] ) : '';

				update_post_meta( $product_id, '_rcp_level_price_' . $level->id, $regular_price );
    			update_post_meta( $product_id, '_rcp_level_sale_price_' . $level->id, $sale_price );
    		}
    	}
    }
}
add_action( 'woocommerce_process_product_meta_simple', 'wc_rcp_level_pricing_woocommerce_save_product' );
add_action( 'woocommerce_process_product_meta_external', 'wc_rcp_level_pricing_woocommerce_save_product' );


function wc_rcp_level_pricing_woocommerce_edit_product_variation( $loop, $variation_data, $variation ) {
    if( function_exists( 'rcp_get_subscription_levels' ) ) {
    	$levels = rcp_get_subscription_levels();

    	if( ! empty( $levels ) ) {
    		foreach( $levels as $level ) :
    			$field_name  = 'variable_rcp_level_price_' . $level->id . '[' . $loop . ']';
    			$field_value = get_post_meta( $variation->ID, '_rcp_level_price_' . $level->id, true );

    			$sale_field_name  = 'variable_rcp_level_sale_price_' . $level->id . '[' . $loop . ']';
    			$sale_field_value = get_post_meta( $variation->ID, '_rcp_level_sale_price_' . $level->id, true );
    		?>
    		
    		<div class="rcp-level-price">
	    		<p class="form-row form-row-first">
	    			<label for="<?php print $field_name; ?>"><?php printf( '%s %s', esc_attr( $level->name ), __( 'Price', 'wc-rcp-level-pricing' ) ); ?> (<?php print get_woocommerce_currency_symbol(); ?>)</label>
	    			<input type="text" class="wc_input_price" style="" name="<?php print $field_name; ?>" id="<?php print $field_name; ?>" value="<?php print esc_attr( $field_value ); ?>" placeholder="<?php printf( __( '%s price (optional)', 'wc-rcp-level-pricing' ), $level->name ); ?>">
	    		</p>
	    		<p class="form-row form-row-last">
	    			<label for="<?php print $sale_field_name; ?>"><?php printf( '%s %s', esc_attr( $level->name ), __( 'Sale Price', 'wc-rcp-level-pricing' ) ); ?> (<?php print get_woocommerce_currency_symbol(); ?>)</label>
	    			<input type="text" class="wc_input_price" style="" name="<?php print $sale_field_name; ?>" id="<?php print $sale_field_name; ?>" value="<?php print esc_attr( $sale_field_value ); ?>">
	    		</p>
    		</div>

    		<?php
    		endforeach;
    	}
    }
}
add_action( 'woocommerce_variation_options_pricing', 'wc_rcp_level_pricing_woocommerce_edit_product_variation', 10, 3 );



function wc_rcp_level_pricing_woocommerce_save_product_variation( $variation_id, $i ) {
	if( function_exists( 'rcp_get_subscription_levels' ) ) {
    	$levels = rcp_get_subscription_levels();

    	if( ! empty( $levels ) ) {
    		foreach( $levels as $level ) {
    			if( isset( $_POST['variable_rcp_level_price_' . $level->id] ) ) {
    				update_post_meta( $variation_id, '_rcp_level_price_' . $level->id, $_POST['variable_rcp_level_price_' . $level->id][$i] );
    			}
    			if( isset( $_POST['variable_rcp_level_sale_price_' . $level->id] ) ) {
    				update_post_meta( $variation_id, '_rcp_level_sale_price_' . $level->id, $_POST['variable_rcp_level_sale_price_' . $level->id][$i] );
    			}
    		}
    	}
    }
}
add_action( 'woocommerce_save_product_variation', 'wc_rcp_level_pricing_woocommerce_save_product_variation', 10, 2 );



function wc_rcp_level_pricing_woocommerce_coupon_restrictions() {
	global $post;
	?>

	<div class="options_group">
		<p class="form-field">
			<label for="exclude_subscription_levels"><?php _e( 'Exclude subscription levels', 'wc-rcp-level-pricing' ); ?></label>
			<select id="exclude_subscription_levels" name="exclude_subscription_levels[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php esc_attr_e( 'No subscription levels', 'wc-rcp-level-pricing' ); ?>">
				<?php
					if( function_exists( 'rcp_get_subscription_levels' ) ) {
				    	$levels = rcp_get_subscription_levels();

				    	if( ! empty( $levels ) ) {
				    		$level_ids = (array) get_post_meta( $post->ID, 'exclude_subscription_levels', true );

				    		var_dump( $level_ids );

				    		foreach( $levels as $level ) {
				    			printf( '<option value="%s" %s>%s</option>', $level->id, selected( in_array( $level->id, $level_ids ), true, false ), $level->name );
				    		}
				    	}
				    }
				?>
			</select> <?php echo wc_help_tip( __( 'A users subscription level must not be listed here for the coupon to remain valid.', 'wc-rcp-level-pricing' ) ); ?>
		</p>

	</div>

	<?php
}
add_action( 'woocommerce_coupon_options_usage_restriction', 'wc_rcp_level_pricing_woocommerce_coupon_restrictions' );


function wc_rcp_level_pricing_woocommerce_coupon_save( $post_id ) {
	$exclude_levels = isset( $_POST['exclude_subscription_levels'] ) ? array_map( 'intval', $_POST['exclude_subscription_levels'] ) : array();

	update_post_meta( $post_id, 'exclude_subscription_levels', $exclude_levels );
}
add_action( 'woocommerce_coupon_options_save', 'wc_rcp_level_pricing_woocommerce_coupon_save' );