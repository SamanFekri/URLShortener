<?php
/**
 * Sample Theme Page
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

?>
    <div class="theme-browser rendered nano-import">
        <?php foreach ($settings  as $key => $value){
            $home =  $this->wide_get_id_by_slug($key);
            $home_active=get_option( 'page_on_front' );
            if(isset($home) && !empty($home)){
                $value['class_install']="hidden";
                $value['class_active']="show";
                if($home==$home_active){
                    $value['class_active']="hidden";
                    $value['class_deactivate']="show";
                }
            }
            ?>
            <div class="theme <?php if($value['class_deactivate']=="show"){echo esc_attr('active');} ?> col-3">
                <div class="theme-screenshot">
                    <img src="<?php echo esc_url($value['demo_image']); ?>" alt="demo_image">
                </div>
                <div class="nano-progress-import">
                    <p class="note"></p>
                    <div class="meter">
                        <span></span>
                    </div>
                </div>
                <h3 class="theme-name" id="default"><?php echo esc_attr(wide_theme_name() . " - " .$value['name_home']); ?></h3>

                <div class="theme-actions import-actions">
                    <a class="button button-primary nano-install-button <?php echo esc_attr($value['class_install']);?> "  href="#"><?php echo esc_attr('Install','wide'); ?></a>
                    <a class="button button-primary nano-active-button <?php echo esc_attr($value['class_active']);?> " data-demo-slug="<?php echo esc_attr($value['name_home']);?>" href="#"><?php echo esc_attr('Active','wide'); ?></a>
                    <a class="button button-primary nano-deactivate-button <?php echo esc_attr($value['class_deactivate']);?> "  href="#"><?php echo esc_attr('Deactivate','wide'); ?></a>
                    <?php printf( '<a class="button button-primary" target="_blank" href="%1s">%2s</a>',  $value['live_preview'], __( "Live Preview",'wide' ) ); ?>
                </div>
            </div>
        <?php } ?>
    </div>
