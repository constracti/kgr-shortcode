<?php

/*
 * Plugin Name: KGR Shortcode
 * Plugin URI: https://github.com/constracti/kgr-shortcode
 * Description: Provides various shortcodes.
 * Version: 0.3
 * Requires at least: 4.5.0
 * Requires PHP: 8.0
 * Author: constracti
 * Author URI: https://github.com/constracti
 * Licence: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

if ( !defined( 'ABSPATH' ) )
	exit;

add_shortcode( 'kgr_shortcode_post', function( array $atts ): string {
	$atts = wp_parse_args( $atts, [
		'id' => NULL,
		'field' => NULL,
		'trim' => NULL,
	] );
	if ( is_null( $atts['id'] ) )
		return '';
	$post = get_post( $atts['id'] );
	if ( is_null( $post ) )
		return '';
	$ret = match ( $atts['field'] ) {
		'permalink' => get_permalink( $post ),
		'title' => get_the_title( $post ),
		'excerpt' => get_the_excerpt( $post ),
		'thumbnail' => get_the_post_thumbnail_url( $post ),
		'menu_url' => get_post_meta( $post->ID, '_menu_item_url', TRUE ),
		default => '',
	};
	if ( !is_null( $atts['trim'] ) )
		$ret = wp_trim_words( $ret, $atts['trim'] );
	return $ret;
} );
