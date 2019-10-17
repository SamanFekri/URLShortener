<?php
/**
 * The template for displaying Category pages
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
get_header();
$number_posts= get_theme_mod('wide_number_post_cat', '1');
$content = get_theme_mod('wide_post_entry_content',true);
$layout_first= get_theme_mod('show_layout_first',true);

$layout_content = get_theme_mod('wide_layout_cat_content', 'list');

$add_class = 'hidden_description';
if ($content){
    $add_class = 'show_description';
}
if($number_posts ==='2'){
    $class='col-md-6';
}
elseif($number_posts ==='3'){
    $class='col-md-4';
}
else{
    $class='col-md-12';
}

if(isset($_GET['col'])){
    $class=$_GET['col'];
}
if(isset($_GET['content'])){
    $layout_content=$_GET['content'];
}
if(isset($_GET['des'])){
    $add_class=$_GET['des'];
}
if(isset($_GET['first'])){
    $layout_first=$_GET['first'];
}
?>

<div class="wrap-content content-category container" role="main">
        <div class="row">

            <?php do_action('archive-sidebar-left'); ?>

            <?php do_action('archive-content-before'); ?>
                <?php if ( have_posts() ) : ?>
                    <div class="archive-blog row">
                        <?php
                                // Start the Loop.
                                $i=1;
                                while ( have_posts() ) : the_post();
                                    if($i==1 && isset($layout_first) && $layout_first !='' ){?>
                                        <div class="col-md-12 show-description">
                                            <?php get_template_part( 'templates/layout/content-grid');?>
                                        </div>
                                   <?php }else {?>
                                        <div class="col-item <?php echo esc_attr( $class); echo esc_attr(' '. $add_class)?> ">
                                            <?php get_template_part( 'templates/layout/content',$layout_content);?>
                                        </div>
                                    <?php } ?>
                                <?php  $i++; endwhile;
                            else :
                                // If no content, include the "No posts found" template.
                                get_template_part( 'content', 'none' );
                            endif;
                        ?>
                    </div>
                    <?php
                    the_posts_pagination( array(
                        'prev_text'          => '<i class="fa fa fa-angle-left"></i>',
                        'next_text'          => '<i class="fa fa fa-angle-right"></i>',
                        'before_page_number' => '<span class="meta-nav screen-reader-text"></span>',
                    ) );
                    ?>
            <?php do_action('archive-content-after'); ?>

            <?php do_action('archive-sidebar-right'); ?>

    </div><!-- .content-area -->
</div>
<?php
get_footer();
