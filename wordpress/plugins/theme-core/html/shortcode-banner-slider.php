<?php
$atts = shortcode_atts(
    array(
        'box_title'             =>'',
        'posts_per_page'    => '',
        'number'            => 5,
        'target'            => '_blank',
        'auto'              => 'true',
        'el_class'          => '',

    ), $atts);

    $args = array(
    'posts_per_page' => $atts['posts_per_page'],
    'post_type' => 'banner'
    );
    $the_query = new WP_Query($args);?>


    <div class="widget widget-banner-slider">
        <div class="widget-inner row">
            <div class="na-banner-slider na-carousel <?php echo  $atts['el_class'];?>" data-number="<?php echo $atts['number'];?>" data-auto="<?php echo $atts['auto'];?>">
                <?php
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) : $the_query->the_post();

                        $banner_id = get_post_thumbnail_id();
                        $banner = wp_get_attachment_image_src($banner_id, true);
                        $banner_alt = get_post_meta($banner_id, '_wp_attachment_image_alt', true);
                        $banner_url = get_post_meta(get_the_ID(), 'na_banner_url', true);

                        $banner_class = get_post_meta(get_the_ID(), 'na_banner_class', true);
                        ?>
                        <div class="banner_item <?php echo $banner_class; ?>" id="banner_item_<?php echo $banner_id; ?>">
                            <div class="banner_item_inner">
                                <?php
                                if( $banner[0] & $banner_id){ ?>
                                    <a  target="<?php echo $atts['target']; ?>">
                                        <img src="<?php echo $banner[0]; ?>" alt="<?php echo $banner_id; ?>"/>
                                    </a>
                                <?php }
                                else{ ?>
                                    <a class="asdasd" href="<?php echo $banner_url; ?>" target="<?php echo $atts['target']; ?>">
                                        <?php echo '<img src="' . esc_url((NANO_PLUGIN_URL.'assets/images/placeholder.png')) . '" alt="'. esc_attr__('Place Holder','na-nano') .'" />'; ?>
                                    </a>
                                <?php }
                                ?>
                            </div>
                        </div>
                        <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>