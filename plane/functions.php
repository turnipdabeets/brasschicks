<?php
/**
 * Theme functions and definitions
 *
 * @package Plane
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 636; /* pixels */
}

// Adjust $content_width it depending on the temaplte used.
function plane_content_width() {
	global $content_width;

	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 994;
	}
}
add_action( 'template_redirect', 'plane_content_width' );

if ( ! function_exists( 'plane_setup' ) ) :
function plane_setup() {

	load_theme_textdomain( 'plane', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	add_theme_support( 'title-tag' );

	add_editor_style( array( 'editor-style.css' ), plane_fonts_url() );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'plane' ),
	) );

}
endif;
add_action( 'after_setup_theme', 'plane_setup' );


/* Register widget area. */
function plane_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'plane' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #1', 'plane' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #2', 'plane' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #3', 'plane' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #4', 'plane' ),
		'id'            => 'sidebar-5',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'plane_widgets_init' );

/*-----------------------------------------------------------------------------------*/
/*  Returns the Google font stylesheet URL, if available.
/* ----------------------------------------------------------------------------------*/
function plane_fonts_url() {
	$fonts_url = '';

	/* Raleway */
	$raleway = _x( 'on', 'Raleway font: on or off', 'plane' );

	/* Noto Serif */
	$noto_serif = _x( 'on', 'Noto Serif font: on or off', 'plane' );

	if ( 'off' !== $raleway || 'off' !== $noto_serif ) {
		$font_families = array();

		if ( 'off' !== $raleway )
			$font_families[] = 'Raleway:400,500,700,900';

		if ( 'off' !== $noto_serif )
			$font_families[] = 'Noto Serif:400,700,400italic,700italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function plane_scripts() {
	wp_enqueue_script( 'plane-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'plane-scripts', get_template_directory_uri() . '/js/plane.js', array( 'jquery' ), '20140715', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'plane_scripts' );

function plane_styles() {
	wp_enqueue_style( 'plane-icons', get_template_directory_uri().'/css/font-awesome.css', array(), '4.0.3' );
	wp_enqueue_style( 'plane-fonts', plane_fonts_url() );
	wp_enqueue_style( 'plane-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'plane_styles' );


/*-----------------------------------------------------------------------------------*/
/*  Actions
/* ----------------------------------------------------------------------------------*/

/**
 * Sets the authordata global when viewing an author archive.
 */
function plane_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'plane_setup_author' );

/*-----------------------------------------------------------------------------------*/
/*  Filters
/* ----------------------------------------------------------------------------------*/

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function plane_page_menu_args( $args ) {
	$args['show_home'] = true;
	$args['menu_class'] = 'nav-menu';
	return $args;
}
add_filter( 'wp_page_menu_args', 'plane_page_menu_args' );

/**
 * Excerpt handling
 */
function plane_continue_reading_link() {
	return ' <p class="more-link"><a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'plane' ) . '</a></p>';
}

function plane_custom_excerpt( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= '&hellip; ' . plane_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'plane_custom_excerpt' );

function plane_auto_excerpt_more( $output ) {
	$output = '';
	$output .= '&hellip; ' . plane_continue_reading_link();
	return $output;
}
add_filter( 'excerpt_more', 'plane_auto_excerpt_more' );

function plane_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'plane_excerpt_length' );

/**
 * Adds custom classes to the array of body classes.
 */
function plane_body_classes( $classes ) {

	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
    }

    if ( is_page() && ! comments_open() && '0' == get_comments_number() ) {
		$classes[] = 'comments-closed';
    }

	return $classes;
}
add_filter( 'body_class', 'plane_body_classes' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

// updater for WordPress.com themes
if ( is_admin() )
	include dirname( __FILE__ ) . '/inc/updater.php';
