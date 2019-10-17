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

/**
* Define main class
*/
if ( !class_exists( 'NANO_Custom_Atrributes' ) ) {
	/**
     * Admin class.
     * The class manage all the admin behaviors.
     *
     * @since 1.0.0
     */
	class NANO_Custom_Atrributes {
		/**
		* Variable to hold class prefix supported for autoloading.
		*
		* @var string
		*/
		protected static $prefix = 'NANO_Custom_Atrributes_';

		/**
		* Variable to hold supported custom attribute types.
		*
		* @var array
		*/
		protected static $types;

		/**
		* Initialize
		*
		* @return void
		*/
		public static function initialize() {
			// Define support custom attribute types
			self::$types = array(
				'colorpicker' => esc_html__( 'Color Picker', 'nano' ),
				'image'       => esc_html__( 'Image', 'nano' ),
				'label'       => esc_html__( 'Label', 'nano' ),
				);

			add_filter( 'product_attributes_type_selector', array( __CLASS__, 'register' ) );
			add_action( 'woocommerce_product_option_terms', array( __CLASS__, 'print_values' ), 10, 2 );
			add_action( 'woocommerce_attribute', array( __CLASS__, 'generate_variation_option' ), 10, 3 );
			add_action( 'woocommerce_before_variations_form',    array( __CLASS__, 'start_capture' ) );
			add_action( 'woocommerce_before_add_to_cart_button', array( __CLASS__, 'stop_capture'  ) );
			self::add_hook();
		}

		/**
		* Method to register action to print form fields for all product attributes ussing custom types.
		*
		* @return array
		*/
		public static function register( $types ) {
			return array_merge( $types, self::$types );
		}

		public static function add_hook() {
			// Check if is screen add/edit attribute values is requested.
			global $pagenow;

			if ( 'edit-tags.php' == $pagenow || 'term.php' == $pagenow || ( 'admin-ajax.php' == $pagenow && 'add-tag' == $_REQUEST['action'] ) ) {
				$taxonomy = isset( $_REQUEST['taxonomy'] ) ? sanitize_text_field( $_REQUEST['taxonomy' ] ) : null;
				if ( $taxonomy && 'pa_' == substr( $taxonomy, 0, 3 ) ) {
					// Get custom attribute type.
					global $wpdb;

					$attribute = current(
						$wpdb->get_results(
							"SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
							"WHERE attribute_name = '" . esc_sql( substr( $taxonomy, 3 ) ) . "' LIMIT 0, 1;"
							)
						);

					if ( array_key_exists( $attribute->attribute_type, self::$types ) ) {
						// Add actions to print custom fields for add/edit attribute value form.
						add_action( "{$taxonomy}_add_form_fields", array( __CLASS__, 'add_atrribute_field' ), 10 );
						add_action( "{$taxonomy}_edit_form_fields", array( __CLASS__, 'edit_atrribute_field' ), 10, 3 );

						// Addd action to atrribute_save custom data for attribute value ofr custom types
						add_action( 'created_term', array( __CLASS__, 'atrribute_save' ), 10, 3 );
						add_action( 'edit_term' , array( __CLASS__, 'atrribute_save' ), 10, 3 );
					}
				}
			}
		}

		/**
		* Method to print form fields for adding attribute value for custom attribute types.
		*
		* @param string $taxonomy Current taxonomy slug.
		*
		* @return void
		*/
		public static function add_atrribute_field( $taxonomy ) {
			// Get custom attribute type
			global $wpdb;

			$attribute = current(
				$wpdb->get_results(
					"SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
					"WHERE attribute_name = '" . substr( $taxonomy, 3 ) . "' LIMIT 0, 1;"
					)
				);

			if ( $attribute &&  array_key_exists( $attribute->attribute_type , self::$types ) ) {
				// Load template to print form fields for the custom attribute type.
				include_once NANO_PLUGIN_PATH. '/inc/custom-attribute/templates/admin/add/pa-' . $attribute->attribute_type . '.php';
			}
		}

		/**
		 * Method to print form fields for editing attribute value for custom attribute types.
		 *
		 * @param object $term      Current taxonomy term object.
		 * @param string $taxonomy Current taxonomy slug.
		 *
		 * @return  void
		 */
		public static function edit_atrribute_field( $term, $taxonomy ) {
			// Get custom attribute type.
			global $wpdb;

			$attribute = current(
				$wpdb->get_results(
					"SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
					"WHERE attribute_name = '" . substr( $taxonomy, 3 ) . "' LIMIT 0, 1;"
				)
			);

			if ( $attribute && array_key_exists( $attribute->attribute_type, self::$types ) ) {
				// Load template to print form fields for the custom attribute type.
				include_once NANO_PLUGIN_PATH. '/inc/custom-attribute/templates/admin/edit/pa-' . $attribute->attribute_type . '.php';
			}
		}

		/**
		* Method to atrribute_save custom data for attribute value for custom types.
		*
		* @param string int $term_id  Term ID.
		* @param string int $tt_id    Term taxonomy ID.
		* @param string int $taxonomy Taxonomy slug
		*
		* @return void
		*/
		public static function atrribute_save( $term_id, $tt_id, $taxonomy ) {

			// Get custom attribute type.
			global $wpdb;

			$attribute = current(
				$wpdb->get_results(
					"SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
					"WHERE attribute_name = '" . substr( $taxonomy, 3 ) . "' LIMIT 0, 1;"
				)
			);
			
			// Save custom data
			if ( isset( $_POST["nano_{$attribute->attribute_type}"] ) ) {
				update_woocommerce_term_meta( $term_id, "{$taxonomy}_nano_value", sanitize_text_field( $_POST["nano_{$attribute->attribute_type}"] ) );
			}
		}

		/**
		* Method to print values for custom attribute types in add/edit product screen.
		*
		* @param   object  $attribute  Attribute data.
	 	* @param   int     $i          Current attribute index.
		*
		* @return void
		*/
		public static function print_values( $attribute, $i ) {
			// Verify attribute type.
			if ( array_key_exists( $attribute->attribute_type, self::$types ) ) {

				if ( isset( $_POST['taxonomy'] ) ) {
					$taxonomy = sanitize_text_field( $_POST['taxonomy'] );
				} else {
					$taxonomy = wc_attribute_taxonomy_name( $attribute->attribute_name );
				}
				?>
				<select name="attribute_values[<?php echo esc_attr( $i ); ?>][]" multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'nano' ); ?>" class="multiselect attribute_values wc-enhanced-select">

					<?php
					$all_terms = get_terms( $taxonomy, 'orderby=name&hide_empty=0' );

					if ( $all_terms ) :
						foreach ( $all_terms as $term ) : ?>
						<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( has_term( absint( $term->term_id ), $taxonomy, 0 ), true ); ?>>
							<?php echo esc_html( $term->name ); ?>
						</option>
						<?php
						endforeach;
					endif;
					?>

				</select>
				<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'nano' ); ?></button>
				<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'nano' ); ?></button>
				<button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'nano' ); ?></button>
				<?php
			}
		}

		/**
		* Method to generate HTML code for product options of custom types in product detail page.
		*
		* @param   string  $html       Current HTML.
		* @param   array   $attribute  Attribute data.
		* @param   array   $values     Attribute values.
		*
		* @return void
		*/
		public static function generate_variation_option( $html, $attribute, $values ) {
			// Get custom attribute type.
			global $wpdb;

			$attr = current(
				$wpdb->get_results(
					"SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
					"WHERE attribute_name = '" . substr( $attribute['name'], 3 ) . "' LIMIT 0, 1;"
				)
			);

			if ( $attr && array_key_exists( $attr->attribute_type , self::$types ) ) {
				// start buffering to capture output.
				ob_start();
				// Load template to print  product options for custom attribute types.
				include NANO_PLUGIN_PATH . '/inc/custom-attribute/templates/single-product/simple/pa-' . $attr->attribute_type . '.php';
				// Get output HTML.
				$html = ob_get_contents();

				// Stop output buffering.
				ob_end_clean();
			}

			return $html;
		}

		/**
		* Method to generate HTML code for product options of custom types in product detail page.
		*
		* @return void
		*/
		public static function start_capture() {
			// Start output buffering.
			ob_start();
		}

		/**
		* Method to stop capture variation form output
		*
		* @return void
		*/
		public static function stop_capture() {
			// Get variations form.
			$html = ob_get_contents();

			// Stop output buffering.
			if ( ob_get_level() ) {
				ob_end_clean();
			}

			// Get available variations.
			global $product;

			if ( 'variable' == $product->product_type ) {
				// Prepare variation attributes.
				$attributes          = $product->get_variation_attributes();
				$selected_attributes = $product-> get_variation_default_attributes();
				$attribute_keys      = array_keys( $attributes );

				// Alter variations form to support custom attribute types.
				foreach ( $attributes as $attribute_name => $options ) {
					// Get custom attribute type.
					global $wpdb;

					$attr = current(
						$wpdb->get_results(
							"SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
							"WHERE attribute_name = '" . substr( $attribute_name, 3 ) . "' LIMIT 0, 1;"
						)
					);

					if ( $attr && array_key_exists( $attr->attribute_type, self::$types ) ) {
						// Load template to print variation options for custom attribute types.
						ob_start();

						include NANO_PLUGIN_PATH. '/inc/custom-attribute/templates/single-product/variable/pa-' . $attr->attribute_type . '.php';

						$tmp = ob_get_contents();

						ob_end_clean();

						// Update variations form.
						$html = preg_replace(
							'/<select id="(' . $attribute_name . ')" class="([^"]*)" name="([^"]+)" data-attribute_name="([^"]+)">/',
							$tmp . '<select id="\\1" class="\\2" name="\\3" data-attribute_name="\\4" style="display: none;">',
							$html
						);
					}
				}
			}
			echo $html;
		}
	}
}
