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
<ul class="nano-custom-attribute image clearfix" data-attribute="<?php echo esc_attr( $attribute_name ); ?>">
	<?php 
	
	foreach ( $options as $value ) :

		// Get custom data
		$term = get_term_by( 'slug', $value, $attribute_name );

		if ( $term ) :
			$link = get_woocommerce_term_meta( $term->term_id, "{$attribute_name}_nano_value" );
			?>
			<li class="image att_img" data-value="<?php echo esc_attr( $value ); ?>"><img src="<?php echo esc_attr( $link ); ?>" alt="<?php echo esc_attr( $value ); ?>" width="40"></li>
			<?php
		endif;
	endforeach;
	?>
</ul>