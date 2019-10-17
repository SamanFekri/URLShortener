<?php
/**
 * @package     wide
 * @version     2.0
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

class WP_Customize_Category_Control extends WP_Customize_Control
{
    public $type = 'category';
    /**
     * Render the control's content.
     *
     * @since 3.4.0
     */
    public function render_content()
    {
        $dropdown = wp_dropdown_categories(
            array(
                'name' => '_customize-dropdown-categories-' . esc_attr($this->id),
                'echo' => 0,
                'show_option_none' => esc_html__('&mdash; Select &mdash;', 'wide'),
                'option_none_value' => '0',
                'selected' => $this->value(),
            )
        );

        // Hackily add in the data link parameter.
        $dropdown = str_replace('<select', '<select ' . esc_html($this->get_link()), $dropdown);

        printf(
            '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
            $this->label,
            $dropdown
        );
    }
}
