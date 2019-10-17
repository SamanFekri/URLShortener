<?php
/**
 * The Shortcode Services
 */
function na_services_icon_shortcode( $atts) {
    $atts = shortcode_atts(
        array(
            'icon_fa'       => 'fa-truck',
            'services-image'=>'',
            'title'         => 'Free delivery worldwide',
            'url_link'      => '#',
            'box_align'     =>'left',
            'des'           =>''
        ), $atts );
    ob_start(); ?>
    <div class="widget widget-services-icon <?php echo esc_attr($atts['box_align']);?>">
        <div class="widgetcontent widget-services-content clearfix">
            <div class="icon">
                <?php

                $image    = wp_get_attachment_image_src( $atts['services-image'], 'nano-services-image');
                if ( !empty( $image ) && isset($image)) {
                    $url_link = $image[0];
                    echo '<img class="services-image" src="'.$url_link .'" alt="services-image"> ';
                }
                else{
                    echo '<i class="fa '.$atts['icon_fa'].'"></i>';
                }
                ?>
            </div>
            <div class="services-content">
                <div class="title">
                    <h3 class="title-service">
                        <a href="<?php echo esc_url($atts['url_link']); ?>"><?php echo esc_html($atts['title']);?></a>
                    </h3>
                </div>
                <div class="des-services"><p><?php echo $atts['des'];?></p></div>

            </div>
        </div>
    </div>
    <!-- /.services -->

    <?php
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

add_shortcode( 'na_services_icon', 'na_services_icon_shortcode' );

/**
 * The VC Functions
 */
function na_services_icon_shortcode_vc() {

    vc_map(
        array(
            'icon'     => 'na-vc-services',
            'name'     => __( 'NA - Services Icon', 'na-nano' ),
            'base'     => 'na_services_icon',
            'category' => __( 'NA', 'na-nano' ),
            'description' => __('Box Services with icon ', 'na-nano'),
            'params'   => array(
                array(
                    'type'        => 'attach_image',
                    'heading'     => __( 'Icon Image(size default :50x42 )', 'na-nano' ),
                    'param_name'  => 'services-image',
                    'description' => __( 'Select images from media library.', 'na-nano' ),
                    'value'      => ''
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => __( 'Icon ', 'na-nano' ),
                    'param_name' => 'icon_fa',
                    'value'      => 'fa-truck',
                    'description' => __( 'Select icon from http://fontawesome.io/icons/', 'na-nano' )
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Select box-align', 'na-nano'),
                    'value' => array(
                        __('Left', 'na-nano')         => 'left',
                        __('Center', 'na-nano')       => 'center',
                        __('Right', 'na-nano')        => 'right',
                    ),
                    'param_name' => 'box_align',
                    'std' => 'left',
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => __( 'Title', 'na-nano' ),
                    'param_name' => 'title',
                    'value'      => 'Free delivery worldwide',
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

            )
        )
    );
}

add_action( 'vc_before_init', 'na_services_icon_shortcode_vc' );