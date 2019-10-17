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
<ul class="wide-custom-simple image clearfix" data-attribute="<?php echo esc_attr( $attribute['name'] ); ?>">
	<?php 
	
	foreach ( $values as $value ) :

		// Get custom data
		$term = get_term_by( 'slug', $value, $attribute['name'] );

		if ( $term ) :
			$link = get_woocommerce_term_meta( $term->term_id, "{$attribute['name']}_wide_value" );
			?>
			<li class="image" data-value="<?php echo esc_attr( $value ); ?>"><img src="<?php echo esc_attr( $link ); ?>" alt="<?php echo esc_attr( $attribute['name'] ); ?>" width="30"></li>
			<?php
		endif;
	endforeach;
	?>
</ul>