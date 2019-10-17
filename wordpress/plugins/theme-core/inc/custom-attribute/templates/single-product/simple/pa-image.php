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
<ul class="nano-custom-simple image clearfix" data-attribute="<?php echo esc_attr( $attribute['name'] ); ?>">
	<?php 
	
	foreach ( $values as $value ) :

		// Get custom data
		$term = get_term_by( 'slug', $value, $attribute['name'] );

		if ( $term ) :
			$link = get_woocommerce_term_meta( $term->term_id, "{$attribute['name']}_nano_value" );
			?>
			<li class="image att_img" data-value="<?php echo esc_attr( $value ); ?>"><img src="<?php echo esc_attr( $link ); ?>" alt="<?php echo esc_attr( $attribute['name'] ); ?>" width="40"></li>
			<?php
		endif;
	endforeach;
	?>
</ul>