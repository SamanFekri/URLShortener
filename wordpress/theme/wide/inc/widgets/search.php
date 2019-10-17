<?php
/**
 * Plugin Name: About Widget
 */

add_action( 'widgets_init', 'wide_search_widget' );

function wide_search_widget() {
    register_widget( 'wide_Widget_Search' );
}

class wide_Widget_Search extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => ' widget_search', 'description' => esc_html__( "A search form for your site.",'wide') );
        parent::__construct( 'search', esc_attr__( '+NA: Search', 'wide' ), $widget_ops );
    }

    public function widget( $args, $instance ) {

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo ent2ncr($args['before_widget']);
        if($title) {
            echo ent2ncr($args['before_title']) . esc_html($title) . ent2ncr($args['after_title']);
        }

        // Use current theme search form if it exists
            get_search_form();

        echo ent2ncr($args['after_widget']);
    }


    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = $instance['title'];
        ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','wide'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

}

?>