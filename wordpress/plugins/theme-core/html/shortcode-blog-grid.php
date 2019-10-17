<?php
/**
 * The default template for displaying content
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

$format = get_post_format();
$view_more = 'description-hidden';
$args = array(
    'post_type' => 'post',
    'posts_per_page' => ($atts['number'] > 0) ? $atts['number'] : get_option('posts_per_page')
);
if ($atts['category_name'] != '')
    $args['category_name'] = $atts['category_name'];

if ($atts['view_more']){
    $view_more = 'description-show';
}

$args['paged'] = (nano_get_query_var('paged')) ? nano_get_query_var('paged') : 1;
$the_query = new WP_Query($args);
//class for option columns
$class = '';
switch ($atts['columns']) {
    case '1':
        $class .= "col-xs-12";
        break;
    case '2':
        $class .= "col-xs-12 col-sm-6 col-md-6";
        break;
    case '3':
        $class .= "col-xs-12 col-sm-6 col-md-4";
        break;
}
$i = 0;
?>


<div class="<?php echo 'blog-' . esc_attr($atts['post_layout']) . '-layout' ?>">
    <?php if ($atts['title']) { ?>
            <h5 class="widgettitle"><?php echo esc_html($atts['title']); ?></h5>
    <?php } ?>
    <div class="archive-blog  row <?php echo esc_attr($view_more);?>">
        <?php if ($the_query->have_posts()):
            $i = 1;
            while ($the_query->have_posts()): $the_query->the_post();
                $add_class='';
                if( $i == 1 && isset($atts['show_layout_first']) && !empty($atts['show_layout_first'])) {
                ?>
                <div class="col-md-12 description-show">
                    <?php na_part_templates('layout/content-grid');?>
                </div>
                <?php } else {?>
                <div class=" col-item <?php echo esc_attr($class);?>">
                    <?php na_part_templates('layout/content-grid');?>
                </div>
                <?php } $i++; endwhile;
        endif;
        wp_reset_postdata();
        ?>

    </div>
    <?php
    //paging
    if (function_exists("nano_pagination")) :
        nano_pagination(3, $the_query);
    endif;
    //end paging
    ?>
</div>