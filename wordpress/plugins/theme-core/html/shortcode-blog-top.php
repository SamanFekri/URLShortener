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
);
if( $atts['type_post'] == 'yes' ){
    $meta_query[] = array(
        'key' => '_featured',
        'value' => 'yes'
    );
    $args['meta_query'] = $meta_query;
}
$the_query = new WP_Query($args);
$count = $the_query->found_posts;
?>
<?php if ($atts['title']) { ?>
    <h5 class="widgettitle"><?php echo esc_html($atts['title']); ?></h5>
<?php } ?>
<?php
switch ($atts['layout_types']) {
    case 'column':?>
        <div class="<?php echo 'blog-' . esc_attr($atts['layout_types']) . '-layout' ?>">
            <?php if ($atts['title']) { ?>
                <h5 class="widgettitle"><?php echo esc_html($atts['title']); ?></h5>
            <?php } ?>
            <div class="archive-blog row article-carousel <?php echo esc_attr($atts['style_content']); ?>" data-rtl="<?php echo esc_attr($add_rtl);?>"  data-number="1" data-mobile = "1" data-mobilemin = "1" data-dots="false" data-arrows="true">
                <?php if ($the_query->have_posts()):
                    while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <?php na_part_templates('layout/content-tran-one');?>
                        <?php endwhile;
                endif;
                wp_reset_postdata();?>
            </div>
        </div>
        <?php break;
    case 'column-center':?>
        <div class="<?php echo 'blog-' . esc_attr($atts['layout_types']) . '-layout' ?>">
            <?php if ($atts['title']) { ?>
                <h5 class="widgettitle"><?php echo esc_html($atts['title']); ?></h5>
            <?php } ?>
            <div class="archive-blog row article-carousel-center <?php echo esc_attr($atts['style_content']); ?>" data-rtl="<?php echo esc_attr($add_rtl);?>" data-number="1" data-mobile = "1" data-mobilemin = "1" data-table="1" data-dots="false" data-arrows="true">
                <?php if ($the_query->have_posts()):
                    while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <?php na_part_templates('layout/content-tran');?>
                        <?php endwhile;
                endif;
                wp_reset_postdata();?>
            </div>
        </div>
        <?php break;
    case 'column3':?>
        <div class="article-carousel <?php echo esc_attr($atts['style_content']); ?>" data-rtl="<?php echo esc_attr($add_rtl);?>" data-number="1" data-table="1" data-mobile = "1" data-mobilemin = "1" data-dots="true" data-arrows="false">
            <?php $k=1;
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); ?>
                <?php if ($k == 1 || (($k - 1) % 3) == 0) { ?>
                    <div class="row">
                        <div class="description-hidden padding-balance clearfix">
                            <?php //col large ?>
                            <div class="col-md-8 col-sm-8 description-show balance-padding-right box-large">
                                <?php na_part_templates('layout/content-tran'); ?>
                            </div>
                            <?php if ($k ==$atts['number_post']|| $k ==$count ) { ?>
                        </div>
                    </div>
                    <?php }?>
                <?php }
                else{ ?>
                    <div class="col-md-4 col-sm-4  box-small balance-padding-left">
                        <?php na_part_templates('layout/content-tran'); ?>
                    </div>
                    <?php if (($k % 3) == 0 || $k ==$count ||$k ==$atts['number_post']) { ?>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>

                <?php $k++;
            }
            wp_reset_postdata();?>
        </div>
        <?php break;
    case 'column3-large':?>
        <div class="article-carousel style-post-cat archive-blog column3" data-rtl="<?php echo esc_attr($add_rtl);?>" data-number="1" data-table="1" data-mobile = "1" data-mobilemin = "1" data-dots="true" data-arrows="false">
            <?php $k=1;
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); ?>
                <?php if ($k == 1 || (($k - 1) % 3) == 0) { ?>
                    <div class="row">
                    <div class="col-md-12 box-large">
                        <?php na_part_templates('layout/content-tran'); ?>
                    </div>
                    <?php if ($k ==  $atts['number_post'] || $k ==$count ) { ?>
                        </div>
                    <?php }?>
                <?php }
                else{ ?>
                    <div class="col-md-6 col-sm-6 description-hidden">
                        <?php na_part_templates('layout/content-tran'); ?>
                    </div>
                    <?php if (($k % 3) == 0 || $k ==$count || $k ==  $atts['number_post']  ) { ?>
                        </div>
                    <?php }?>
                <?php } ?>
                <?php $k++;
            }
            wp_reset_postdata();?>
        </div>
        <?php break;
    case 'column4':?>
        <div class="article-carousel" data-rtl="<?php echo esc_attr($add_rtl);?>" data-number="4"  data-dots="true" data-table="3" data-mobile = "2" data-mobilemin = "1" data-arrows="false">
            <?php $k=1;
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); ?>
                <div class="description-hidden archive-blog top-for-col padding-balance  clearfix">
                    <?php na_part_templates('layout/content-vertical'); ?>
                </div>
            <?php } ?>
            <?php wp_reset_postdata();?>
        </div>
        <?php break;
      case 'column4-large':?>
        <div class="article-carousel column4-large" data-rtl="<?php echo esc_attr($add_rtl);?>" data-number="1"  data-dots="true" data-table="1" data-mobile = "1" data-mobilemin = "1" data-arrows="false">
             <?php $k=1;
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); ?>
                <?php if ($k == 1 || (($k - 1) % 4) == 0) { ?>
                    <div class="row">
                        <div class="description-hidden padding-balance clearfix">
                            <?php //col large ?>
                            <div class="col-sm-6 col-md-9 box-large description-show balance-padding-right box-large">
                                <?php na_part_templates('layout/content-tran'); ?>
                            </div>
                            <?php if ($k ==$atts['number_post']|| $k ==$count ) { ?>
                        </div>
                    </div>
                    <?php }?>
                <?php }
                else{ ?>
                    <div class="col-sm-6 col-md-3  box-small balance-padding-left">
                        <?php na_part_templates('layout/content-tran'); ?>
                    </div>
                    <?php if (($k % 4) == 0 || $k ==$count ||$k ==$atts['number_post']) { ?>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>

                <?php $k++;
            }
            wp_reset_postdata();?>
        </div>
        <?php break;
    case 'column5':?>
        <div class="article-carousel" data-rtl="<?php echo esc_attr($add_rtl);?>" data-number="1"  data-dots="true" data-table="1" data-mobile = "1" data-mobilemin = "1" data-arrows="false">
            <?php $k=1;
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); ?>
                <?php if ($k == 1 || (($k - 1) % 5) == 0) { ?>
                    <?php //created row ?>
                    <div class="row">
                        <div class="description-hidden archive-blog clearfix">
                            <?php //col large ?>
                            <div class="col-md-6  col-sm-12 box-large">
                                <?php na_part_templates('layout/content-tran'); ?>
                            </div>
                            <?php if ($k ==  $atts['number_post'] || $k ==$count ) { ?>
                                </div>
                             </div>
                            <?php }?>
                <?php }
                else{ ?>
                    <?php //col small ?>
                    <div class="col-md-3 col-sm-6 box-small">
                        <?php na_part_templates('layout/content-tran'); ?>
                    </div>
                    <?php if (($k % 5) == 0 || $k ==$count || $k ==  $atts['number_post']) { ?>
                        <?php //end row ?>
                        </div>
                        </div>
                    <?php }?>
                <?php } ?>
                <?php $k++;
            }
            wp_reset_postdata();?>
        </div>
        <?php break;
    default:?>
        <div class="<?php echo 'blog-' . esc_attr($atts['layout_types']) . '-layout' ?>">
            <?php if ($atts['title']) { ?>
                <h5 class="widgettitle"><?php echo esc_html($atts['title']); ?></h5>
            <?php } ?>
            <div class="archive-blog row article-carousel <?php echo esc_attr($atts['style_content']); ?>" data-rtl="<?php echo esc_attr($add_rtl);?>" data-number="1"  data-dots="false" data-arrows="true">
                <?php if ($the_query->have_posts()):
                    while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <?php na_part_templates('layout/content-tran');?>
                        <?php $i++; endwhile;
                endif;
                wp_reset_postdata();?>
            </div>
        </div>
    <?php break;
}
?>



