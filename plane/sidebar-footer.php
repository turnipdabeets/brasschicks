<?php
/**
 * The widget areas in the footer.
 *
 * @package Plane
 */
?>

<?php
	if ( ! is_active_sidebar( 'sidebar-2' )
		&& ! is_active_sidebar( 'sidebar-3' )
		&& ! is_active_sidebar( 'sidebar-4' )
		&& ! is_active_sidebar( 'sidebar-5' )
	) {
		return;
	}
?>

<div id="tertiary" class="footer-widget-area" role="complementary">
	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div id="widget-area-2" class="widget-area">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- #widget-area-2 -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
	<div id="widget-area-3" class="widget-area">
		<?php dynamic_sidebar( 'sidebar-3' ); ?>
	</div><!-- #widget-area-3 -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
	<div id="widget-area-4" class="widget-area">
		<?php dynamic_sidebar( 'sidebar-4' ); ?>
	</div><!-- #widget-area-4 -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
	<div id="widget-area-5" class="widget-area">
		<?php dynamic_sidebar( 'sidebar-5' ); ?>
	</div><!-- #widget-area-5 -->
	<?php endif; ?>
</div><!-- .footer-widget-area -->