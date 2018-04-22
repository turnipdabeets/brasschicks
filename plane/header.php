<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Plane
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '-', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'plane' ); ?></a>

	<div class="site-top">
		<div class="content-wrapper">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="menu" aria-expanded="false"><span class="screen-reader-text"><?php _e( 'Primary Menu', 'plane' ); ?></span></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'nav-menu' ) ); ?>
			</nav><!-- #site-navigation -->

			<div class="site-search">
				<button class="search-toggle"><span class="screen-reader-text"><?php _e( 'Search', 'plane' ); ?></span></button>
				<div class="search-expand">
					<div class="search-expand-inner">
						<?php get_search_form(); ?>
					</div>
				</div>
			</div><!-- .site-search -->
    	</div>
	</div><!-- .site-top -->

	<header class="site-header" role="banner">
			<div class="site-branding">
				<?php plane_the_site_logo(); ?>
				<div class="site-logo"></div>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div><!-- .site-branding -->
	</header><!-- .site-header -->

	<div id="content" class="site-content">
