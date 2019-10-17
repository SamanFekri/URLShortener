<?php
/**
 * Nano Core Plugin
 * @package     Nano Core
 * @version     0.1
 * @author      NanoAgency
 * @link        http://www.nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

?>
<ul class="wide-custom-simple label clearfix" data-attribute="<?php echo esc_attr( $attribute['name'] ); ?>">
	<?php 
	foreach ( $values as $value ) :

		$term = get_term_by( 'name', $value, $attribute['name'] );
		if ( $term ) :
			$label = get_woocommerce_term_meta( $term->term_id, "{$attribute['name']}_wide_value" );
			?>
			<li class="label" data-value="<?php echo esc_attr( $value ); ?>"><?php echo esc_attr( $label ); ?></li>
			<?php

		endif;
	endforeach;
	?>
</ul>
