<?php
/**
 * @package     wide
 * @version     2.0
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

class WP_Customize_Sidebar_Control extends WP_Customize_Control {

    /**
     * The type of customize control being rendered.
     */
    public $type = 'sidebar';

    /**
     * Displays the multiple select on the customize screen.
     */
    public function render_content() {

        if ( empty( $GLOBALS['wp_registered_sidebars'] ) )
            return;

        $select = '<select>';
            foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
                $selected = ($sidebar['id'] == $this->value()) ? 'selected="selected"' : '';
                $select .= '<option value="'.esc_attr($sidebar['id']).'" '.esc_attr($selected).'>'.esc_html(ucwords( $sidebar['name'] )).'</option>';
             }
        $select .= '</select>';

        // Hackily add in the data link parameter.
        $dropdown = str_replace('<select', '<select ' . esc_html($this->get_link()), $select);

        printf(
            '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
            $this->label,
            $dropdown
        );


    }
}