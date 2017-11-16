<?php

/**
 * Plugin Name: WooCommerce Variation Structured Data - Option 3
 * Plugin URI: https://github.com/woocommerce/woocommerce/issues/17471
 * Description: Implements alternative structured data for variations as per the discussions on https://github.com/woocommerce/woocommerce/issues/17471.
 * Author: Lee Willis
 * Version: 0.2
 * WC requires at least: 3.2.0
 * WC tested up to: 3.2.0
 * Author URI: http://www.leewillis.co.uk/
 * License: GPLv3
 */

add_filter( 'woocommerce_structured_data_product', function( $markup, $product ) {
	if ( ! $product->is_type( 'variable' ) ) {
		return $markup;
	}
	// See if we've pre-selected a specific variation with query arguments.
	$data_store   = WC_Data_Store::load( 'product' );
	$variation_id = $data_store->find_matching_product_variation( $product, wp_unslash( $_GET ) );
	$variation    = $variation_id ? wc_get_product( $variation_id ) : false;
	if ( ! empty( $variation ) ) {
		// Move the SKU away from the main product, and into the offer.
		$markup['offers'][0]['sku'] = $markup['sku'];
		unset( $markup['sku'] );
		// Copy the existing offer and use it as the basis for a new one.
		$markup_offer = $markup['offers'][0];
		unset( $markup_offer['lowPrice'] );
		unset( $markup_offer['highPrice'] );
		$markup_offer['@type'] = 'Offer';
		// Set the price on the new offer to the price for this variation.
		$markup_offer['price'] = wc_format_decimal( $variation->get_price(), wc_get_price_decimals() );
		// Set variation-specific attributes.
		$markup_offer['url'] = $variation->get_permalink();
		$markup_offer['sku'] = $variation->get_sku();
		// Add the variation offer to the list of offers.
		$markup['offers'][] = apply_filters( 'woocommerce_structured_data_product_offer', $markup_offer, $product );
	}
	return $markup;
}, 99, 2);