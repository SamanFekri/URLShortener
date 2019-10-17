<?php
 /* *
  * widgets support
  **/
  class wide_support extends WP_Widget{

      /*function construct*/
      public function __construct() {
          parent::__construct(
            'support',__('+NA: Support','wide'),
             array('description'=>__('Display Support info', 'wide'))
          );
      }
      /**
       * font-end widgets
      */
      public function widget($args, $instance) {
          extract($args);
          echo ent2ncr($args['before_widget']);
      ?>
          <div class="support clearfix">
              <div class="icon-support ">
                    <?php if($instance['icon']): ?>
                        <i class="fa <?php echo esc_attr($instance['icon']);?>"></i>
                    <?php endif; ?>
              </div>
              <div class="support-description">
                    <?php if($instance['text-support']){ ?>
                          <h3 class="text-support"><?php  echo esc_html($instance['text-support']);  ?></h3>
                    <?php } ?>
                    <?php if($instance['description']): ?>
                          <h5 class="description"><?php echo esc_attr($instance['description']); ?></h5>
                    <?php endif; ?>
              </div>

          </div>
      <?php
          echo ent2ncr($args['after_widget']);
      }

      /**
       * Back-end widgets form
      */
      public function form($instance){
          $instance =   wp_parse_args($instance,array(
              'icon'                => 'fa-phone',
              'text-support'        => '<b>support:</b> (+84) 123456789',
              'description'         =>'Monday to Friday: 10:00am - 05:00pm ',
          ));
          ?>
          <p>
              <label for=<?php echo esc_attr($this->get_field_id('icon')); ?>><?php esc_html_e('Icon:','wide') ; ?></label>
              <input type="text" id="<?php echo esc_attr($this->get_field_id('icon')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('icon')); ?>" value="<?php echo esc_attr($instance['icon']); ?>" />
              <p><?php esc_html_e('Select icon from','wide'); ?><a href="<?php echo esc_url( 'http://fortawesome.github.io/Font-Awesome/icons' ); ?>"> Font Awesome</a><p>
          </p>
          <p>
              <label for="<?php echo esc_attr($this->get_field_id('text-support')); ?>"><?php esc_html_e( 'Text support:', 'wide' ); ?></label>
              <textarea id="<?php echo esc_attr($this->get_field_id( 'text-support')); ?>" name="<?php echo esc_attr($this->get_field_name( 'text-support')); ?>" style="width:95%;" rows="3"><?php echo esc_attr($instance['text-support']); ?></textarea>
          </p>

          <!-- description -->
          <p>
              <label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php esc_html_e('Description:', 'wide'); ?></label>
              <textarea id="<?php echo esc_attr($this->get_field_id( 'description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>" style="width:95%;" rows="6"><?php echo esc_attr($instance['description']); ?></textarea>
          </p>
          
      <?php
      }

      /**
      * function update widget
      */
      public function update( $new_instance, $old_instance ) {
          $instance = $old_instance;
          $instance['icon'] = $new_instance['icon'];
          $instance['text-support']    =   $new_instance['text-support'];
          $instance['description']    =   $new_instance['description'];
          return $instance;
      }
  }
  function wide_support(){
      register_widget('wide_support');
  }
  add_action('widgets_init','wide_support');
?>