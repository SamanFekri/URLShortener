<?php

	// Theme Version
	if ( ! function_exists( 'wide_theme_version' ) ) :
		function wide_theme_version() {
			$wide_theme = wp_get_theme(get_template());
			return $wide_theme->get('Version');
		}
	endif;

	// Theme Name
	if ( ! function_exists( 'wide_theme_name' ) ) :
		function wide_theme_name() {
			$wide_theme = wp_get_theme();
			return $wide_theme->get('Name');
		}
	endif;

	function wide_load_settings()
	{
		$settings=array(
			'home'=> array(
				'name_home'		=>esc_html__('Home', 'wide' ),
				'live_preview'	=>'http://wide.nanoagency.co/',
				'demo_xml'		=>'http://guide.nanoagency.co',
				'demo_image'	=>get_template_directory_uri() . '/inc/backend/assets/images/home/home1.jpg',
				'class_install'	=>'show',
				'class_active'	=>'hidden',
				'class_deactivate'	=>'hidden'
			),
			'home-2'=> array(
				'name_home'		=>esc_html__('Home 2', 'wide' ),
				'live_preview'	=>'http://wide.nanoagency.co/home-2',
				'demo_xml'		=>'http://wide.nanoagency.co/',
				'demo_image'	=>get_template_directory_uri() . '/inc/backend/assets/images/home/home2.jpg',
				'class_install'	=>'show',
				'class_active'	=>'hidden',
				'class_deactivate'	=>'hidden'
			),
			'home-3'=> array(
				'name_home'		=> esc_html__('Home 3', 'wide' ),
				'live_preview'	=>'http://wide.nanoagency.co/home-3',
				'demo_xml'		=>'http://wide.nanoagency.co/',
				'demo_image'	=>get_template_directory_uri() . '/inc/backend/assets/images/home/home3.jpg',
				'class_install'	=>'show',
				'class_active'	=>'hidden',
				'class_deactivate'	=>'hidden'
			),
			'home-4'=> array(
				'name_home'		=> esc_html__('Home 4', 'wide' ),
				'live_preview'	=>'http://wide.nanoagency.co/home-4',
				'demo_xml'		=>'http://wide.nanoagency.co/',
				'demo_image'	=>get_template_directory_uri() . '/inc/backend/assets/images/home/home4.jpg',
				'class_install'	=>'show',
				'class_active'	=>'hidden',
				'class_deactivate'	=>'hidden'
			),
			'home-5'=> array(
				'name_home'		=>esc_html__('Home 5', 'wide' ),
				'live_preview'	=>'http://wide.nanoagency.co/home-5',
				'demo_xml'		=>'http://wide.nanoagency.co/',
				'demo_image'	=>get_template_directory_uri() . '/inc/backend/assets/images/home/home5.jpg',
				'class_install'	=>'show',
				'class_active'	=>'hidden',
				'class_deactivate'	=>'hidden'
			),
			'home-6'=> array(
				'name_home'		=> esc_html__('Home 6', 'wide' ),
				'live_preview'	=>'http://wide.nanoagency.co/home-6',
				'demo_xml'		=>'http://wide.nanoagency.co/',
				'demo_image'	=>get_template_directory_uri() . '/inc/backend/assets/images/home/home6.jpg',
				'class_install'	=>'show',
				'class_active'	=>'hidden',
				'class_deactivate'	=>'hidden'
			),

		);

		return $settings;
	}
	$wide_settings = wide_load_settings();
?>