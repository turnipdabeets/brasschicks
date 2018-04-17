<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Plane
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses plane_header_style()
 * @uses plane_admin_header_style()
 * @uses plane_admin_header_image()
 */
function plane_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'plane_custom_header_args', array(
		'default-text-color'	=> 'ffffff',
		'default-image'			=> '',
		'width'					=> 1600,
		'height'				=> 220,
		'flex-width'			=> true,
		'flex-height'			=> true,
		'wp-head-callback'		=> 'plane_header_style',
		'admin-head-callback'	=> 'plane_admin_header_style',
		'admin-preview-callback'=> 'plane_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'plane_custom_header_setup' );

if ( ! function_exists( 'plane_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see plane_custom_header_setup().
 */
function plane_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // plane_header_style

if ( ! function_exists( 'plane_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see plane_custom_header_setup().
 */
function plane_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			background-color: #bed4df;
			border: none;
			padding: 50px 0;
			text-align: center
		}
		#headimg h1,
		#desc {
			font-family: Raleway, Arial, Helvetica, sans-serif;
			letter-spacing: 2px;
			margin: 0 auto;
			text-transform: uppercase;
		}
		#headimg h1 a {
			font-size: 70px;
			font-weight: 900;
			line-height: 1;
			text-decoration: none;
		}
		#desc {
			font-weight: 500;
			line-height: 1.8;
			margin-top: 0.9em;
		}
	</style>
<?php
}
endif; // plane_admin_header_style

if ( ! function_exists( 'plane_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see plane_custom_header_setup().
 */
function plane_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	$image = '';

	if ( get_header_image() ) :
		$image = ' style="background-image: url( ' . get_header_image() . ' );"';
	endif; ?>
	<div id="headimg"<?php echo $image; ?>>
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"><?php bloginfo( 'description' ); ?></div>
	</div>
<?php
}
endif; // plane_admin_header_image