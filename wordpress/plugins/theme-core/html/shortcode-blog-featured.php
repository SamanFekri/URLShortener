<?php
/**
 * The default template for displaying content
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
$add_rtl="false";
if(is_rtl()){
    $add_rtl="true";
}
$format = get_post_format();
$add_class='';
$args = array(
    'category_name'  => $atts['category_name'],
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $atts['number_post'],
    'meta_key'       => 'post_views_count',
    'orderby'       =>'meta_value_num',
    'order'         =>'DESC',
);
if( $atts['type_post'] == 'featured' ){
    $meta_query[] = array(
        'key'   => '_featured',
        'value' => 'yes'
    );
    $args['meta_query'] = $meta_query;
}

$the_query = new WP_Query($args);

?>
<?php if ($atts['title']) { ?>
    <h5 class="widgettitle"><?php echo esc_html($atts['title']); ?></h5>
<?php } ?>

<div class="article-carousel posts-featured" data-rtl="<?php echo esc_attr($add_rtl);?>" data-number="<?php echo esc_attr($atts['show_post']);?>"  data-dots="true" data-table="2" data-mobile = "1" data-mobilemin = "1" data-arrows="false">
    <?php   while ( $the_query->have_posts() ) {
        $the_query->the_post(); ?>
        <div class="description-hidden archive-blog clearfix">
            <?php na_part_templates('layout/content-grid'); ?>
        </div>
    <?php } ?>
    <?php wp_reset_postdata();?>
</div>




