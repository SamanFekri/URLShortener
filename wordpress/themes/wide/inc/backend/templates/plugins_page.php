<?php
/**
 * Plugins Theme Page
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
?>
<div class="nano-install-plugins">
    <div class="theme-browser rendered">
        <?php
        $plugins = TGM_Plugin_Activation::$instance->plugins;
        $installed_plugins = get_plugins();
        foreach( $plugins as $plugin ):
            $class = '';
            $plugin_status = '';
            $file_path = $plugin['file_path'];
            $plugin_action = $this->wide_theme_plugin_links( $plugin );
            if( is_plugin_active( $file_path ) ) {
                $plugin_status = 'active';
                $class = 'active';
            }
            ?>
            <div class="theme <?php echo esc_attr($class); ?>">
                <div class="theme-screenshot">
                    <img src="<?php echo esc_url($plugin['image_url']); ?>" alt="img-plugin" />
                </div>
                <h3 class="theme-name">
                    <?php echo esc_attr($plugin['name']); ?>
                    <?php if( isset( $installed_plugins[$plugin['file_path']] ) ): ?>
                        <div class="plugin-info">
                            <?php echo sprintf( esc_html__('Version %s','wide'), $installed_plugins[$plugin['file_path']]['Version'] ); ?>
                        </div>
                    <?php endif; ?>
                </h3>
                <div class="theme-actions">
                    <?php
                    foreach( $plugin_action as $action ) {
                        echo  $action;
                    }
                    ?>
                </div>
                <?php
                if( isset( $plugin_action['update'] ) && $plugin_action['update'] ): ?>
                    <div class="theme-update nano-update">
                        <?php esc_html_e('Update Available: Version','wide'); ?> <?php echo esc_attr($plugin['version']); ?>
                    </div>
                <?php endif; ?>
                <?php
                if( $plugin['required'] ): ?>
                    <div class="plugin-required">
                        <?php echo esc_html__( 'Required', 'wide' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </div>
</div>
