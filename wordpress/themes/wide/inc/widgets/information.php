<?php
/**
 * Plugin Name: Image hover sidebar
 */

add_action('widgets_init', 'wide_information');

function wide_information()
{
    register_widget('information_widget');
}

class information_widget extends WP_Widget
{

    /**
     * Widget setup.
     */
    public function __construct()
    {
        /* Widget settings. */
        $widget_ops = array('classname' => 'information_widget', 'description' => __('Easy add image for sidebar.', 'wide'));

        /* Widget control settings. */
        $control_ops = array('width' => 250, 'height' => 350, 'id_base' => 'information_widget');

        /* Create the widget. */
        parent::__construct('information_widget', __('+NA: Image', 'wide'), $widget_ops, $control_ops);
    }

    /**
     * How to display the widget on the screen.
     */
    function widget($args, $instance)
    {
        extract($args);

        /* Our variables from the widget settings. */
        $link = $image='';
        $image = $instance['image'];
        $link = $instance['link'];
        echo ent2ncr($args['before_widget']);
        ?>
        <div class="wide-image-content">
            <?php if ($image) {
                ?>
                <a class="clearfix" href="<?php echo esc_url($link); ?>">
                    <img class="wide-image" src="<?php echo esc_url($image)?>" alt="img" />
                </a>
            <?php } ?>
        </div>
        <?php

        /* After widget (defined by themes). */
        echo ent2ncr($args['after_widget']);
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['image'] = $new_instance['image'];
        $instance['link'] = $new_instance['link'];
        return $instance;
    }

    function form($instance)
    {
        $instance =   wp_parse_args($instance,array(
            'image'         => '',
            'link'          => '#',
        ));

        ?>


        <p id="<?php echo esc_attr($this->get_field_id('image').'-wrapp'); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php esc_html_e('Image:', 'wide'); ?></label>
            <img id="<?php echo esc_attr($this->get_field_id('image').'-img'); ?>" src="<?php echo esc_url($instance['image'])?>" class="custom_media_image <?php echo($instance['image']==''?  esc_attr('hidden'):''); ?>"/>
            <input type="text" class="widefat custom_media_url hidden" name="<?php echo esc_attr($this->get_field_name('image')); ?>" id="<?php echo esc_attr($this->get_field_id('image')); ?>" value="<?php echo esc_attr($instance['image']); ?>" />
            <br>
            <input type="button" class="button button-primary custom_media_button" id="<?php echo esc_attr($this->get_field_id('image').'-button'); ?>" value="Select Image" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('link')); ?>"><?php echo esc_html_e('Url:', 'wide'); ?></label>
            <input type="text" id="<?php echo esc_attr($this->get_field_id('link')); ?>" name="<?php echo esc_attr($this->get_field_name('link')); ?>" class="widefat" value="<?php echo esc_attr($instance['link']); ?>" />
        </p>

    <?php
    }
}

?>