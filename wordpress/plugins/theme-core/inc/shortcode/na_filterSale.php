<?php
/**
 * The Shortcode Fileter to Sale
 */

function na_filterSale_shortcode( $atts, $content = null ) {
    ob_start();
    nano_template_part('shortcode', 'filterSale', array('atts' => $atts));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'na_filterSale', 'na_filterSale_shortcode' );

add_action( 'vc_before_init', 'na_filterSale_shortcode_vc' );

/**
 * The VC Functions
 */
function na_filterSale_shortcode_vc() {
    vc_map(
        array(
            'icon'     => 'na-filterSale',
            'name'     => __( 'NA filterSale Products', 'na-nano' ),
            'base'     => 'na_filterSale',
            'category' => __( 'NA', 'na-nano' ),
            'params'   => array(


                array(
                    'type'       => 'textfield',
                    'heading'    => __( 'Text before SALE', 'na-nano' ),
                    'param_name' => 'before_title',
                    'value'      => 'SALE OFF',
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => __( 'Text after SALE', 'na-nano' ),
                    'param_name' => 'after_title',
                    'value'      => 'FOR ALL ITEMS',
                ),

                array(
                    'type'       => 'textarea',
                    'heading'    => __( 'Description of products to show', 'na-nano' ),
                    'param_name' => 'description',
                    'value'      => '',
                ),

                array(
                    'type' => 'vc_link',
                    'heading' => __( 'URL (Link)', 'na-nano' ),
                    'param_name' => 'link',
                    'description' => __( 'Add link to button.', 'na-nano' ),

                ),

            )
        )
    );
}
?>