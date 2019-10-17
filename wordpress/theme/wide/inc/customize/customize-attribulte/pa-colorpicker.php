<?php
/**
 * @package     Nano Core
 * @version     0.1
 * @author      NanoAgency
 * @link        http://www.nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

?>
<ul class="wide-custom-simple colorpicker clearfix">
	<?php
	$get_terms_args = array( 'hide_empty' => '1' );
	$terms = get_terms( $taxonomy, $get_terms_args );

	foreach ( $terms as $term ){
		$color =get_woocommerce_term_meta($term->term_id,"{$term->taxonomy}_wide_value");
		$heading_css = "background-color:".$color;
		$background_css    = 'style='.  $heading_css .'';

	} ?>
</ul>
