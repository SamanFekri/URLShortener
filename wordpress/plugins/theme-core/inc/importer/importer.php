<?php

// Function For RIT Theme
add_action( 'admin_init', 'na_sample_data_script');
if(!function_exists('na_sample_data_script')){
	function na_sample_data_script(){
		wp_enqueue_script('na-sample-data-script', NANO_PLUGIN_URL. 'assets/js/dev/data-sample.js',array('jquery'), NANO_VERSION, true);
		$translation_array = array(
			'home_url' => esc_url( home_url( '/' ) ),
			'ajax_url' => wp_nonce_url(admin_url('admin-ajax.php')),
			'admin_theme_url' => wp_nonce_url(admin_url('themes.php'))
		);
		wp_localize_script( 'na-sample-data-script', 'NaScript', $translation_array );
	}
}

//Import sample xml ====================================================================================================
add_action( 'wp_ajax_import_data', 'nano_import_data' );
add_action('wp_ajax_nopriv_import_data', 'nano_import_data');
function nano_import_data(){
	if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
	require_once ABSPATH . 'wp-admin/includes/import.php';
	$importer_error = false;
	if ( !class_exists( 'WP_Importer' ) ) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if ( file_exists( $class_wp_importer ) ){
			require_once($class_wp_importer);
		}
		else{
			$importer_error = true;
		}
	}
	if ( !class_exists( 'WP_Import' ) ) {
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$class_wp_import = NANO_PLUGIN_PATH . 'inc/importer/wordpress-importer/wordpress-importer.php';
		if ( file_exists( $class_wp_import ) ){
			require_once($class_wp_import);
		}
		else{
			$importer_error = true;
		}
	}
	if($importer_error){
		die("Import error! Please unninstall WP importer plugin and try again");
	}
	else{
//		add_filter('intermediate_image_sizes_advanced', create_function('', 'return array();'));
		$wp_import = new WP_Import();
		$wp_import->fetch_attachments = true;
		$filexml = NANO_PLUGIN_PATH . 'inc/importer/data/data.xml';
		ob_start();
		$wp_import->import( $filexml);
		ob_end_clean();
	}
	die;
}

//Import widget ========================================================================================================
add_action('wp_ajax_import_widget', 'nano_import_widget');
add_action('wp_ajax_nopriv_import_widget', 'nano_import_widget');
function nano_import_widget(){
	if(!class_exists('Widget_Importer_Exporter')){
		include NANO_PLUGIN_PATH . '/inc/importer/widget-importer-exporter/includes/widgets.php';
		include NANO_PLUGIN_PATH . '/inc/importer/widget-importer-exporter/includes/import.php';
	}
	$file = NANO_PLUGIN_PATH . 'inc/importer/data/widgets.wie';
	$data = json_decode(file_get_contents( $file ));
	wie_import_data( $data );
	die;
}

//Slider ===============================================================================================================
add_action('wp_ajax_import_slider', 'nano_import_slider');
add_action('wp_ajax_nopriv_import_slider', 'nano_import_slider');
function nano_import_slider(){
	if( class_exists('RevSlider') ) {
		$slider_array = array(NANO_PLUGIN_PATH."inc/importer/data/home-1.zip",NANO_PLUGIN_PATH."inc/importer/data/home-2.zip");
		$slider = new RevSlider();
		foreach($slider_array as $filepath){
			$slider->importSliderFromPost(true,true,$filepath);
		}
	}
	return false;
}

//Active Home ==========================================================================================================
add_action('wp_ajax_active_home', 'nano_active_home');
add_action('wp_ajax_nopriv_active_home', 'nano_active_home');
function nano_active_home(){
	$key=$_POST['active_home'];
	$home = get_page_by_title($key);
	update_option('page_on_front',$home->ID);
	update_option('show_on_front','page');
	return false;
}
//Active Home ==========================================================================================================
add_action('wp_ajax_deactivate_home', 'nano_deactivate_home');
add_action('wp_ajax_nopriv_deactivate_home', 'nano_deactivate_home');
function nano_deactivate_home(){
	// The post id.
	update_option( 'show_on_front', 'posts' );
	update_option( 'page_on_front', 0 );
	return false;
}
?>