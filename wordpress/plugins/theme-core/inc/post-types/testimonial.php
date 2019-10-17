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

if (!class_exists('NA_Custom_Post_Type_Testimonial')) {
    class NA_Custom_Post_Type_Testimonial
    {
        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new NA_Custom_Post_Type_Testimonial();
            }
            return $instance;
        }

        public function init() {
            add_action('init', array($this, 'register_testimonial'));
            add_action('init', array($this, 'register_testimonial_category'));
        }

        public function register_testimonial()
        {
            $labels = array(
                'name' => esc_html__('Testimonials', 'na-nano'),
                'singular_name' => esc_html__('Testimonial', 'na-nano'),
                'add_new' => esc_html__('Add New', 'na-nano'),
                'add_new_item' => esc_html__('Add New Testimonial', 'na-nano'),
                'edit_item' => esc_html__('Edit Testimonial', 'na-nano'),
                'new_item' => esc_html__('New Testimonial', 'na-nano'),
                'view_item' => esc_html__('View Testimonial', 'na-nano'),
                'search_items' => esc_html__('Search Testimonials', 'na-nano'),
                'not_found' =>  esc_html__('No testimonials have been added yet', 'na-nano'),
                'not_found_in_trash' => esc_html__('Nothing found in Trash', 'na-nano'),
                'parent_item_colon' => ''
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => false,
                'menu_icon'=> 'dashicons-format-quote',
                'rewrite' => false,
                'supports' => array('title', 'editor'),
                'has_archive' => true,
            );

            register_post_type( 'testimonial' , $args );
        }

        public function register_testimonial_category()
        {
            $args = array(
                "label" 						=> esc_html__('Testimonial Categories', 'na-nano'),
                "singular_label" 				=> esc_html__('Testimonial Category', 'na-nano'),
                'public'                        => true,
                'hierarchical'                  => true,
                'show_ui'                       => true,
                'show_in_nav_menus'             => false,
                'args'                          => array( 'orderby' => 'term_order' ),
                'rewrite'                       => false,
                'query_var'                     => true
            );

            register_taxonomy( 'testimonial_category', 'testimonial', $args );
        }
    }

    NA_Custom_Post_Type_Testimonial::getInstance()->init();
}