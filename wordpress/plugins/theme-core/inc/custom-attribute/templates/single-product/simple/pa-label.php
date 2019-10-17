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
<ul class="nano-custom-simple label clearfix" data-attribute="<?php echo esc_attr( $attribute['name'] ); ?>">
	<?php 
	foreach ( $values as $value ) :

		// Get custom data
		$term = get_term_by( 'name', $value, $attribute['name'] );
		if ( $term ) :
			// var_dump($term);
			$label = get_woocommerce_term_meta( $term->term_id, "{$attribute['name']}_nano_value" );

			?>
			<li class="att_label" data-value="<?php echo esc_attr( $value ); ?>"><?php echo esc_attr( $label ); ?></li>
			<?php

		endif;
	endforeach;
	?>
</ul>
