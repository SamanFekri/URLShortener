<?php
/**
 * The Shortcode Services
 */
function na_services_shortcode( $atts) {
    $atts = shortcode_atts(
        array(
            'title'         => 'Free delivery worldwide',
            'btn_names'     => 'Read More',
            'url_link'      => '#',
            'des'           =>'',
            'text_color'    =>'',
            'bg_box'        =>'',
            'box_style'     =>'',
        ), $atts );
    $text_color = $bg_box = '';
    if($atts['text_color']){
        $text_color[]            = vc_get_css_color( 'color', $atts['text_color'] );
        $text_color[]            = vc_get_css_color( 'border-color', $atts['text_color'] );
        $text_color              = ' style=' .implode( '', $text_color ) .'';
    }
    if($atts['bg_box']){
        $bg_box[]            = vc_get_css_color( 'background', $atts['bg_box'] );
        $bg_box              = ' style=' .implode( '', $bg_box ) .'';
    }
    ob_start(); ?>
    <div class="widget widget-services-box <?php echo esc_attr($atts['box_style']);?>">
        <div class="widget-content widget-services-content  clearfix" <?php echo esc_attr($bg_box);?>>
            <div class="services-content slide-border" <?php echo esc_attr($text_color);?>>
                <div class="title">
                    <h3 class="title-service">
                        <a  <?php echo esc_attr($text_color);?> href="<?php echo esc_url($atts['url_link']); ?>"><?php echo esc_html($atts['title']);?></a>
                    </h3>
                </div>
                <div class="des-services"><p><?php echo $atts['des'];?></p></div>
                <?php if($atts['btn_names']){?>
                    <div class="button-services">
                        <a  class="btn-services" <?php echo esc_attr($text_color);?> href="<?php echo esc_url($atts['url_link']); ?>"><?php echo $atts['btn_names'];?></a>
                    </div>
                <?php }?>
                <span class="overlay_border"></span>
            </div>
        </div>
    </div>
    <!-- /.services -->

    <?php
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

add_shortcode( 'na_services', 'na_services_shortcode' );

/**
 * The VC Functions
 */
function na_services_shortcode_vc() {

    vc_map(
        array(
            'icon'     => 'na-vc-services',
            'name'     => __( 'NA - Services', 'na-nano' ),
            'base'     => 'na_services',
            'category' => __( 'NA', 'na-nano' ),
            'params'   => array(
                array(
                    'type'       => 'textfield',
                    'heading'    => __( 'Title', 'na-nano' ),
                    'param_name' => 'title',
                    'value'      => 'Free delivery worldwide',
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => __( 'Button Name', 'na-nano' ),
                    'param_name' => 'btn_names',
                    'value'      => 'Read more',
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => __( 'URL link', 'na-nano' ),
                    'param_name' => 'url_link',
                    'value'      => '#',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'heading' => __( 'Content', 'na-nano' ),
                    'param_name' => 'des',
                    'value' =>''
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __( 'Color text','na-nano'),
                    'param_name' => 'text_color',
                    'std' => '',
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __( 'Background Box','na-nano'),
                    'param_name' => 'bg_box',
                    'std' => '',
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Select style', 'na-nano'),
                    'value' => array(
                        __('Style Boxed ', 'na-nano')     => 'style-1',
                        __('Style Text', 'na-nano')       => 'style-2',
                    ),
                    'param_name' => 'box_style',
                    'std' => 'style-1',
                ),
            )
        )
    );
}

add_action( 'vc_before_init', 'na_services_shortcode_vc' );