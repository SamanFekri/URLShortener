<?php
/**
 * The sidebar containing the main widget area
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

$style_sidebar  = get_theme_mod('wide_site_style_sidebar','style-default');
$sidebar = $sidebar_left =array();
$sidebar=wide_sidebar_config();
$sidebar_left=$sidebar[0];
?>

<?php if(isset($sidebar_left) && !empty($sidebar_left)) {
    if ( is_active_sidebar( $sidebar_left) ) : ?>
    <div id="sidebar-left" class="col-md-3 col-lg-3 sidebar <?php echo esc_attr($style_sidebar);?>">
        <div class="content-inner">
        <?php dynamic_sidebar( $sidebar_left); ?>
        </div>
    </div>
    <?php endif; ?>

<?php } ?>