<?php

function na_shortcode_testimonial($atts)
{
    ob_start();
    nano_template_part('shortcode', 'testimonial', array('atts' => $atts));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;

}

add_shortcode('na_testimonial', 'na_shortcode_testimonial');

add_action('vc_before_init', 'na_testimonial_integrate_vc');

if (!function_exists('na_testimonial_integrate_vc')) {
    function na_testimonial_integrate_vc()
    {
        vc_map(
            array(
                'name' => __('NA Testimonial', 'na-nano'),
                'base' => 'na_testimonial',
                'icon' => 'icon-na',
                'category' => __('NA', 'na-nano'),
                'description' => __('Show testimonial carousel', 'na-nano'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title Widget', 'na-nano'),
                        'value' => '',
                        'param_name' => 'box_title',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Number item show', 'na-nano'),
                        'value' => '',
                        'param_name' => 'number',
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => __('Number of testimonial', 'na-nano'),
                        'value' => '',
                        'param_name' => 'posts_per_page',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __( 'Link Target', 'na-nano' ),
                        'param_name' => 'target',
                        'value' => array(
                            __( 'Same window', 'na-nano' ) => '_self',
                            __( 'New window', 'na-nano' ) => "_blank"
                        ),
                        'dependency' => array(
                            'element' => 'img_link',
                            'not_empty' => true
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __( 'Auto slide', 'na-nano' ),
                        'param_name' => 'auto',
                        'description' => __( 'If checked, image will auto run carousel.', 'na-nano' ),
                        'value' => array( __( 'Yes', 'na-nano' ) => 'true' )
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Extra class name', 'na-nano' ),
                        'param_name' => 'el_class',
                        'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'na-nano' )
                    )

                )
            )
        );
    }
}