<?php
/**
 * @package     NA Core
 * @version     2.0
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

$configTopbar       = str_replace('','',wide_topbar_config() );
?>
<div id="wide-top-navbar" class="top-navbar <?php echo esc_attr($configTopbar);?>">
    <div class="container">
        <div class="row">
            <div class="topbar-left col-xs-12 col-sm-6 col-md-6">

                <div class="na-topbar clearfix">
                    <nav id="na-top-navigation" class="collapse navbar-collapse">
                        <?php
                        if (has_nav_menu('top_navigation')) :
                            // Main Menu
                            wp_nav_menu( array(
                                'theme_location' => 'top_navigation',
                                'menu_class'     => 'nav navbar-nav na-menu',
                                'container'      => '',
                            ) );
                        endif;
                        ?>
                    </nav>
                </div>
            </div>
            <div class="topbar-right hidden-xs col-sm-6 col-md-6 clearfix">
                <?php
                    if(is_active_sidebar( 'custom-topbar-right' )){
                        dynamic_sidebar('custom-topbar-right');
                    }?>
            </div>

        </div>

    </div>
</div>