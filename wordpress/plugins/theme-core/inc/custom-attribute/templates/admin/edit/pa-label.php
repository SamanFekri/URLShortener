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

?>
<table class="form-table term-label-wrap">
	<tbody>
		<tr class="form-field form-required term-label">
			<th scope="row"><label for="term-label"><?php echo esc_html__( 'Label', 'nano' );?></label></th>
			<td >
				<input type="text" name="nano_label" id="nano_label" value="<?php echo esc_attr( get_woocommerce_term_meta( $term->term_id, "{$taxonomy}_nano_value" ) ); ?>" />
			</td>
		</tr>
	</tbody>
</table>