<?php
// Enqueue child theme styles
function wide_child_theme_styles() {
    wp_enqueue_style( 'wide-child-theme', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wide_child_theme_styles', 1000 );
	