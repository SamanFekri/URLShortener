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

if (!class_exists('NA_Custom_Post_Type_Portfolio')) {
    class NA_Custom_Post_Type_Portfolio
    {
        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new NA_Custom_Post_Type_Portfolio();
            }
            return $instance;
        }

        public function init() {
            add_action('init', array($this, 'register_portfolio'));
            add_action('init', array($this, 'register_portfolio_category'));
        }

        public function register_portfolio()
        {
            $labels = array(
                'name' => __('Portfolio', 'na-nano'),
                'singular_name' => __('Portfolio Item', 'na-nano'),
                'add_new' => __('Add New portfolio item', 'na-nano'),
                'add_new_item' => __('Add New Portfolio Item', 'na-nano'),
                'edit_item' => __('Edit Portfolio Item', 'na-nano'),
                'new_item' => __('New Portfolio Item', 'na-nano'),
                'view_item' => __('View Portfolio Item', 'na-nano'),
                'search_items' => __('Search Portfolio', 'na-nano'),
                'not_found' => __('No portfolio items have been added yet', 'na-nano'),
                'not_found_in_trash' => __('Nothing found in Trash', 'na-nano'),
                'parent_item_colon' => ''
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => false,
                'menu_icon' => 'dashicons-format-image',
                'hierarchical' => false,
                'rewrite' => array(
                    'slug' => 'portfolio'
                ),
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'revisions'
                ),
                'has_archive' => true,
            );

            register_post_type('portfolio', $args);
        }

        public function register_portfolio_category()
        {
            $args = array(
                "label" => __('Portfolio Categories', 'na-nano'),
                "singular_label" => __('Portfolio Category', 'na-nano'),
                'public' => true,
                'hierarchical' => true,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'args' => array('orderby' => 'term_order'),
                'rewrite' => array(
                    'slug' => 'portfolio_category',
                    'with_front' => false,
                    'hierarchical' => true,
                ),
                'query_var' => true
            );
            register_taxonomy('portfolio_category', 'portfolio', $args);
        }
    }

    NA_Custom_Post_Type_Portfolio::getInstance()->init();
}
