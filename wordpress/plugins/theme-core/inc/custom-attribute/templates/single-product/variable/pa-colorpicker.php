<?php 
/**
 * Name: Ri Elis
 * Package: RIT
 * Description: Main javascript functions.
 * Version: 1.0.0
 * Last update: 2016/07/06
 * Author: ZooTemplate
 */

?>
<ul class="nano-custom-attribute colorpicker clearfix" data-attribute="<?php echo esc_attr( $attribute_name ); ?>">
	<?php 
	foreach ( $options as $value ) :

		// Get custom data
		$term = get_term_by( 'name', $value, $attribute_name );
		if ( $term ) :
			// var_dump($term);
			$color = get_woocommerce_term_meta( $term->term_id, "{$attribute_name}_nano_value" );
			?>
			<li class="color att_color" style="background-color: <?php echo esc_attr( $color ); ?>" data-value="<?php echo esc_attr( $value ); ?>"></li>
			<?php

		endif;
	endforeach;
	?>
</ul>
