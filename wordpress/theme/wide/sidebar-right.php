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
$sidebar = $sidebar_right =array();
$sidebar=wide_sidebar_config();
$sidebar_right=$sidebar[1];
?>

<?php if(isset($sidebar_right) && !empty($sidebar_right)) {
    if ( is_active_sidebar( $sidebar_right ) ) : ?>
        <div id="sidebar-right" class="col-md-3 col-lg-3 sidebar <?php echo esc_attr($style_sidebar);?>">
            <div class="content-inner">
                <?php dynamic_sidebar( $sidebar_right ); ?>
            </div>
        </div>
    <?php endif; ?>

<?php } ?>