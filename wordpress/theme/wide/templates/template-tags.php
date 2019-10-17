<?php
/**
 * Custom template tags for wide
 */

if ( ! function_exists( 'wide_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since wide 1.0
 */
function wide_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'wide' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'wide' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'wide' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'wide_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * @since wide 1.0
 */
function wide_entry_meta() {
    $comments = get_theme_mod('wide_post_cat_meta_comment', true);
    $view = get_theme_mod('wide_post_meta_view', true);
    $like = get_theme_mod('wide_post_meta_like', true);

	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="sticky-post"> <i class="fa fa-bell"></i> %s</span>', __( 'Featured', 'wide' ) );
	}

	if ( 'post' == get_post_type() ) {
		printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span><span class="by">'.esc_html__('by','wide').'</span><a class="url fn n" href="%2$s"><strong>%3$s</strong></a></span></span>',
			_x( 'Author', 'Used before post author name.', 'wide' ),

			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);

	}

	if ( is_attachment() && wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
			_x( 'Full size', 'Used before full size attachment link.', 'wide' ),
			esc_url( wp_get_attachment_url() ),
			$metadata['width'],
			$metadata['height']
		);
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {?>
        <div class="view-like">
            <?php if ($comments) {?>
                <span class="comments-link pull-right">
                    <a href="<?php echo esc_url(comments_link());?>" class="text-comment"><i class="fa fa-comments" aria-hidden="true"></i> <?php comments_number( '0', '1', '%' ); ?></a>
                </span>
            <?php }
            if ($like){
                if (in_array('wti-like-post/wti_like_post.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                    GetWtiLikePost();
                }
            }
            if($view) {?>
                <div class="total-view post-info-item">
                    <i class="fa fa-eye"></i> <?php echo get_post_meta(get_the_ID(), 'post_views_count', true);?>
                </div>
            <?php } ?>
        </div>
    <?php }?>
<?php
}
endif;

/**
 * Determine whether blog/site has more than one category.
 *
 * @since wide 1.0
 *
 * @return bool True of there is more than one category, false otherwise.
 */
function wide_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'wide_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'wide_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so wide_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so wide_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in {@see wide_categorized_blog()}.
 *
 * @since wide 1.0
 */
function wide_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'wide_categories' );
}
add_action( 'edit_category', 'wide_category_transient_flusher' );
add_action( 'save_post',     'wide_category_transient_flusher' );

if ( ! function_exists( 'wide_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since wide 1.0
 */
function wide_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
		?>
	</a>

	<?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'wide_get_link_url' ) ) :
/**
 * Return the post URL.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since wide 1.0
 *
 * @see get_url_in_content()
 *
 * @return string The Link format URL.
 */
function wide_get_link_url() {
	$has_url = get_url_in_content( get_the_content() );

	return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}
endif;

if ( ! function_exists( 'wide_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 *
 * @since wide 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function wide_excerpt_more( $more ) {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading %s', 'wide' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'wide_excerpt_more' );
endif;
