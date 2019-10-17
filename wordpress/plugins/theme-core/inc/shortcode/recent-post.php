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

if (!function_exists('na_shortcode_recent_post')) {
    function na_shortcode_recent_post($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'columns' => 3,
            'cat' => '',
            'parent' => 1,
            'post_in' => '',
            'number' => 8,
            'view_more' => false,
            'el_class' => '',
            'pagination' => 0
        ), $atts);

        return na_get_template_part('shortcode', 'recent-post', array('atts' => $atts));
    }
}
add_shortcode('na_recent_post', 'na_shortcode_recent_post');

add_action('vc_before_init', 'na_recent_post_integrate_vc');

if (!function_exists('na_recent_post_integrate_vc')) {
    function na_recent_post_integrate_vc()
    {
        vc_map(array(
            'name' => esc_html__('NA Recent Post', 'na-nano'),
            'base' => 'na_recent_post',
            'category' => esc_html__('NA', 'na-nano'),
            'description' => esc_html__('Show recent post.', 'na-nano'),
            'icon' => 'na-blog',
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Title", 'na-nano'),
                    "param_name" => "title",
                    "admin_label" => true,
                    'description' => esc_html__('Enter text used as shortcode title (Note: located above content element)', 'na-nano'),
                ),
                array(
                    "type" => "na_post_categories",
                    "heading" => esc_html__("Category IDs", 'na-nano'),
                    "description" => esc_html__("Select category", 'na-nano'),
                    "param_name" => "cat",
                    "admin_label" => true,
                    'description' => esc_html__('Select category which you want to get post in', 'na-nano'),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Get posts in children of categories", 'na-nano'),
                    "param_name" => "parent",
                    'std' => 1,
                    "value" => array(
                        esc_html__('No', 'na-nano' ) => 0,
                        esc_html__('Yes', 'na-nano' ) => 1,
                    ),
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Post IDs", 'na-nano'),
                    "description" => esc_html__("comma separated list of post ids", 'na-nano'),
                    "param_name" => "post_in"
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Posts number", 'na-nano'),
                    "param_name" => "number",
                    "value" => '8',
                    'description' => esc_html__('Number of post showing', 'na-nano'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Extra class name', 'na-nano' ),
                    'param_name' => 'el_class',
                    'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'na-nano' )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Enable pagination", 'na-nano'),
                    "param_name" => "pagination",
                    'std' => '7',
                    "value" => array(
                        esc_html__('No', 'na-nano' ) => 0,
                        esc_html__('Yes', 'na-nano' ) => 1,
                    )
                )
            )
        ));
    }
}
