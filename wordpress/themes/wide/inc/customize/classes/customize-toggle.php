<?php
/**
 * @package     wide
 * @version     2.0
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
class WP_Customize_Toggle_Control extends WP_Customize_Control {

/**
* The type of customize control being rendered.
*/

public $type = 'toggle';

/**
* Displays the multiple select on the customize screen.
*/

public function render_content() {

	?>

	<label>

	    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

	    <div class="customize-control-<?php echo esc_html( $this->type ); ?>-checkbox ">

			<input type="checkbox" class="wide-toggle" id="<?php echo esc_attr( $this->id ); ?>-checkbox" value="1"
			<?php $this->link(); checked( $this->value(), 1 ); ?> />
			<label for="<?php echo esc_attr( $this->id ); ?>-checkbox"></label>

	    </div>
	</label>

	<?php }
}
