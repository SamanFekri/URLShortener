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
<ul class="nano-custom-simple colorpicker clearfix" data-attribute="<?php echo esc_attr( $attribute['name'] ); ?>">
	<?php 
	// var_dump($attribute);
	foreach ( $values as $value ) :
		// Get custom data
		$term = get_term_by( 'name', $value, $attribute['name'] );
		if ( $term ) :
			$color = get_woocommerce_term_meta( $term->term_id, "{$attribute['name']}_nano_value" );
			?>
			<li class="color att_color" style="background-color: <?php echo esc_attr( $color ); ?>" data-value="<?php echo esc_attr( $value ); ?>"></li>
			<?php

		endif;
	endforeach;
	?>
</ul>
