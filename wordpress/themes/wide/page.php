<?php
/**
 * The template for displaying pages
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

get_header();
$wide_title = get_post_meta(get_the_ID(), 'na_show_title', true);
?>
<div class="container">
    <?php if($wide_title ===1 || $wide_title ==="") {?>
        <div class="title-page">
            <?php the_title();?>
        </div>
    <?php } ?>
    <div class="box box-article">
        <div class="row">
            <div class="site-main page-content col-sm-12 " role="main">
                    <?php
                    while ( have_posts() ) : the_post();?>
                        <?php get_template_part( 'content', 'page' );
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                    endwhile;
                    ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>