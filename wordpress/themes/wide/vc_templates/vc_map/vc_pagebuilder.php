<?php
// ADD attributes Single_image
add_action( 'vc_after_init', 'wide_add_button_param' );
add_action( 'vc_after_init', 'wide_add_effect_param' );

function wide_add_button_param() {
    $buttom =array(
        'type' => 'textfield',
        'heading' => esc_html__( "Name Buttom", 'wide' ),
        'param_name' => 'btn_name',
        'value' => "",
        'description' => esc_html__( "Name Buttom", 'wide' )
    );
    vc_add_param( 'vc_single_image', $buttom );
}
function wide_add_effect_param() {
    $effect =array(
                'type' => 'dropdown',
                'heading' => "Image Effect",
                'param_name' => 'image_effect',
                'value' => array( "no-effect", "affect-zoom","affect-zoom-animation", "affect-plus","affect-border","affect-fast","affect-zoo-border"),
                'description' => esc_html__( "Image effect ", 'wide' )
            );
    vc_add_param( 'vc_single_image', $effect );
}

// ADD attributes Parallax
add_action( 'vc_after_init', 'wide_add_parallax_param' );
function wide_add_parallax_param() {
    $setting = array(
        'type' => 'dropdown',
        'heading' => __( 'Parallax', 'wide' ),
        'param_name' => 'parallax',
        'value' => array(
            __( 'None', 'wide' )      => '',
            __( 'Simple', 'wide' )    => 'content-moving',
            __( 'Image', 'wide' )     => 'content-moving-image',
            __( 'With fade', 'wide' ) => 'content-moving-fade',
        ),
        'description' => __( 'Add parallax type background for row (Note: If no image is specified, parallax will use background image from Design Options).', 'wide' ),
        'dependency' => array(
            'element' => 'video_bg',
            'is_empty' => true,
        ),
    );
    vc_add_param( 'vc_row', $setting );
}


