<?php
/**
 * NA Core Plugin
 * @package     NA Core
 * @version     0.1
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */

if (!class_exists('NARecentPosts')) {
    class NARecentPosts extends WP_Widget
    {
        public function __construct()
        {
            $widget_ops = array('classname' => 'widget-recent-posts', 'description' => esc_html__('Show recent posts.', 'wide'));

            $control_ops = array('id_base' => 'recent_posts-widget');

            parent::__construct('recent_posts-widget', esc_html__('+NA: Recent Posts', 'wide'), $widget_ops, $control_ops);
        }

        public function widget($args, $instance)
        {
            extract($args);
            $title = apply_filters('widget_title', $instance['title']);
            $number = $instance['number'];
            $items = $instance['items'];
            $view = $instance['view'];
            $cat = $instance['cat'];
            $show_image = $instance['show_image'];

            if ($items == 0)
                $items = 3;

            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $number
            );

            if ($cat)
                $args['cat'] = $cat;

            $posts = new WP_Query($args);

            if ($posts->have_posts()) :

                echo ent2ncr($args['before_widget']);

                if($title) {
                    echo ent2ncr($args['before_title']) . esc_html($title) . ent2ncr($args['after_title']);
                }

                ?>
                <div class="row">
                    <div<?php if ($number > $items) : ?> class="post-carousel owl-carousel" data-cols-lg="1" data-cols-md="3" data-cols-sm="2" data-single="<?php echo esc_attr($view == 'small' ? '1' : '0'); ?>"<?php endif; ?>>
                        <?php
                        $count = 0;
                        while ($posts->have_posts()) {
                            $posts->the_post();
                            global $previousday;
                            unset($previousday);

                            if ($count % $items == 0) echo '<div class="post-slide">';

                            if ($show_image) {
                                get_template_part('content', 'post-item' . ($view == 'small' ? '-small' : ''));
                            } else {
                                get_template_part('content', 'post-item-no-image' . ($view == 'small' ? '-small' : ''));
                            }

                            if ($count % $items == $items - 1) echo '</div>';

                            $count++;
                        }
                        ?>
                    </div>
                </div>
                <?php

                echo ent2ncr($args['after_widget']);

            endif;
            wp_reset_postdata();
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['title'] = strip_tags($new_instance['title']);
            $instance['number'] = $new_instance['number'];
            $instance['items'] = $new_instance['items'];
            $instance['view'] = $new_instance['view'];
            $instance['cat'] = $new_instance['cat'];
            $instance['show_image'] = $new_instance['show_image'];

            return $instance;
        }

        public function form($instance)
        {
            $defaults = array('title' => esc_html__('Recent Posts', 'wide'), 'number' => 6, 'items' => 3, 'view' => 'small', 'cat' => '', 'show_image' => 'on');
            $instance = wp_parse_args((array)$instance, $defaults); ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <strong><?php esc_html_e('Title', 'wide') ?>:</strong>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                           value="<?php if (isset($instance['title'])) echo esc_attr($instance['title']); ?>"/>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('number')); ?>">
                    <strong><?php esc_html_e('Number of posts to show', 'wide') ?>:</strong>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('number')); ?>"
                           value="<?php if (isset($instance['number'])) echo esc_attr($instance['number']); ?>"/>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('view')); ?>">
                    <strong><?php esc_html_e('View Type', 'wide') ?>:</strong>
                    <select class="widefat" id="<?php echo esc_attr($this->get_field_id('type')); ?>"
                            name="<?php echo esc_attr($this->get_field_name('view')); ?>">
                        <option
                            value="small"<?php echo (isset($instance['view']) && $instance['view'] == 'small') ? ' selected="selected"' : '' ?>><?php esc_html_e('Small', 'wide') ?></option>
                        <option
                            value="large"<?php echo (isset($instance['view']) && $instance['view'] == 'large') ? ' selected="selected"' : '' ?>><?php esc_html_e('Large', 'wide') ?></option>
                    </select>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('items')); ?>">
                    <strong><?php esc_html_e('Number of items per slide', 'wide') ?>:</strong>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('items')); ?>"
                           value="<?php if (isset($instance['items'])) echo esc_attr($instance['items']); ?>"/>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('cat')); ?>">
                    <strong><?php esc_html_e('Category IDs', 'wide') ?>:</strong>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('cat')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('cat')); ?>"
                           value="<?php if (isset($instance['cat'])) echo esc_attr($instance['cat']); ?>"/>
                </label>
            </p>
            <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['show_image'], 'on'); ?>
                       id="<?php echo esc_attr($this->get_field_id('show_image')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('show_image')); ?>"/>
                <label
                    for="<?php echo esc_attr($this->get_field_id('show_image')); ?>"><?php echo esc_html__('Show Post Image', 'wide') ?></label>
            </p>
            <div class="wrap_banner">
                <div class="banner_title">Footer banner 3</div>
                <div class="banner_content">
                    <img src="">
                    <input type="button" value="edit-banner" class="edit_banner">

                </div>
            </div>
        <?php
        }
    }
}
add_action('widgets_init', 'wide_recent_posts_load_widgets');

function wide_recent_posts_load_widgets()
{
    register_widget('NARecentPosts');
}