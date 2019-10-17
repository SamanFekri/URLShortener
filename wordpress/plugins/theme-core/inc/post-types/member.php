<?php

if (!class_exists('NA_Custom_Post_Type_Member')) {
    class NA_Custom_Post_Type_Member
    {
        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new NA_Custom_Post_Type_Member();
            }
            return $instance;
        }

        public function init() {
            add_action('init', array($this, 'register_member'));
            add_action('init', array($this, 'register_member_category'));
        }

        public function register_member()
        {
            $labels = array(
                'name' => __('NA Member', 'na-nano'),
                'singular_name' => __('member', 'na-nano'),
                'add_new' => __('Add New', 'na-nano'),
                'add_new_item' => __('Add New Member', 'na-nano'),
                'edit_item' => __('Edit Member', 'na-nano'),
                'new_item' => __('New Member', 'na-nano'),
                'view_item' => __('View Member', 'na-nano'),
                'search_items' => __('Search Member', 'na-nano'),
                'not_found' =>  __('No members have been added yet', 'na-nano'),
                'not_found_in_trash' => __('Nothing found in Trash', 'na-nano'),
                'parent_item_colon' => ''
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => false,
                'menu_icon'=> 'dashicons-welcome-view-site',
                'rewrite' => false,
                'supports' => array('title', 'editor'),
                'has_archive' => true,
            );

            register_post_type( 'member' , $args );
        }

        public function register_member_category()
        {
            $args = array(
                "label" 						=> __('Member Categories', 'na-nano'),
                "singular_label" 				=> __('Member Category', 'na-nano'),
                'public'                        => true,
                'hierarchical'                  => true,
                'show_ui'                       => true,
                'show_in_nav_menus'             => false,
                'args'                          => array( 'orderby' => 'term_order' ),
                'rewrite'                       => false,
                'query_var'                     => true
            );

            register_taxonomy( 'member_category', 'parallax', $args );
        }
    }

    NA_Custom_Post_Type_Member::getInstance()->init();
}