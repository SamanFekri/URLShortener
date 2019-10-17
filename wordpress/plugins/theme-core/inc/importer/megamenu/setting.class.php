<?php

if ( class_exists( 'Mega_Menu_Settings' ) && !class_exists( 'RIT_Mega_Menu_Settings' ) ) :

/**
 * Handles all admin related functionality.
 */
class RIT_Mega_Menu_Settings extends Mega_Menu_Settings{

    public function import_theme() {

        $this->init();

        $import = json_decode( stripslashes( $_POST['data'] ), true );

        if ( is_array( $import ) ) {

            $saved_themes = get_site_option( "megamenu_themes" );

            $next_id = $this->get_next_theme_id();

            $import['title'] = $import['title'] . " " . __('(Imported)', 'megamenu');

            $new_theme_id = "custom_theme_" . $next_id;

            $saved_themes[ $new_theme_id ] = $import;

            update_site_option( "megamenu_themes", $saved_themes );

            do_action("megamenu_after_theme_import");

            return true;

        } else {

            return false;

        }
    }
}

endif;