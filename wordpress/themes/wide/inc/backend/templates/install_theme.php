<?php
/**
 * Install Theme Page
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
?>
<div class="wrap nano-wrap vc-page-welcome about-wrap">
    <div class="group-wellcome clearfix">
        <div class="group-title">
            <h1><?php echo esc_html__('Welcome to','wide');?> <strong><?php echo esc_attr(wide_theme_name()); ?></strong></h1>
            <p><?php echo esc_html__('Thank you for using our theme ! ','wide')?></p>
        </div>
        <a class="nano-logo" href="<?php echo esc_url('http://wp.nanoagency.co/');?>" target="_blank">
            <img src="<?php echo get_template_directory_uri().'/inc/backend/assets/images/logo.png'; ?>"  alt="logo-nano" />
            <span class="version-theme"><?php echo esc_attr( "Version", 'wide' ); ?> <?php echo esc_attr(wide_theme_version()); ?></span>
        </a>
    </div>
    <?php require_once(get_template_directory() .'/inc/backend/templates/header/pages-header.php'); ?>
</div>

