<?php
/**
 * Na Core Plugin
 * @package     Nano Agency
 * @version     1.0
 * @author      Nano Agency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2016 Nano Agency
 * @license     GPL v2
 */


if (!function_exists('na_shortcode_recent_post')) {
    function na_shortcode_recent_post($atts)
    {

        ob_start();
        nano_template_part('shortcode', 'recent-post', array('atts' => $atts));
        $output = ob_get_contents();
        ob_end_clean();
        return $output;

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
                    "param_name" => "box_title",
                    "admin_label" => true,
                    'description' => esc_html__('Enter text used as shortcode title (Note: located above content element)', 'na-nano'),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Title align', 'na-nano'),
                    'value' => array(
                        __('Center', 'na-nano')   => 'center',
                        __('Left', 'na-nano')     => 'left',
                        __('Right', 'na-nano')    => 'right',
                        __('Hidden', 'na-nano')   => 'hidden'
                    ),
                    'param_name' => 'title_align',
                    'std'       =>'left'
                ),
                array(
                    "type" => "nano_post_categories",
                    "heading" => esc_html__("Category IDs", 'na-nano'),
                    "description" => esc_html__("Select category", 'na-nano'),
                    "param_name" => "cat",
                    "admin_label" => true,
                    'description' => esc_html__('Select category which you want to get post in', 'na-nano'),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __("Choose Style:", 'na-nano'),
                    'param_name' => 'na_style',
                    'value' => array(
                        __('Grid', 'na-nano')       => 'na-grid',
                        __('List', 'na-nano')       => 'na-list',
                    ),
                    'std' => 'na-list',
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Column number', 'na-nano'),
                    'value' => array(
                        __('1 Columns', 'na-nano') => 'col-md-12 col-sm-12',
                        __('2 Columns', 'na-nano') => 'col-md-6 col-sm-6',
                        __('3 Columns', 'na-nano') => 'col-md-4 col-sm-4',
                        __('4 Columns', 'na-nano') => 'col-md-3 col-sm-6',
                        __('6 Columns', 'na-nano') => 'col-md-2 col-sm-4'
                    ),
                    'std' => 'col-md-6 col-sm-6',
                    'param_name' => 'na_col',
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Post number", 'na-nano'),
                    "param_name" => "posts_per_page",
                    "value" => 4,
                    'description' => esc_html__('Number of post showing', 'na-nano'),
                ),

                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Extra class name', 'na-nano' ),
                    'param_name' => 'el_class',
                    'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'na-nano' )
                ),
            )
        ));
    }
}
