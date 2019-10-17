<?php
/**
 * Nano Core Plugin
 * @package     Nano Core
 * @version     0.1
 * @author      Nanoagency
 * @link        http://www.nanoagency.co
 * @copyright   Copyright (c) 2015 Nanoagency
 * @license     GPL v2
 */

// Enqueue Color Picker.
wp_enqueue_script( 'wp-color-picker' );
wp_enqueue_style( 'wp-color-picker' );
?>
<table class="form-table term-color-picker">
	<tbody>
		<tr class="form-field form-required term-<?php echo esc_attr( $taxonomy ); ?>-wrap">
			<th scope="row"><label for="term-color-picker"><?php echo esc_html__( 'Color', 'nano' );?></label></th>
			<td >
				<input type="text" name="nano_colorpicker" id="nano_colorpicker" value="<?php echo esc_attr( get_woocommerce_term_meta( $term->term_id, "{$taxonomy}_nano_value" ) ); ?>" />
					<p class="description"><?php echo esc_html__( 'Please pick a color', 'nano' ); ?></p>
			</td>
		</tr>
	</tbody>
</table>
<script>
	(function($) {
		$(document).ready(function() {
			$( '.term-color-picker input#nano_colorpicker' ).wpColorPicker();
		});
	})(jQuery);
</script>