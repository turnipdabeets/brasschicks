<?php
/**
 * The template for displaying the footer.
 *
 * @package Plane
 */
?>
		</div>

	<footer class="site-footer" role="contentinfo">
		<div class="content-wrapper">

			<?php get_sidebar( 'footer' ); ?>

			<div class="site-credit">
				<a class="powered-by" href="<?php echo esc_url( __( 'http://wordpress.org/', 'plane' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'plane' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s by %2$s.', 'plane' ), 'Plane', '<a href="https://wordpress.com/themes/" rel="designer">WordPress.com</a>' ); ?>
			</div><!-- .site-credit -->

		</div>
	</footer><!-- .site-footer -->

<?php wp_footer(); ?>

</body>
</html>