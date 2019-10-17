<?php
/**
 * NA Core Plugin
 * @package     NA Core
 * @version     0.1
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

function na_shortcode_team_member($atts)
{

    $atts = shortcode_atts(
        array(
            'box_title' => "",
            'eb_slider' => "no",
            'num_slider' => "3",
            'num_smalldes' => "",
            'num_tablet' => "",
            'num_mobile' => "",
            'order' => "",
            'eb_position' => "",
            'eb_social' => "",
            'el_class'=> '',

        ), $atts);

    return na_get_template_part('shortcode', 'team-member', array('atts' => $atts));
}

add_shortcode('na_team_member', 'na_shortcode_team_member');

add_action('vc_before_init', 'na_team_member_integrate_vc');

if (!function_exists('na_team_member_integrate_vc')) {
    function na_team_member_integrate_vc()
    {
        vc_map(
            array(
                'name' => esc_html__('NA Team Member', 'na-nano'),
                'base' => 'na_team_member',
                'icon' => 'icon-nano',
                'category' => esc_html__('NA', 'na-nano'),
                'description' => esc_html__('Show team member', 'na-nano'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title name', 'na-nano' ),
                        'param_name' => 'box_title',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Enable Slider', 'na-nano' ),
                        'param_name' => 'eb_slider',
                        'value' => array(
                            esc_html__( 'Yes', 'na-nano' ) => 'yes',
                            esc_html__( 'No', 'na-nano' ) => 'no'
                        ),
                        'std' => 'no',
                        'description' => ''
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Number Slider', 'na-nano' ),
                        'param_name' => 'num_slider',
                        'value' => array(
                            esc_html__( '1', 'na-nano' ) => '1',
                            esc_html__( '2', 'na-nano' ) => '2',
                            esc_html__( '3', 'na-nano' ) => '3',
                            esc_html__( '4', 'na-nano' ) => '4',
                            esc_html__( '6', 'na-nano' ) => '6'
                        ),
                        'description' => '',
                        'std' => '3'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Number Small Destop', 'na-nano' ),
                        'param_name' => 'num_smalldes',
                        'value' => array(
                            esc_html__( '1', 'na-nano' ) => '1',
                            esc_html__( '2', 'na-nano' ) => '2',
                            esc_html__( '3', 'na-nano' ) => '3',
                            esc_html__( '4', 'na-nano' ) => '4',
                            esc_html__( '6', 'na-nano' ) => '6'
                        ),
                        'description' => '',
                        'dependency' => Array('element' => 'eb_slider', 'value' => array('yes')),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Number Tablet', 'na-nano' ),
                        'param_name' => 'num_tablet',
                        'value' => array(
                            esc_html__( '1', 'na-nano' ) => '1',
                            esc_html__( '2', 'na-nano' ) => '2',
                            esc_html__( '3', 'na-nano' ) => '3',
                            esc_html__( '4', 'na-nano' ) => '4',
                            esc_html__( '6', 'na-nano' ) => '6'
                        ),
                        'description' => '',
                        'dependency' => Array('element' => 'eb_slider', 'value' => array('yes')),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Number Mobile', 'na-nano' ),
                        'param_name' => 'num_mobile',
                        'value' => array(
                            esc_html__( '1', 'na-nano' ) => '1',
                            esc_html__( '2', 'na-nano' ) => '2',
                            esc_html__( '3', 'na-nano' ) => '3',
                            esc_html__( '4', 'na-nano' ) => '4',
                            esc_html__( '6', 'na-nano' ) => '6'
                        ),
                        'description' => '',
                        'dependency' => Array('element' => 'eb_slider', 'value' => array('yes')),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Order', 'na-nano' ),
                        'param_name' => 'order',
                        'value' => array(
                            esc_html__( 'Descending', 'na-nano' ) => 'DESC',
                            esc_html__( 'Ascending', 'na-nano' ) => 'ASC'
                        ),
                        'description' => sprintf( esc_html__( 'Select ascending or descending order. More at %s.', 'na-nano' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Enable Position', 'na-nano' ),
                        'param_name' => 'eb_position',
                        'value' => array(
                            esc_html__( 'Yes', 'na-nano' ) => 'yes',
                            esc_html__( 'No', 'na-nano' ) => 'no'
                        ),
                        'std' => 'yes',
                        'description' => ''
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Enable Social', 'na-nano' ),
                        'param_name' => 'eb_social',
                        'value' => array(
                            esc_html__( 'Yes', 'na-nano' ) => 'yes',
                            esc_html__( 'No', 'na-nano' ) => 'no'
                        ),
                        'std' => 'yes',
                        'description' => ''
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Extra class name', 'na-nano' ),
                        'param_name' => 'el_class',
                        'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'na-nano' )
                    )

                )
            )
        );
    }
}
