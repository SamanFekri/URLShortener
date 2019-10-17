<?php

$keepMenu           = str_replace('','',wide_keep_menu() );
$menu_topbar        = str_replace('','',wide_menu_topbar() );
?>
<div id="header-placeholder" class="header-placeholder <?php echo esc_attr($keepMenu);?>"></div>
<header id="masthead" class="site-header header-center  <?php echo esc_attr($keepMenu);?>  <?php echo esc_attr($menu_topbar); ?>">
    <div id="wide-header">
        <!--Top bar-->
        <div class="header-topbar">
            <?php
                get_template_part('templates/topbar');
            ?>
        </div>
        <!--Logo-->
        <div class="header-content-logo">
            <?php
            get_template_part('templates/logo');
            ?>
        </div>
        <div class="wide-header-content">
            <div class="container">

                <div class="header-content">
                    <!-- Menu-->
                    <div id="na-menu-primary" class="nav-menu clearfix">
                        <nav class="text-center na-menu-primary clearfix">
                            <?php
//                            if (has_nav_menu('primary_navigation')) :
                                // Main Menu
                                wp_nav_menu( array(
                                    'theme_location' => 'primary_navigation',
                                    'menu_class'     => 'nav navbar-nav na-menu mega-menu',
                                    'container'      => '',
                                ) );
//                            endif;
                            ?>
                        </nav>
                    </div>
                    <!--Seacrch & Cart-->
                    <div class="header-content-right">
                        <div class="searchform-mini hidden-sm hidden-xs">
                            <button class="btn-mini-search"><i class="ti-search"></i></button>
                        </div>
                        <div class="searchform-wrap search-transition-wrap wide-hidden">
                            <div class="search-transition-inner">
                                <?php
                                    get_search_form();
                                ?>
                                <button class="btn-mini-close pull-right"><i class="fa fa-close"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
                </div>

        </div><!-- .container -->
    </div>
</header><!-- .site-header -->