<?php
if (!class_exists('wide_social')) {
    class wide_social extends WP_Widget
    {
        public $socials = array(
            'ion-social-facebook' => array(
                'title' => 'facebook',
                'name' => 'facebook_username',
                'link' => 'http://www.facebook.com/*',
                'icon'=>'fa-facebook',
            ),
            'ion-social-googleplus' => array(
                'title' => 'googleplus',
                'name' => 'googleplus_username',
                'link' => 'https://plus.google.com/u/0/*',
                'icon'=>'fa-google-plus',
            ),
            'ion-social-twitter' => array(
                'title' => 'twitter',
                'name' => 'twitter_username',
                'link' => 'http://twitter.com/*',
                'icon'=>'fa-twitter',
            ),
            'ion-social-instagram' => array(
                'title' => 'instagram',
                'name' => 'instagram_username',
                'link' => 'http://instagram.com/*',
                'icon'=>'fa-instagram',
            ),
            'ion-social-pinterest' => array(
                'title' => 'pinterest',
                'name' => 'pinterest_username',
                'link' => 'http://pinterest.com/*',
                'icon'=>'fa-pinterest',
            ),
            'ion-social-skype' => array(
                'title' => 'skype',
                'name' => 'skype_username',
                'link' => 'skype:*',
                'icon'=>'fa-skype',
            ),
            'ion-social-vimeo' => array(
                'title' => 'vimeo',
                'name' => 'vimeo_username',
                'link' => 'http://vimeo.com/*',
                'icon'=>'fa-vimeo-square',
            ),
            'ion-social-youtube' => array(
                'title' => 'youtube',
                'name' => 'youtube_username',
                'link' => 'http://www.youtube.com/user/*',
                'icon'=>'fa-youtube',
            ),
            'ion-social-dribbble' => array(
                'title' => 'dribbble',
                'name' => 'dribbble_username',
                'link' => 'http://dribbble.com/*',
                'icon'=>'fa-dribbble',
            ),
            'ion-social-linkedin' => array(
                'title' => 'linkedin',
                'name' => 'linkedin_username',
                'link' => '*',
                'icon'=>'fa-linkedin',
            ),
            'ion-social-rss' => array(
                'title' => 'rss',
                'name' => 'rss_username',
                'link' => 'http://*/feed',
                'icon'=>'fa-rss',
            )
        );

        function wide_social()
        {
            $widget_ops = array('classname' => 'NA_social', 'description' => esc_html__('Displays your social profile.', 'wide'));

            parent::__construct(false, esc_html__('+NA: Social', 'wide'), $widget_ops);
        }

        function widget($args, $instance)
        {
            extract($args);
            $title = apply_filters('widget_title', $instance['title']);
            echo htmlspecialchars_decode(esc_html($before_widget));
            if ($title) {
                echo htmlspecialchars_decode(esc_html($before_title . $title . $after_title));
            }
            echo '<div class="wide-social-icon clearfix">';
            foreach ($this->socials as $key => $social) {
                if (!empty($instance[$social['name']])) {
                    echo '<a href="' . str_replace('*', esc_attr($instance[$social['name']]), $social['link']) . '" target="_blank" title="' . esc_attr($key) . '" class="' . esc_attr($key) . '"><i class="fa ' . esc_attr( $social['icon']) . '"></i></a>';
                }
            }
            echo '</div>';
            echo htmlspecialchars_decode(esc_html($after_widget));
        }

        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance = $new_instance;
            /* Strip tags (if needed) and update the widget settings. */
            $instance['title'] = strip_tags($new_instance['title']);
            return $instance;
        }

        function form($instance)
        {
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" type="text"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                       value="<?php echo isset($instance['title']) ? esc_attr($instance['title']) : ''; ?>"/>
            </p> <?php
            foreach ($this->socials as $key => $social) {
                ?>
                <p>
                <label for="<?php echo esc_attr($this->get_field_id($social['name'])); ?>"><?php echo esc_html($key); ?>
                    :</label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id($social['name'])); ?>" type="text"
                       name="<?php echo esc_attr($this->get_field_name($social['name'])); ?>"
                       value="<?php echo isset($instance[$social['name']]) ? esc_attr($instance[$social['name']]) : ''; ?>"/>
                </p><?php
            }
        }
    }
}

add_action('widgets_init', 'wide_social_widgets');

function wide_social_widgets()
{
    register_widget('wide_social');
}
