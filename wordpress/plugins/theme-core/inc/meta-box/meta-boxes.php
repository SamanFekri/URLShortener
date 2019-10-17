<?php
if (!class_exists('NA_Meta_Boxes')) {
    class NA_Meta_Boxes
    {
        public $meta_boxes;

        public function __construct()
        {
            $this->add_meta_box_options();
            add_action('admin_init', array($this, 'register'));
        }

        public static function &getInstance()
        {
            static $instance;
            if (!isset($instance)) {
                $instance = new NA_Meta_Boxes();
            }
            return $instance;
        }

        public function add_meta_box_options()
        {
            $meta_boxes = array();
            /* Page Options */
            $meta_boxes[] = array(
                'id'         => 'page_option',
                'title'      => __( 'Page Options', 'wide' ),
                'pages'      => array( 'page' ), // Post type
                'context'    => 'side',
                'priority'   => 'high',
                'show_names' => true, // Show field names on the left
                'fields'     => array(

                    array(
                        'name'       => __( 'Show Title', 'wide' ),
                        'id'         => 'na_show_title',
                        'type'       => 'checkbox',
                        'std'        => 1,
                    ),

                    array(
                        'name'       => __( 'Enable Top Bar', 'wide' ),
                        'id'         => 'menu_topbar',
                        'type'       => 'checkbox',
                        'std'        => '1',
                    ),
                    array(
                        'name'       => __( 'Header Style', 'wide' ),
                        'id'         => 'layout_header',
                        'type'       => 'select',
                        'options'    => array(
                            'global'            => __( 'Use Global', 'wide' ),
                            'simple'            => __('Header Simple', 'wide'),
//                            'drawer'            => __('Header Drawer', 'wide'),
//                            'vertical'          => __('Header Vertical', 'wide'),
                            'left'        => __('Header Left', 'wide'),
                        ),
                        'std'  => 'global',
                    ),
                    array(
                        'name'       => __( 'Footer Style', 'wide' ),
                        'id'         => 'layout_footer',
                        'type'       => 'select',
                        'options'    => array(
                            'global' => __( 'Use Global', 'wide' ),
                            '1'      => __( 'Footer 1', 'wide' ),
                            '2'      => __( 'Footer 2', 'wide' ),
//                            '3'      => __( 'Footer 3', 'wide' ),
                            'hidden'      => __( 'Hidden Footer', 'wide' ),
                        ),
                        'std'  => 'global',
                    ),
                    array(
                        'name' => __('Logo for  only Pages', 'wide'),
                        'desc' => __('', 'wide'),
                        'id' => "wide_logo",
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1
                    ),
                )
            );
            /* Layout Box */
            /* Banner Meta Box */
            $meta_boxes[] = array(
                'id' => 'banner_meta_box',
                'title' => __('Banner Options', 'wide'),
                'pages' => array('banner'),
                'context' => 'normal',
                'fields' => array(
                    array(
                        'name' => __('Banner Url', 'wide'),
                        'desc' => __('When click into banner, it will be redirect to this url', 'wide'),
                        'id' => "na_banner_url",
                        'type' => 'text'
                    ),
                    array(
                        'name' => __('Banner class', 'wide'),
                        'desc' => __('', 'wide'),
                        'id' => "na_banner_class",
                        'type' => 'text'
                    ),
                )
            );
            /* Member Meta Box */
            $meta_boxes[] = array(
                'id' => 'member_meta_box',
                'title' => __('Member Options', 'wide'),
                'pages' => array('member'),
                'context' => 'normal',
                'fields' => array(
                    array(
                        'name' => __('Member Image', 'wide'),
                        'desc' => __('', 'wide'),
                        'id' => "na_member_image",
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1
                    ),
                    array(
                        'name' => __('Member Position', 'wide'),
                        'desc' => __('', 'wide'),
                        'id' => "na_member_position",
                        'type' => 'text',
                        'std' => '#'
                    ),
                    array(
                        'name' => __('Link Facebook', 'wide'),
                        'desc' => __('', 'wide'),
                        'id' => "na_member_fb",
                        'type' => 'text',
                        'std' => '#'
                    ),
                    array(
                        'name' => __('Link Twitter', 'wide'),
                        'desc' => __('', 'wide'),
                        'id' => "na_member_tw",
                        'type' => 'text',
                        'std' => '#'
                    ),
                    array(
                        'name' => __('Link Instagram', 'wide'),
                        'desc' => __('', 'wide'),
                        'id' => "na_member_isg",
                        'type' => 'text',
                        'std' => '#'
                    ),
                    array(
                        'name' => __('Link Goolge +', 'wide'),
                        'desc' => __('', 'wide'),
                        'id' => "na_member_gl",
                        'type' => 'text',
                        'std' => '#'
                    ),
                )
            );

            /* Testimonial Meta Box */
            $meta_boxes[] = array(
                'id' => 'testimonial_meta_box',
                'title' => __('Testimonial Options', 'wide'),
                'pages' => array('testimonial'),
                'context' => 'normal',
                'fields' => array(
                    array(
                        'name' => __('Image User', 'wide'),
                        'id' => "na_testimonial_image",
                        'type' => 'image_advanced'
                    ),
                    array(
                        'name' => __('Position', 'wide'),
                        'desc' => __('', 'wide'),
                        'id' => "na_testimonial_position",
                        'type' => 'text'
                    ),
                )
            );

            /* Deal Meta Box */
            $meta_boxes[] = array(
                'id' => 'image_bg_meta_box',
                'title' => __('Image Deal Options', 'wide'),
                'pages' => array( 'product' ),
                'context' => 'normal',
                'fields' => array(

                    // BACKGROUND IMAGE
                    array(
                        'name'  => __('Featured Image For The Deal', 'wide'),
                        'desc'  => __('The image that will be used as the background , you should use file.png, default size: height=980px,width:246px', 'wide'),
                        'id'    => "na_image_product",
                        'type'  => 'image_advanced',
                        'max_file_uploads' => 1
                    ),
                )
            );
            $this->meta_boxes = $meta_boxes;
        }

        public function register()
        {
            if (class_exists('RW_Meta_Box')) {
                foreach ($this->meta_boxes as $meta_box) {
                    new RW_Meta_Box($meta_box);
                }
            }
        }
    }
}

NA_Meta_Boxes::getInstance();
