<div class="canvas-menu">
    <div class="canvas-menu-inner">
        <span class="btn-close"><i class="fa fa-close"></i></span>

        <div id="main-navigation">
            <div class="searchform-wrap">
                <?php get_search_form(); ?>
            </div>
            <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'mobile_nav',
                        'menu_class' => 'nav-menu',
                        'menu_id' => 'mobile-menu'
                    )
                );
            ?>
        </div>
    </div>
</div>
