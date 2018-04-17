<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Plane
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function plane_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'footer_widgets' => array( 'sidebar-2', 'sidebar-3', 'sidebar-4', 'sidebar-5' ),
		'container'      => 'main',
		'footer'         => 'content',
	) );

	add_image_size( 'plane-logo', 994, 360 );
	add_theme_support( 'site-logo', array( 'size' => 'plane-logo' ) );

	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'plane_jetpack_setup' );

/**
 * Return early if Site Logo is not available.
 */
function plane_the_site_logo() {
	if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
		return;
	} else {
		jetpack_the_site_logo();
	}
}