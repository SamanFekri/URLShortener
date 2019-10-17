<?php
/**
 * Na Core Plugin
 * @package     Nano Agency
 * @version     1.0
 * @author      Nano Agency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2016 Nano Agency
 * @license     GPL v2
 */

$atts = shortcode_atts(array(
    'box_title'         => '',
    'post_type'         => 'post',
    'na_style'          => 'na-list',
    'na_col'            => 'col-md-6 col-sm-6',
    'cat'               => '',
    'post_in'           => '',
    'posts_per_page'    => 4,
    'el_class'          => '',
    'title_align'       =>'left',

), $atts);
//category

$class_col ='col-md-6 col-sm-6';
$class = '';
$class_col = str_replace('na_col', 'products-',$atts['na_col']);

if($class_col       == "col-md-12 col-sm-12"){
    $number=1;
}
elseif($class_col   == 'col-md-6 col-sm-6'){
    $number=2;
}
elseif($class_col   == 'col-md-4 col-sm-6'){
    $number=3;
}
elseif($class_col   == 'col-md-3 col-sm-6'){
    $number=4;
}
elseif($class_col   == 'col-md-2 col-sm-4'){
    $number=6;
}else{
    $number=4;
}
$the_query=new WP_Query($atts);
?>

    <div class="widget blog-recent-post clearfix">
        <?php if ( $atts['box_title'] ) {?>
            <h3 class="widgettitle <?php echo esc_attr($atts['title_align']); ?>">
                <?php echo htmlspecialchars_decode( $atts['box_title'] ); ?>
            </h3>
        <?php }?>
        <div class="widget-content">
            <div class="rows  <?php echo esc_attr($atts['na_style']); ?>" data-number="<?php echo esc_attr($number);?>" data-auto="false" data-pagination='false'>
                <?php
                if ($the_query->have_posts()):

                    while ($the_query->have_posts()):
                        $the_query->the_post();
                        ?>
                        <article class="<?php echo esc_attr($class_col);?>">
                            <div class="na-recent-post">
                                <div class="post-image">
                                    <a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
                                        <?php
                                        $attachments = get_attached_file( get_post_thumbnail_id(get_the_ID()) );
                                        if(has_post_thumbnail() && $attachments){
                                            the_post_thumbnail('nano-recent-image', array('class' => 'nano-recent-image'));
                                        }
                                        else {
                                            echo '<img src="' . esc_url((NANO_PLUGIN_URL.'assets/images/blog.jpg')) . '" alt="'. esc_attr__('Place Holder','na-nano') .'" />';
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="bg_gradients">
                                    <a href="<?php echo get_permalink() ?>"><span class="icon-link"></span></a>
                                </div>
                                <div class="post-article">
                                    <div class="post-article-header clearfix">

                                        <div class="entry-header">
                                            <h4 class="entry-title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h4>
                                        </div>
                                        <div class="entry-bottom clearfix">
                                            <div class="article-meta pull-left">
                                                <span class="post-date"><i class="icon-clock"></i><?php echo get_the_date('M d, Y'); ?></span>
                                            </div>
                                            <?php comments_number( '<p class="item-comment pull-right"></p>', '<p class="item-comment pull-right"><i class="icon-comment"></i><span>'.esc_html__('1','nano').'</span></p>', '<p class="item-comment pull-right"><i class="icon-comment"></i><span>'.esc_html__('%','nano').'</span></p>' ); ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    if (function_exists("posts_nav")&& $atts['pagination']==1) :
                        posts_nav($the_query->max_num_pages);
                    endif;
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
