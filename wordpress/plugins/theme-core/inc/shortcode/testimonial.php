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

if (!function_exists('na_shortcode_testimonial')) {
    function na_shortcode_testimonial($atts)
    {
        $atts = shortcode_atts(array(
            'box_title' => '',
            'text_size' => '',
            'item_count'	=> '-1',
            'order'	=> '',
            'category'		=> '',
            'pagination'	=> 'no',
            'page_link'	=> '',
            'el_class' => '',
        ), $atts);

        $layout_type = ($atts['testimonial_layout'] != '') ? $atts['testimonial_layout'] : 'large';

        return na_get_template_part('shortcode', 'testimonial-' . $layout_type, array('atts' => $atts));
    }
}
add_shortcode('testimonial', 'na_shortcode_testimonial');

add_action('vc_before_init', 'na_testimonial_integrate_vc');

if (!function_exists('na_testimonial_integrate_vc')) {
    function na_testimonial_integrate_vc()
    {
        vc_map( array(
            "name"		=> esc_html__("Testimonials", 'na-nano'),
            "base"		=> "testimonial",
            "class"		=> "",
            "icon"      => "spb-icon-testimonial",
            "wrapper_class" => "clearfix",
            "controls"	=> "full",
            "params"	=> array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Title", 'na-nano'),
                    "param_name" => "box_title",
                    "value" => "",
                    "description" => esc_html__("Heading text. Leave it empty if not needed.", 'na-nano')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Text size", 'na-nano'),
                    "param_name" => "text_size",
                    "value" => array(
                        esc_html__('Normal', 'na-nano') => "normal",
                        esc_html__('Large', 'na-nano') => "large"
                    ),
                    "description" => esc_html__("Choose the size of the text.", 'na-nano')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Number of items", 'na-nano'),
                    "param_name" => "item_count",
                    "value" => "6",
                    "description" => esc_html__("The number of testimonials to show per page. Leave blank to show ALL testimonials.", 'na-nano')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Testimonials Order", 'na-nano'),
                    "param_name" => "order",
                    "value" => array(
                        esc_html__('Random', 'na-nano') => "rand",
                        esc_html__('Latest', 'na-nano') => "date"
                    ),
                    "description" => esc_html__("Choose the order of the testimonials.", 'na-nano')
                ),
                array(
                    "type" => "select-multiple",
                    "heading" => esc_html__("Testimonials category", 'na-nano'),
                    "param_name" => "category",
                    "value" => sf_get_category_list('testimonials-category'),
                    "description" => esc_html__("Choose the category for the testimonials.", 'na-nano')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Pagination", 'na-nano'),
                    "param_name" => "pagination",
                    "value" => array(esc_html__('No', 'na-nano') => "no", esc_html__('Yes', 'na-nano') => "yes"),
                    "description" => esc_html__("Show testimonial pagination (1/1 width element only).", 'na-nano')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Testimonials page link", 'na-nano'),
                    "param_name" => "page_link",
                    "value" => array(esc_html__('No', 'na-nano') => "no", esc_html__('Yes', 'na-nano') => "yes"),
                    "description" => esc_html__("Include a link to the testimonials page (which you must choose in the theme options).", 'na-nano')
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Extra class name", 'na-nano'),
                    "param_name" => "el_class",
                    "value" => "",
                    "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'na-nano')
                )
            )
        ) );
    }
}
