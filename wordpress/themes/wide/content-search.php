<?php
/**
 * The template part for displaying results in search pages
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php wide_post_thumbnail(); ?>

        <header class="entry-header">
            <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        </header><!-- .entry-header -->

        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->

        <?php if ( 'post' == get_post_type() ) : ?>

            <footer class="entry-footer">
                <?php wide_entry_meta(); ?>
                <?php edit_post_link( esc_html__( 'Edit', 'wide' ), '<span class="edit-link">', '</span>' ); ?>
            </footer><!-- .entry-footer -->

        <?php else : ?>

            <?php edit_post_link( esc_html__( 'Edit', 'wide' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

        <?php endif; ?>

    </article><!-- #post-## -->
