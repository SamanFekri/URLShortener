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


if (!class_exists('NA_Custom_Post_Type_Banner')) {
    class NA_Custom_Post_Type_Banner
    {
        public function init() {
            add_action('init', array($this, 'register_banner'));
        }

        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new NA_Custom_Post_Type_Banner();
            }
            return $instance;
        }

        function register_banner()
        {

            $labels = array(
                'name' => esc_html__('Banner', 'na-nano'),
                'singular_name' => esc_html__('Banner', 'na-nano'),
                'menu_name' => esc_html__('Banner', 'na-nano'),
                'parent_item_colon' => esc_html__('Parent Banner :', 'na-nano'),
                'all_items' => esc_html__('All Banners', 'na-nano'),
                'view_item' => esc_html__('View Banner ', 'na-nano'),
                'add_new_item' => esc_html__('Add New Banner ', 'na-nano'),
                'add_new' => esc_html__('Add New Banner', 'na-nano'),
                'edit_item' => esc_html__('Edit Banner ', 'na-nano'),
                'update_item' => esc_html__('Update Banner ', 'na-nano'),
                'search_items' => esc_html__('Search Banner ', 'na-nano'),
                'not_found' => esc_html__('Not found', 'na-nano'),
                'not_found_in_trash' => esc_html__('Not found in Trash', 'na-nano'),
            );
            $args = array(
                'label' => esc_html__('Banner', 'na-nano'),
                'description' => esc_html__('Banner post type.', 'na-nano'),
                'labels' => $labels,
                'supports' => array('title', 'thumbnail',),
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'show_in_admin_bar' => true,
                'menu_position' => 80,
                'menu_icon' => 'dashicons-images-alt',
                'can_export' => true,
                'has_archive' => true,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'capability_type' => 'page',
            );
            register_post_type('banner', $args);
        }
    }

    NA_Custom_Post_Type_Banner::getInstance()->init();
}
