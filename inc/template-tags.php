<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Plane
 */


/**
 * Add custom header image to header area
 */
function plane_header_background() {
	if ( get_header_image() ) {
		$css = '.site-header { background-image: url(' . esc_url( get_header_image() ) . '); }';
		wp_add_inline_style( 'plane-style', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'plane_header_background', 11 );

if ( ! function_exists( 'plane_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable.
 */
function plane_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
		return;
	}

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?> clear" role="navigation">
	<?php if ( is_single() ) : ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( 'Previous Article', 'Previous Article', 'plane' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav">' . _x( 'Next Article', 'Next Article', 'plane' ) . '</span> %title' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav"></span> Previous Articles', 'plane' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Next Articles <span class="meta-nav"></span>', 'plane' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif;

if ( ! function_exists( 'plane_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function plane_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'plane' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'plane' ), '<span class="comment-meta"><span class="edit-link">', '</span></span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-meta">
				<?php if ( 0 != $args['avatar_size'] ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
				<?php printf( __( '<strong class="comment-author">%s</strong>', 'plane' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				<span class="comment-date"><?php printf( _x( '%1$s / %2$s', '1: date, 2: time', 'plane' ), get_comment_date(), get_comment_time() ); ?></span>
			</div>

			<?php if ( '0' == $comment->comment_approved ) : ?>
			<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'plane' ); ?></p>
			<?php endif; ?>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>

			<div class="comment-meta comment-footer">
				<?php edit_comment_link( __( 'Edit', 'plane' ), '<span class="edit-link">', '</span>' ); ?>
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<span class="comment-reply">',
						'after'     => '</span>',
					) ) );
				?>
			</div>
		</article><!-- #div-comment-<?php comment_ID(); ?> -->

	<?php
	endif;
}
endif; // ends check for plane_comment()

if ( ! function_exists( 'plane_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function plane_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$formats = get_theme_support( 'post-formats' );
	$format = get_post_format();

	if ( is_sticky() && ! is_single() ) :
		printf( __( '<span class="featured">%1$s</span>', 'plane' ),
			sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
				esc_url( get_permalink() ),
				__( 'Featured', 'plane' )
			)
		);
	elseif ( $format && in_array( $format, $formats[0] ) ) :
		printf( __( '<span class="entry-format">%1$s</span> <span class="posted-on">%2$s</span><span class="byline">%3$s</span>', 'plane' ),
			sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
				esc_url( get_post_format_link( $format ) ),
				esc_attr( sprintf( __( 'All %s posts', 'plane' ), get_post_format_string( $format ) ) ),
				get_post_format_string( $format )
			),
			sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
				esc_url( get_permalink() ),
				$time_string
			),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			)
		);
	else :
		printf( __( '<span class="posted-on">%1$s</span><span class="byline">%2$s</span>', 'plane' ),
			sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
				esc_url( get_permalink() ),
				$time_string
			),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			)
		);
	endif;

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'plane' ), __( '1 Comment', 'plane' ), __( '% Comments', 'plane' ) );
		echo '</span>';
	}

}
endif;

if ( ! function_exists( 'plane_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function plane_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) :
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'plane' ) );
		if ( $categories_list && plane_categorized_blog() ) {
			printf( '<span class="cat-links">%1$s</span>', $categories_list );
		}

		the_tags( '<span class="tags-links">', ', ', '</span>' );

	endif;

	edit_post_link( __( 'Edit', 'plane' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 */
function plane_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so plane_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so plane_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in plane_categorized_blog.
 */
function plane_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'plane_category_transient_flusher' );
add_action( 'save_post',     'plane_category_transient_flusher' );

/**
 * Returns the URL from the post.
 *
 * @uses get_the_link() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @return string URL
 */
function plane_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}