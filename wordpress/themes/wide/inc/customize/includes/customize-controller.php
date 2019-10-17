<?php
/**
 * @package     NA Core
 * @version     0.1
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
if (!class_exists('wide_Customize')) {
    class wide_Customize
    {
        public $customizers = array();

        public $panels = array();

        public function init()
        {
            $this->customizer();
            add_action('customize_controls_enqueue_scripts', array($this, 'wide_customizer_script'));
            add_action('customize_register', array($this, 'wide_register_theme_customizer'));
            add_action('customize_register', array($this, 'remove_default_customize_section'), 20);
        }

        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new wide_Customize();
            }
            return $instance;
        }

        protected function customizer()
        {
            $this->panels = array(

                'site_panel' => array(
                    'title'             => esc_html__('Style Setting','wide'),
                    'description'       => esc_html__('Style Setting >','wide'),
                    'priority'          =>  101,
                ),
                'sidebar_panel' => array(
                    'title'             => esc_html__('Sidebar','wide'),
                    'description'       => esc_html__('Sidebar Setting','wide'),
                    'priority'          => 103,
                ),
                'wide_option_panel' => array(
                    'title'             => esc_html__('Option','wide'),
                    'description'       => '',
                    'priority'          => 104,
                ),
            );

            $this->customizers = array(
                'title_tagline' => array(
                    'title' => esc_html__('Site Identity', 'wide'),
                    'priority'  =>  1,
                    'settings' => array(
                        'wide_logo' => array(
                            'class' => 'image',
                            'label' => esc_html__('Logo', 'wide'),
                            'description' => esc_html__('Upload Logo Image', 'wide'),
                            'priority' => 12
                        ),
                    )
                ),
//2.General ============================================================================================================
            'wide_general' => array(
            'title' => esc_html__('General', 'wide'),
            'description' => '',
            'priority' => 2,
            'settings' => array(

                'wide_bg_body' => array(
                    'label'         => esc_html__('Background - Body', 'wide'),
                    'description'   => '',
                    'class'         => 'color',
                    'priority'      => 2,
                    'params'        => array(
                        'default'   => '',
                    ),
                ),
                'wide_primary_body' => array(
                    'label'         => esc_html__('Primary - Color', 'wide'),
                    'description'   => '',
                    'class'         => 'color',
                    'priority'      => 1,
                    'params'        => array(
                        'default'   => '',
                    ),
                ),
            )
        ),
//3.Header =============================================================================================================
                'wide_header' => array(
                    'title' => esc_html__('Header', 'wide'),
                    'description' => '',
                    'priority' => 3,
                    'settings' => array(
                        //header
                        'wide_header_heading' => array(
                            'class' => 'heading',
                            'label' => esc_html__('Header', 'wide'),
                            'priority' => 0,
                        ),

                        'wide_header' => array(
                            'class'=> 'layout',
                            'label' => esc_html__('Header Layout', 'wide'),
                            'priority' =>1,
                            'choices' => array(
                                'simple'        => get_template_directory_uri().'/assets/images/header/default.png',
//                                'drawer'        => get_template_directory_uri().'/assets/images/header/offcanvas.png',
//                                'vertical'      => get_template_directory_uri().'/assets/images/header/vertical.png',
                                'center'        => get_template_directory_uri().'/assets/images/header/center.png',
                                'left'    => get_template_directory_uri().'/assets/images/header/left.png',
//                                'stack'         => get_template_directory_uri().'/assets/images/header/stack.png',

                            ),
                            'params' => array(
                                'default' => 'center',
                            ),
                        ),

                        'wide_menu_keep' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Menu Keep', 'wide'),
                            'priority' =>4,
                            'params' => array(
                                'default' => false,
                            ),
                        ),

                        'wide_bg_header' => array(
                            'label'         => __('Background - Header', 'wide'),
                            'description'   => '',
                            'class'         => 'color',
                            'priority'      => 5,
                            'params'        => array(
                                'default'   => '',
                            ),
                        ),

                        'wide_color_menu' => array(
                            'label'         => __('Color - Text', 'wide'),
                            'description'   => '',
                            'class'         => 'color',
                            'priority'      => 6,
                            'params'        => array(
                                'default'   => '',
                            ),
                        ),

                        //topbar
                        'wide_topbar_heading' => array(
                            'class' => 'heading',
                            'label' => esc_html__('Top bar', 'wide'),
                            'priority' => 7,
                        ),

                        'wide_topbar_config' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Enable Topbar', 'wide'),
                            'priority' => 8,
                            'params' => array(
                                'default' => true,
                            ),
                        ),

                        'wide_bg_topbar' => array(
                            'label'         => __('Background - Top bar', 'wide'),
                            'description'   => '',
                            'class'         => 'color',
                            'priority'      => 9,
                            'params'        => array(
                                'default'   => '',
                            ),
                        ),
                        'wide_color_topbar' => array(
                            'label'         => __('Color - Text ', 'wide'),
                            'description'   => '',
                            'class'         => 'color',
                            'priority'      => 10,
                            'params'        => array(
                                'default'   => '',
                            ),
                        ),

                    )
                ),
//4.Footer =============================================================================================================
                'wide_new_section_footer' => array(
                    'title' => __('Footer', 'wide'),
                    'description' => '',
                    'priority' => 4,
                    'settings' => array(
                        'wide_footer' => array(
                            'type' => 'select',
                            'label' => __('Choose Footer Style', 'wide'),
                            'description' => '',
                            'priority' => -1,
                            'choices' => array(
                                '1'     => __('Footer 1', 'wide'),
                                '2'     => __('Footer 2', 'wide'),
                                'hidden' => __('Hidden Footer', 'wide')
                            ),
                            'params' => array(
                                'default' => '1',
                            ),
                        ),


                        'wide_enable_footer' => array(
                            'type' => 'checkbox',
                            'label' => __('Enable Footer', 'wide'),
                            'description' => '',
                            'priority' => 0,
                            'params' => array(
                                'default' => '1',
                            ),
                        ),
                        'wide_enable_copyright' => array(
                            'type' => 'checkbox',
                            'label' => __('Enable Copyright', 'wide'),
                            'description' => '',
                            'priority' => 0,
                            'params' => array(
                                'default' => '1',
                            ),
                        ),
                        'wide_copyright_text' => array(
                            'type' => 'textarea',
                            'label' => __('Footer Copyright Text', 'wide'),
                            'description' => '',
                            'priority' => 0,
                        )

                    )
                ),

//5.Categories Blog ====================================================================================================
                'wide_blog' => array(
                    'title' => esc_html__('Blogs Categories', 'wide'),
                    'description' => '',
                    'priority' => 5,
                    'settings' => array(

                        'wide_sidebar_cat' => array(
                            'class'         => 'layout',
                            'label'         => esc_html__('Sidebar Layout', 'wide'),
                            'priority'      =>3,
                            'choices'       => array(
                                'left'         => get_template_directory_uri().'/assets/images/left.png',
                                'right'        => get_template_directory_uri().'/assets/images/right.png',
                                'full'         => get_template_directory_uri().'/assets/images/full.png',
                            ),
                            'params' => array(
                                'default' => 'right',
                            ),
                        ),
                        'wide_siderbar_cat_info' => array(
                            'class' => 'info',
                            'label' => esc_html__('Info', 'wide'),
                            'description' => esc_html__( 'Please goto Appearance > Widgets > drop drag widget to the sidebar Article.', 'wide' ),
                            'priority' => 4,
                        ),
                        //
                        'wide_layout_cat_heading' => array(
                            'class' => 'heading',
                            'label' => esc_html__('Post Layout', 'wide'),
                            'priority' =>20,
                        ),
                        'wide_layout_cat_content' => array(
                            'class'         => 'layout',
                            'priority'      =>21,
                            'choices'       => array(
                                'list'         => get_template_directory_uri().'/assets/images/list.png',
                                'grid'        => get_template_directory_uri().'/assets/images/grid.png',
                            ),
                            'params' => array(
                                'default' => 'list',
                            ),
                        ),
                        'wide_number_post_cat' => array(
                            'class' => 'slider',
                            'label' => esc_html__('Number post on a row', 'wide'),
                            'description' => '',
                            'priority' =>22,
                            'choices' => array(
                                'max' => 3,
                                'min' => 1,
                                'step' => 1
                            ),
                            'params'      => array(
                                'default' =>1
                            ),
                        ),
                        //post article content
                        'wide_post_cat_article' => array(
                            'class' => 'heading',
                            'label' => esc_html__('Post content', 'wide'),
                            'priority' =>23,
                        ),
                        'show_layout_first' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('First post have is lager','wide'),
                            'priority' => 24,
                            'params' => array(
                                'default' => true,
                            ),
                        ),
                        'wide_post_entry_content' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Content ','wide'),
                            'priority' => 25,
                            'params' => array(
                                'default' => true,
                            ),
                        ),
                        'wide_number_content_post' => array(
                            'class' => 'slider',
                            'label' => esc_html__('Number of words in the description content', 'wide'),
                            'description' => '',
                            'priority' =>26,
                            'choices' => array(
                                'max' => 50,
                                'min' => 20,
                                'step' => 5
                            ),
                            'params'      => array(
                                'default' =>20
                            ),
                        ),
                        //post meta
                        'wide_cat_meta' => array(
                            'class' => 'heading',
                            'label' => esc_html__('Post meta', 'wide'),
                            'priority' =>27,
                        ),
                        'wide_post_meta_comment' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Comment ','wide'),
                            'priority' => 27,
                            'params' => array(
                                'default' => true,
                            ),
                        ),
                        'wide_post_meta_view' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('View ','wide'),
                            'priority' => 28,
                            'params' => array(
                                'default' => true,
                            ),
                        ),
                        'wide_post_meta_like' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Like ','wide'),
                            'priority' => 29,
                            'params' => array(
                                'default' => true,
                            ),
                        ),

                    ),
                 ),
//6.Single blog ========================================================================================================
                'wide_blog_single' => array(
                    'title' => esc_html__('Blog Single', 'wide'),
                    'description' => '',
                    'priority' => 6,
                    'settings' => array(
                        'wide_sidebar_single' => array(
                            'class'         => 'layout',
                            'label'         => esc_html__('Sidebar Layout', 'wide'),
                            'priority'      =>13,
                            'choices'       => array(
                                'left'         => get_template_directory_uri().'/assets/images/left.png',
                                'right'        => get_template_directory_uri().'/assets/images/right.png',
                                'full'         => get_template_directory_uri().'/assets/images/full.png',
                            ),
                            'params' => array(
                                'default' => 'right',
                            ),
                        ),

                        'wide_siderbar_single_info' => array(
                            'class' => 'info',
                            'label' => esc_html__('Info', 'wide'),
                            'description' => esc_html__( 'Please goto Appearance > Widgets > drop drag widget to the sidebar Article.', 'wide' ),
                            'priority' => 14,
                        ),
                        //excerpt
                        'wide_single_excerpt' => array(
                            'class' => 'heading',
                            'label' => esc_html__(' Post Excerpt', 'wide'),
                            'priority' =>15,
                        ),
                        'wide_share_excerpt' => array(
                            'class' => 'toggle',
                            'label' => esc_html__(' excerpt ','wide'),
                            'priority' => 16,
                            'params' => array(
                                'default' => true,
                            ),
                        ),
                        //share
                        'wide_single_share' => array(
                            'class' => 'heading',
                            'label' => esc_html__('Share', 'wide'),
                            'priority' =>17,
                        ),
                        'wide_share_count' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Count Share  ','wide'),
                            'priority' => 18,
                            'params' => array(
                                'default' => false,
                            ),
                        ),
                        'wide_share_facebook' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Share Facebook  ','wide'),
                            'priority' => 19,
                            'params' => array(
                                'default' => true,
                            ),
                        ),
                        'wide_share_twitter' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Share Twitter  ','wide'),
                            'priority' => 20,
                            'params' => array(
                                'default' => true,
                            ),
                        ),
                        'wide_share_google' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Share Google  ','wide'),
                            'priority' => 21,
                            'params' => array(
                                'default' => true,
                            ),
                        ),

                        'wide_share_linkedin' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Share Linkedin  ','wide'),
                            'priority' => 22,
                            'params' => array(
                                'default' => false,
                            ),
                        ),

                        'wide_share_pinterest' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Share Pinterest  ','wide'),
                            'priority' => 23,
                            'params' => array(
                                'default' => false,
                            ),
                        ),
                        //comments
                        'wide_single_comments' => array(
                            'class' => 'heading',
                            'label' => esc_html__('Comments', 'wide'),
                            'priority' =>25,
                        ),
                        'wide_comments_single_facebook' => array(
                            'class' => 'toggle',
                            'label' => esc_html__('Enable Facebook Comments ','wide'),
                            'priority' => 26,
                            'params' => array(
                                'default' => false,
                            ),
                        ),
                        'wide_comments_single' => array(
                            'type'          => 'text',
                            'label'         => __('Your app id :', 'wide'),
                            'priority'      => 27,
                            'params'        => array(
                                'default'   => '',
                            ),
                        ),
                        'wide_comments_single_info' => array(
                            'class' => 'info',
                            'label' => esc_html__('Info', 'wide'),
                            'description' => esc_html__('If you want show notification on  your facebook , please input app id ...', 'wide' ),
                            'priority' => 28,
                        ),
                    ),
                ),

//Font   ===============================================================================================================
                'wide_new_section_font_size' => array(
                    'title' => __('Font', 'wide'),
                    'priority' => 8,
                    'settings' => array(
                        'wide_body_font_google' => array(
                            'type'          => 'select',
                            'label'         => __('Use Google Font', 'wide'),
                            'choices'       => wide_googlefont(),
                            'priority'      => 0,
                            'params'        => array(
                                'default'       => 'Poppins',
                            ),
                            
                        ),
                        'wide_body_font_size' => array(
                            'class' => 'slider',
                            'label' => esc_html__('Font size ', 'wide'),
                            'description' => '',
                            'priority' =>8,
                            'choices' => array(
                                'max' => 30,
                                'min' => 10,
                                'step' => 1
                            ),
                            'params'      => array(
                                'default' => 14,
                            ),
                        ),
                    )
                ),
//Style  ===============================================================================================================


            );
        }

        public function wide_customizer_script()
        {
            // Register
            wp_enqueue_style('na-customize', get_template_directory_uri() . '/inc/customize/assets/css/customizer.css', array(),null);
            wp_enqueue_style('jquery-ui', get_template_directory_uri() . '/inc/customize/assets/css/jquery-ui.min.css', array(),null);
            wp_enqueue_script('na-customize', get_template_directory_uri() . '/inc/customize/assets/js/customizer.js', array('jquery'), null, true);
        }

        public function add_customize($customizers) {
            $this->customizers = array_merge($this->customizers, $customizers);
        }


        public function wide_register_theme_customizer()
        {
            global $wp_customize;

            foreach ($this->customizers as $section => $section_params) {

                //add section
                $wp_customize->add_section($section, $section_params);
                if (isset($section_params['settings']) && count($section_params['settings']) > 0) {
                    foreach ($section_params['settings'] as $setting => $params) {

                        //add setting
                        $setting_params = array();
                        if (isset($params['params'])) {
                            $setting_params = $params['params'];
                            unset($params['params']);
                        }
                        $wp_customize->add_setting($setting, array_merge( array( 'sanitize_callback' => null ), $setting_params));
                        //Get class control
                        $class = 'WP_Customize_Control';
                        if (isset($params['class']) && !empty($params['class'])) {
                            $class = 'WP_Customize_' . ucfirst($params['class']) . '_Control';
                            unset($params['class']);
                        }

                        //add params section and settings
                        $params['section'] = $section;
                        $params['settings'] = $setting;

                        //add controll
                        $wp_customize->add_control(
                            new $class($wp_customize, $setting, $params)
                        );
                    }
                }
            }

            foreach($this->panels as $key => $panel){
                $wp_customize->add_panel($key, $panel);
            }

            return;
        }

        public function remove_default_customize_section()
        {
            global $wp_customize;
//            // Remove Sections
//            $wp_customize->remove_section('title_tagline');
            $wp_customize->remove_section('header_image');
            $wp_customize->remove_section('nav');
            $wp_customize->remove_section('static_front_page');
            $wp_customize->remove_section('colors');
            $wp_customize->remove_section('background_image');
        }
    }
}