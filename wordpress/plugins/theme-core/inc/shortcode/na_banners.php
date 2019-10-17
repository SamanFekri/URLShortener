<?php

if (!function_exists('na_shortcode_banners')) {
    function na_shortcode_banners($atts)
    {

        $atts = shortcode_atts(
            array(
                'image'         => '',
                'title'         => '',
                'text_color'    => '',
                'link'          => '',
                'el_class'      => ''

            ), $atts);

        ob_start();

        $link =vc_build_link($atts['link']);
        $target ='_self';
        if ( $link['target'] ) {
            $target =$link['target'];
        }
        if ( $link['title'] ) {
            $title = $link['title'];
        };

        $color='';
        if($atts['text_color'] && !empty($atts['text_color'])){
            $color[]  = str_replace( '_', '-','color' ) . ': ' . $atts['color'].'; ';
            $color    = ' style=' . implode( '', $color ) . '';
        }

        ?>
        <div class="na-banners  <?php echo esc_attr(($atts['el_class']) ? $atts['el_class'] : ''); ?>">
            <div class="group-image-banner slide-border clearfix">
                <?php if($atts['image']) { ?>
                    <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($target); ?>" class="affect-border-inner">
                        <?php echo wp_get_attachment_image($atts['image'], 'full'); ?>
                    </a>
                <?php } ?>
                <?php if($atts['title']) { ?>

                        <div class="content">
                            <?php
                            $html = '';
                            if($atts['title']){?>
                                <h4 class="bannertitle" <?php echo esc_attr($color);?>>
                                    <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($target); ?>">
                                        <?php echo esc_html($atts['title']) ;?>
                                    </a>
                                </h4>
                            <?php }?>

                        </div>
                <?php } ?>
                <span class="border-mask"></span>
            </div>
        </div>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

add_shortcode('na_banners', 'na_shortcode_banners');

add_action('vc_before_init', 'na_banners_integrate_vc');

if (!function_exists('na_banners_integrate_vc')) {
    function na_banners_integrate_vc()
    {
        vc_map(
            array(
                'name' => esc_html__('NA Image Banners', 'na-nano'),
                'base' => 'na_banners',
                'icon' => 'icon-nano',
                'category' => esc_html__('NA', 'na-nano'),
                'description' => esc_html__('Show Image Banners', 'na-nano'),
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Image', 'na-nano'),
                        'value' => '',
                        'param_name' => 'image',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', 'na-nano'),
                        'value' => '',
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => __( 'Title  Color','na-nano'),
                        'param_name' => 'text_color'
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => __( 'URL (Link)', 'na-nano' ),
                        'param_name' => 'link',
                        'description' => __( 'Add link to button.', 'na-nano' ),

                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Extra class name', 'na-nano' ),
                        'param_name' => 'el_class',
                        'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'na-nano' )
                    )
                    
                )
            )
        );
    }
}