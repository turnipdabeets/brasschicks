<?php
/**
 * The template for displaying Comments.
 *
 * @package Plane
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="widget-title comments-title">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'plane' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h3>

		<ol class="commentlist">
			<?php
				wp_list_comments( array( 'callback' => 'plane_comment', 'avatar_size' => 40 ) );
			?>
		<!-- .comment-list --></ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="comment-navigation" role="navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'plane' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'plane' ) ); ?></div>
		<!-- .comment-navigation --></nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'plane' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>


</div><!-- #comments -->