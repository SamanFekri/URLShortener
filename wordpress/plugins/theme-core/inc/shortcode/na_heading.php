<?php

/* Products Shortcode ================================================================================== */

if (!function_exists('na_widget_heading')) {
    function na_widget_heading($atts, $content) {
        $atts = shortcode_atts(array(
            'title_sub' 			    => 'Title Sub',
            'title_sub_color' 			=> '',
            'title' 			        => 'This is Title',
            'title_color'             =>'',
            'el_class' 				    => ''

        ), $atts);
        $output='';
        ob_start();

        $title_sub_color='';
        if($atts['title_sub_color'] && !empty($atts['title_sub_color'])){
            $title_sub_color[]  = str_replace( '_', '-','color' ) . ': ' . $atts['title_sub_color'].'; ';
            $title_sub_color    = ' style=' . implode( '', $title_sub_color ) . '';
        }

        $title_color='';
        if($atts['title_color'] && !empty($atts['title_color'])){
            $title_color[] .= vc_get_css_color( 'color', $atts['title_color'] );
            $title_color    = ' style=' .implode( '', $title_color ).'';
        }

        ?>
        <div class="widgettitle">
                <div class="widget-sub" <?php echo esc_attr($title_sub_color);?> >
                    <?php  echo esc_attr($atts['title_sub']); ?>
                </div>
                <div class="widget-title" <?php echo esc_attr($title_color);?> >
                    <?php  echo esc_attr($atts['title']); ?>
                </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;


    }
}

add_shortcode('na_heading', 'na_widget_heading');

add_action('vc_before_init', 'na_widget_heading_vc');

if (!function_exists('na_widget_heading_vc')) {
    function na_widget_heading_vc()
    {
        vc_map( array(
            'name' => __( 'Title Widget','nano'),
            'base' => 'na_heading',
            'icon' => 'icon-na',
            'category' => __('NA', 'nano'),
            'show_settings_on_create' => true,
            'description' => __( 'Text with Google fonts', 'nano' ),
            'params' => array(
                array(
                    'type' => 'textarea',
                    'heading' => __( 'Title Sub', 'nano' ),
                    'param_name' => 'title_sub',
                    'admin_label' => true,
                    'value' => __( 'Title Sub', 'nano' ),
                    'description' => __( 'Note: If you are using non-latin characters be sure to activate them under Settings/Visual Composer/General Settings.', 'nano' ),
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __( 'Title Sub Color','nano'),
                    'param_name' => 'title_sub_color'
                ),

                array(
                    'type' => 'textarea',
                    'heading' => __( 'Title', 'nano' ),
                    'param_name' => 'title',
                    'admin_label' => true,
                    'value' => __( 'This is Title', 'nano' ),
                    'description' => __( 'Note: If you are using non-latin characters be sure to activate them under Settings/Visual Composer/General Settings.', 'nano' ),
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __( 'Title Color','nano'),
                    'param_name' => 'title_color'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Font Size', 'nano' ),
                    'param_name' => 'heading_size'
                ),

                array(
                    'type' => 'textfield',
                    'heading' => __( 'Extra class name', 'nano' ),
                    'param_name' => 'el_class',
                    'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'nano' ),
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __( 'CSS box', 'nano' ),
                    'param_name' => 'css',
                    'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'nano' ),
                    'group' => __( 'Design Options', 'nano' )
                )
            ),
        ) );
    }
}