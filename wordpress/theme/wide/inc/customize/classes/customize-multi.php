<?php
/**
 * @package     wide
 * @version     2.0
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

class WP_Customize_Multiple_Control extends WP_Customize_Control {

/**
* The type of customize control being rendered.
*/
public $type = 'multiple';

/**
* Displays the multiple select on the customize screen.
*/
public function render_content() {

if ( empty( $this->choices ) )
return;
?>
<label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <select <?php $this->link(); ?> multiple="multiple">
        <?php
        foreach ( $this->choices as $value => $label ) {
            $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
            echo '<option value="' . esc_attr( $value ) . '"' . esc_attr($selected) . '>' . esc_html($label) . '</option>';
        }
        ?>
    </select>
</label>
<?php }
}