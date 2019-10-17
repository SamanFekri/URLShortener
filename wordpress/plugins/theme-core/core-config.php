<?php
/**
 * Nano Core Plugin
 * @package     Nano Core
 * @version     1.0.2
 * @author      Nanoagency
 * @link        http://www.nanoagency.co
 * @copyright   Copyright (c) 2015 Nanoagency
 * @license     GPL v2
 */

if ( ! defined( 'NANO_VERSION' ) ){
    define('NANO_VERSION', '1.0.2');
}

if ( ! defined( 'NANO_PLUGIN_PATH' ) ){
    define('NANO_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
}
if ( ! defined( 'NANO_PLUGIN_URL' ) ){
    define('NANO_PLUGIN_URL', plugins_url( '/', __FILE__ ));
}

if ( ! defined( 'NANO_DIRECTORY_NAME' ) ){
    $plugin_path = explode('/', str_replace('\\', '/', NANO_PLUGIN_PATH));
    define('NANO_DIRECTORY_NAME', $plugin_path[count($plugin_path) - 2 ]);
}
if ( ! defined( 'NANO_TEXT_DOMAIN' ) ){
    define('NANO_TEXT_DOMAIN', 'nano-language');
}

function theme_core_script()
{
    wp_enqueue_style('core-front', NANO_PLUGIN_URL . 'assets/css/na-core-front.css', array(), NANO_VERSION);
    wp_enqueue_script('core-front', NANO_PLUGIN_URL . 'assets/js/na-core-front.js', array('jquery'), NANO_VERSION, true);
}
add_action( 'wp_enqueue_scripts', 'theme_core_script');

add_action('admin_init', 'core_admin_scripts');
function core_admin_scripts() {
    wp_enqueue_style('core-admin', NANO_PLUGIN_URL . 'assets/css/na-core-admin.css', array(), NANO_VERSION);
    wp_enqueue_script('core-admin', NANO_PLUGIN_URL . 'assets/js/na-core-admin.js', array('jquery'), NANO_VERSION, true);
}

