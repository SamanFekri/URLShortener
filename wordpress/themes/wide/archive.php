<?php
/**
 * The template for displaying archive pages
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */


get_header();

$content = get_theme_mod('wide_post_entry_content',true);
$add_class = 'hidden_description';
if ($content){
    $add_class = 'show_description';
}
$number_posts=get_theme_mod('wide_number_post_cat', '1');
if($number_posts ==='2'){
    $class='col-md-6';
}
elseif($number_posts ==='3'){
    $class='col-md-4';
}
elseif($number_posts ==='4'){
    $class='col-md-3';
}
else{
    $class='col-md-12';
}

?>
    <div class="wrap-content container" role="main">
        <div class="row">

            <?php do_action('archive-sidebar-left'); ?>

            <?php do_action('archive-content-before'); ?>
            <?php if ( have_posts() ) : ?>

            <div class="archive-blog row">
                <?php
                // Start the Loop.
                $i=1;
                while ( have_posts() ) : the_post();
                    if($i==1){?>
                        <div class="col-md-12 show-description">
                            <?php get_template_part( 'templates/layout/content-grid');?>
                        </div>
                    <?php }else {?>
                        <div class="<?php echo esc_attr($class); echo  esc_attr(' '.$add_class)?> ">
                            <?php get_template_part( 'templates/layout/content',get_theme_mod('wide_layout_cat_content', 'list'));?>
                        </div>
                    <?php } ?>
                    <?php  $i++; endwhile;

                else :
                    // If no content, include the "No posts found" template.
                    get_template_part( 'content', 'none' );
                endif;
                the_posts_pagination( array(
                    'prev_text'          => '<i class="fa fa fa-angle-left"></i>',
                    'next_text'          => '<i class="fa fa fa-angle-right"></i>',
                    'before_page_number' => '<span class="meta-nav screen-reader-text"></span>',
                ) );
                ?>
            </div>

            <?php do_action('archive-content-after'); ?>

            <?php do_action('archive-sidebar-right'); ?>

        </div><!-- .content-area -->
    </div>
<?php
get_footer();