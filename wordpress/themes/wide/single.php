<?php
/**
 * Single Product
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

get_header();?>

<div class="wrap-content" role="main">
    <div class="container">
        <div class="row">
            <?php do_action('single-sidebar-left'); ?>

            <?php do_action('single-content-before'); ?>
                <div class="content-inner">
                    <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();
                        get_template_part( 'content','single' );
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;

                        // End the loop.
                    endwhile;
                    ?>
                </div>
            <?php do_action('single-content-after'); ?>

            <?php do_action('single-sidebar-right'); ?>

        </div><!-- .content-area -->
    </div>
</div>
<?php get_footer(); ?>
