<?php
/**
 * @package     NA Core
 * @version     2.0
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

$configTopbar = str_replace('','',wide_topbar_config() );

?>
<div id="na-top-navbar" class="top-navbar <?php echo esc_attr($configTopbar);?>">
    <div class="container">
        <div class="row">
            <div class="topbar-left hidden-xs col-sm-6 col-md-6 clearfix">
                <?php
                    if(is_active_sidebar( 'custom-topbar-left' )){
                        dynamic_sidebar('custom-topbar-left');
                    }
                    else {?>
                        <div class="language list-unstyled">
                            <?php wide_language_selector(); ?>
                        </div>

                        <?php
                        if (in_array('woocommerce-currency-switcher/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                            ?>
                            <div class="currency_switcher list-unstyled">
                                <div class="wrap-select-currency">
                                    <?php echo do_shortcode('[woocs show_flags=0]'); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="user-login list-unstyled">
                            <div>
                                <?php if (!is_user_logged_in()) { ?>
                                    <span class="hidden-xs"><?php esc_html_e('Welcome ', 'wide'); ?><a
                                            href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"><?php echo esc_html__('Guest', 'wide'); ?></a> !</span>
                                <?php } else { ?>
                                    <?php $current_user = wp_get_current_user(); ?>
                                    <span class="hidden-xs"><?php esc_html_e('Welcome ', 'wide'); ?><a
                                            href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"><?php echo esc_attr($current_user->display_name); ?></a> !</span>
                                <?php } ?>
                            </div>
                        </div>
                    <?php }?>
            </div>
            <div class="topbar-right col-xs-12 col-sm-6 col-md-6">
                    <div class="na-topbar clearfix ">
                        <nav id="na-top-navigation" class="collapse navbar-collapse container-inner">
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
        </div>

    </div>
</div>