<?php
/**
 * The Shortcode Services
 */
function na_services_image_shortcode( $atts) {
    $atts = shortcode_atts(
        array(
            'services-image'            =>'',
            'title'                     => 'Free delivery worldwide',
            'url_link'                  => '#',
            'des'                       =>''
        ), $atts );
    ob_start();
    ?>
    <div class="widget widget-services-image">
        <div class="widget-content widget-services-content clearfix">



            <div class="image">
                <?php
                $image    = wp_get_attachment_image_src( $atts['services-image'], 'nano-services-image');
                if ( !empty( $image ) && isset($image)) {
                    $url_link = $image[0];
                    echo '<img class="services-image" src="'.$url_link .'" alt="services-image"> ';
                }
                ?>
            </div>
            <h3 class="title-service"><?php echo esc_html($atts['title']);?></h3>
            <div class="services-content">

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

add_shortcode( 'na_services_image', 'na_services_image_shortcode' );

/**
 * The VC Functions
 */
function na_services_image_shortcode_vc() {

    vc_map(
        array(
            'icon'     => 'na-vc-services',
            'name'     => __( 'NA - Services Image', 'na-nano' ),
            'base'     => 'na_services_image',
            'category' => __( 'NA', 'na-nano' ),
            'params'   => array(
                array(
                    'type'        => 'attach_image',
                    'heading'     => __( 'Icon Image(size default :500x314 )', 'na-nano' ),
                    'param_name'  => 'services-image',
                    'description' => __( 'Select images from media library.', 'na-nano' ),
                    'value'      => ''
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

add_action( 'vc_before_init', 'na_services_image_shortcode_vc' );