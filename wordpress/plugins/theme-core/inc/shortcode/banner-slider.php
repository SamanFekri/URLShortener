<?php
/**
 * NA Core Plugin
 * @package     NA Core
 * @version     0.1
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

function na_shortcode_banner_slider($atts)
{

    $atts = shortcode_atts(
        array(
            'posts_per_page' => "-1",
            'number' => 5,
            'order' => 'DESC',
            'orderby' => 'date',
            'target' => '_blank',
            'speed' => 1000,
            'auto' => 'true',
            'arrow' => 'true',
            'size' => 'medium',
            'el_class'=> '',

        ), $atts);

    return na_get_template_part('shortcode', 'banner-slider', array('atts' => $atts));
}

add_shortcode('na_banner_slider', 'na_shortcode_banner_slider');

add_action('vc_before_init', 'na_banner_slider_integrate_vc');

if (!function_exists('na_banner_slider_integrate_vc')) {
    function na_banner_slider_integrate_vc()
    {
        vc_map(
            array(
                'name' => esc_html__('NA Banner Slider', 'na-nano'),
                'base' => 'na_banner_slider',
                'icon' => 'icon-nano',
                'category' => esc_html__('NA', 'na-nano'),
                'description' => esc_html__('Show banner carousel', 'na-nano'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Number of banner', 'na-nano'),
                        'value' => '',
                        'param_name' => 'posts_per_page',
                        'description' => esc_html__('Number of banner in slide', 'na-nano'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Number item show', 'na-nano'),
                        'value' => '',
                        'param_name' => 'number',
                        'description' => esc_html__('Number of image showing', 'na-nano'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Order by', 'na-nano' ),
                        'param_name' => 'orderby',
                        'value' => array(
                            '',
                            esc_html__( 'Date', 'na-nano' ) => 'date',
                            esc_html__( 'ID', 'na-nano' ) => 'ID',
                            esc_html__( 'Author', 'na-nano' ) => 'author',
                            esc_html__( 'Title', 'na-nano' ) => 'title',
                            esc_html__( 'Modified', 'na-nano' ) => 'modified',
                            esc_html__( 'Random', 'na-nano' ) => 'rand',
                            esc_html__( 'Comment count', 'na-nano' ) => 'comment_count',
                            esc_html__( 'Menu order', 'na-nano' ) => 'menu_order'
                        ),
                        'description' => sprintf( esc_html__( 'Select how to sort retrieved posts. More at %s.', 'na-nano' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Order', 'na-nano' ),
                        'param_name' => 'order',
                        'value' => array(
                            esc_html__( 'Descending', 'na-nano' ) => 'DESC',
                            esc_html__( 'Ascending', 'na-nano' ) => 'ASC'
                        ),
                        'description' => sprintf( esc_html__( 'Select ascending or descending order. More at %s.', 'na-nano' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Link Target', 'na-nano' ),
                        'param_name' => 'target',
                        'value' => array(
                            esc_html__( 'Same window', 'na-nano' ) => '_self',
                            esc_html__( 'New window', 'na-nano' ) => "_blank"
                        ),
                        'dependency' => array(
                            'element' => 'img_link',
                            'not_empty' => true
                        ),
                        'description' => esc_html__('Number of product will showing', 'na-nano'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Slide Speed', 'na-nano'),
                        'value' => '1000',
                        'param_name' => 'speed',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Auto slide', 'na-nano' ),
                        'param_name' => 'auto',
                        'description' => esc_html__( 'If checked, image will auto run carousel.', 'na-nano' ),
                        'value' => array( esc_html__( 'Yes', 'na-nano' ) => 'true' )
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Show Arrow', 'na-nano' ),
                        'param_name' => 'arrow',
                        'value' => array( esc_html__( 'Yes', 'na-nano' ) => 'true' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Banner size', 'na-nano' ),
                        'param_name' => 'size',
                        'value' => 'medium',
                        'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'na-nano' )
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