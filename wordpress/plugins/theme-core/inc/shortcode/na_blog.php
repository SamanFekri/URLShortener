<?php
if (!function_exists('nano_shortcode_blog')) {
    function nano_shortcode_blog($atts)
    {
        $atts = shortcode_atts(array(
            'title'         => '',
            'post_layout'   => 'grid',
            'columns'       => 3,
            'category_name' => '',
            'number'        => 8,
            'view_more'     => false,
            'show_layout_first'     => true,
            'number_words'  =>'25',
            'el_class'      => ''
        ), $atts);

        $layout_type = ($atts['post_layout'] != '') ? $atts['post_layout'] : 'grid';
        ob_start();
        nano_template_part('shortcode', 'blog-' . $layout_type, array('atts' => $atts));
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
add_shortcode('blog', 'nano_shortcode_blog');

add_action('vc_before_init', 'nano_blog_integrate_vc');

if (!function_exists('nano_blog_integrate_vc')) {
    function nano_blog_integrate_vc()
    {
        vc_map(array(
            'name' => __('NA Blog Content', 'nano'),
            'base' => 'blog',
            'category' => __('NA', 'nano'),
            'icon' => 'nano-blog',
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Title", 'nano'),
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Blog Layout", 'nano'),
                    "param_name" => "post_layout",
                    'std' => 'timeline',
                    "value" => array(
                        __('Grid', 'nano' )         => 'grid',
                        __('List', 'nano' )         => 'list',
                    ),
                    "admin_label" => true
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Columns", 'nano'),
                    "param_name" => "columns",
                    'dependency' => Array('element' => 'post_layout', 'value' => array('grid')),
                    'std' => '3',
                    "value" => array(
                        __('1', 'nano' ) => 1,
                        __('2', 'nano' ) => 2,
                        __('3', 'nano' ) => 3,
                    )
                ),
                array(
                    "type" => "nano_post_categories",
                    "heading" => __("Category IDs", 'nano'),
                    "description" => __("Select category", 'nano'),
                    "param_name" => "category_name",
                    "admin_label" => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Posts Count", 'nano'),
                    "param_name" => "number",
                    "value" => '8'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __("When you tick the check box  then the first article that large layout", 'nano'),
                    'dependency' => Array('element' => 'post_layout', 'value' => array('grid')),
                    'param_name' => 'show_layout_first',
                    'std' => 'yes',
                    'value' => array(__('Yes', 'js_composer') => 'yes')
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __("Show content", 'nano'),
                    'param_name' => 'view_more',
                    'std' => 'no',
                    'value' => array(__('Yes', 'js_composer') => 'yes')
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Number of words in the description content", 'nano'),
                    'dependency' => Array('element' => 'view_more', 'value' =>'yes'),
                    "param_name" => "number_words",
                    "value" => '25'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Extra class name', 'nano' ),
                    'param_name' => 'el_class',
                    'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'nano' )
                )
            )
        ));
    }
}
