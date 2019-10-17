<?php
/**
 * @package     wide
 * @version     2.0
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
class WP_Customize_Heading_Control extends WP_Customize_Control
{

    /**
     * The type of customize control being rendered.
     */
    public $type = 'heading';

    /**
     * Displays the multiple select on the customize screen.
     */
    public function render_content()
    {
        $html = '';
        $html .= '<div class="wide-heading-custom"><h3>'. esc_html( $this->label ) .'</h3></div>';
        echo $html;
    }

}