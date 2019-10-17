<?php

if (!function_exists('na_shortcode_image_hover')) {
    function na_shortcode_image_hover($atts)
    {

        $atts = shortcode_atts(
            array(
                'image' => '',
                'title' => '',
                'sub_title' => '',
                'link' => '#',
                'text_link' => 'View More',
                'style' => 1,
                'el_class' => ''

            ), $atts);

        return na_get_template_part('shortcode', 'image-hover', array('atts' => $atts));
    }
}

add_shortcode('na_image_hover', 'na_shortcode_image_hover');

add_action('vc_before_init', 'na_image_hover_integrate_vc');

if (!function_exists('na_image_hover_integrate_vc')) {
    function na_image_hover_integrate_vc()
    {
        vc_map(
            array(
                'name' => esc_html__('NA Image Hover', 'na-nano'),
                'base' => 'na_image_hover',
                'icon' => 'icon-nano',
                'category' => esc_html__('NA', 'na-nano'),
                'description' => esc_html__('Show Image Hover', 'na-nano'),
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
                        'type' => 'textfield',
                        'heading' => esc_html__('Sub Title', 'na-nano'),
                        'value' => '',
                        'param_name' => 'sub_title',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Link', 'na-nano'),
                        'value' => '',
                        'param_name' => 'link',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Text Link', 'na-nano'),
                        'value' => '',
                        'param_name' => 'text_link',
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