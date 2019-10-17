<?php

/* Products Shortcode ================================================================================== */

if (!function_exists('na_custom_heading')) {
    function na_custom_heading($atts, $content) {
        $atts = shortcode_atts(array(
            'heading_text' 			    => 'This is custom heading element',
            'heading_size' 	            => '',
            'heading_color'             =>'',
            'btn_name' 				    => 'Purchase',
            'bg_btn' 				    => '',
            'link_url' 				    => '#',
            'el_class' 				    => ''

        ), $atts);
        $output='';
        ob_start();
        $heading_css=$botton_css=array();
        if($atts['heading_size']){
            $heading_css[]  = str_replace( '_', '-','font-size' ) . ': ' . $atts['heading_size'].'; ';
        }
        if($atts['heading_color']){
            $heading_css[] .= vc_get_css_color( 'color', $atts['heading_color'] );
        }

        $heading_css    = ' style="' . implode( '', $heading_css ) . '"';
        if($atts['bg_btn']){
            $botton_css[]   = vc_get_css_color( 'background-color', $atts['bg_btn'] );
        }

        $botton_css     = ' style="' . implode( '', $botton_css ) . '"';

        ?>
        <div class="widget wg-custom-heading">
            <div class="widget-content clearfix">
                <div class="text-heading" <?php  echo $heading_css;?> >
                    <?php  echo $atts['heading_text']; ?>
                </div>
                <div class="buttom-heading">
                    <a class="btn-inverse" href="<?php echo $atts['link_url'];?>" <?php echo $botton_css;?> >
                        <?php echo $atts['btn_name'];?>
                    </a>
                </div>
                <?php
                ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;


    }
}

add_shortcode('na_heading', 'na_custom_heading');

add_action('vc_before_init', 'na_custom_heading_vc');

if (!function_exists('na_custom_heading_vc')) {
    function na_custom_heading_vc()
    {
        vc_map( array(
            'name' => __( 'NA Custom Text','na-nano'),
            'base' => 'na_heading',
            'icon' => 'icon-nano',
            'category' => __('NA', 'na-nano'),
            'show_settings_on_create' => true,
            'description' => __( 'Text with Google fonts', 'na-nano' ),
            'params' => array(
                array(
                    'type' => 'textarea',
                    'heading' => __( 'Text', 'na-nano' ),
                    'param_name' => 'heading_text',
                    'admin_label' => true,
                    'value' => __( 'This is custom heading element', 'na-nano' ),
                    'description' => __( 'Note: If you are using non-latin characters be sure to activate them under Settings/Visual Composer/General Settings.', 'na-nano' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Font Size', 'na-nano' ),
                    'param_name' => 'heading_size'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __( 'Heading Color','na-nano'),
                    'param_name' => 'heading_color'
                ),

                array(
                    'type' => 'textfield',
                    'heading' => __( 'Button  name', 'na-nano' ),
                    'param_name' => 'btn_name',
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __( 'Background Color','na-nano'),
                    'param_name' => 'bg_btn',
                    'description' => __( 'Select custom Background color.', 'na-nano' )
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Link url', 'na-nano' ),
                    'param_name' => 'link_url',
                    'value' => '#'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Extra class name', 'na-nano' ),
                    'param_name' => 'el_class',
                    'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'na-nano' ),
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __( 'CSS box', 'na-nano' ),
                    'param_name' => 'css',
                    'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'na-nano' ),
                    'group' => __( 'Design Options', 'na-nano' )
                )
            ),
        ) );
    }
}