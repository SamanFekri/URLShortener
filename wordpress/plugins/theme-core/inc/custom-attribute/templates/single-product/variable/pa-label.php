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
<ul class="nano-custom-attribute label clearfix" data-attribute="<?php echo esc_attr( $attribute_name ); ?>">
	<?php 
	foreach ( $options as $value ) :

		// Get custom data
		$term = get_term_by( 'name', $value, $attribute_name );
		if ( $term ) :
			// var_dump($term);
			$label = get_woocommerce_term_meta( $term->term_id, "{$attribute_name}_nano_value" );

			?>
			<li class="att_label" data-value="<?php echo esc_attr( $value ); ?>"><?php echo esc_attr( $label ); ?></li>
			<?php

		endif;
	endforeach;
	?>
</ul>
