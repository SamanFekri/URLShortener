<?php
/**
 * @package     wide
 * @version     2.0
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
class WP_Customize_Slider_Control extends WP_Customize_Control {

/**
* The type of customize control being rendered.
*/

public $type = 'slider';

/**
* Displays the multiple select on the customize screen.
*/

public function render_content() {
	if ( empty( $this->choices ) )
	return;

	$setting = $this->choices;

	?>
	<label>
		<div class="customize-control-<?php echo esc_html( $this->type ); ?> ">
	    	<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<label>
				<div class="wide-slider-range"  data-max="<?php echo esc_attr( $setting['max'] );?>" data-min="<?php echo esc_attr( $setting['min'] );?>" data-step="<?php echo esc_attr( $setting['step'] );?>"></div>
				<input type="text" class="wide-slider-range-input" name="wide_<?php echo esc_attr( $this->type ); ?>" value="<?php echo esc_attr( intval($this->value()) ); ?>" data-id="<?php echo esc_attr($this->id); ?>" />
			</label>
		</div>
	</label>
	<?php }
}
