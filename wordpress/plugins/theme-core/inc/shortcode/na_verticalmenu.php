<?php

function na_shortcode_verticalmenu($atts)
{
    global $post;
    $atts = shortcode_atts(
        array(
            'box_title'       =>'',
            'el_class'        => '',

        ), $atts);

    ob_start(); ?>

    <div class="widget widget-verticalmenu">
        <?php if ( $atts['box_title'] ) {?>
            <h3 class="widgettitle">
                <i class="fa fa-list"></i>
                <span><?php echo htmlspecialchars_decode( $atts['box_title'] ); ?></span>
            </h3>
        <?php }?>
        <div class="widget-content na-verticalmenu <?php echo  $atts['el_class'];?>">
            <div  class="nav-menu-primary">
                    <nav id="na-menu-vertical" class="collapse navbar-collapse container-inner">
                        <?php
                        if (has_nav_menu('vertical_navigation')) :
                            // Main Menu
                            wp_nav_menu( array(
                                'theme_location' => 'vertical_navigation',
                                'menu_class'     => 'nav navbar-nav na-menu-vertical',
                                'container'      => '',
                            ) );
                        endif;
                        ?>
                    </nav>
            </div>
        </div>
    </div>
    <!-- /.services -->

    <?php
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

add_shortcode('na_verticalmenu', 'na_shortcode_verticalmenu');

add_action('vc_before_init', 'na_verticalmenu_integrate_vc');

if (!function_exists('na_verticalmenu_integrate_vc')) {
    function na_verticalmenu_integrate_vc()
    {
        vc_map(
            array(
                'name' => __('NA verticalmenu', 'na-nano'),
                'base' => 'na_verticalmenu',
                'icon' => 'icon-nano',
                'category' => __('NA', 'na-nano'),
                'description' => __('Show verticalmenu carousel', 'na-nano'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title Widget', 'na-nano'),
                        'value' => '',
                        'param_name' => 'box_title',
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Extra class name', 'na-nano' ),
                        'param_name' => 'el_class',
                        'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'na-nano' )
                    )

                )
            )
        );
    }
}