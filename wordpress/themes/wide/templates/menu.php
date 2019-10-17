<div  class="nav-menu-primary na-keep menu-full">
    <div  class="nav-menu-iner container">

        <nav id="na-menu-primary" class="collapse navbar-collapse container-inner">
            <?php
            if (has_nav_menu('primary_navigation')) :
                // Main Menu
                wp_nav_menu( array(
                    'theme_location' => 'primary_navigation',
                    'menu_class'     => 'nav navbar-nav na-menu',
                    'container'      => '',
                ) );
            endif;
            ?>
        </nav>

    </div>
</div>