<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Plane
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

			<?php plane_content_nav( 'nav-below' ); ?>

			<?php
				if ( comments_open() || '0' != get_comments_number() ) {
					comments_template();
				}
			?>

		<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>