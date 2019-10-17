<?php
 /* *
  * widgets service
  **/
  class wide_service extends WP_Widget{

      /*function construct*/
      public function __construct() {
          parent::__construct(
            'service',__('+NA: Services','wide'),
             array('description'=>__('Display Services info', 'wide'))
          );
      }
      /**
       * font-end widgets
      */
      public function widget($args, $instance) {
          extract($args);
          echo ent2ncr($args['before_widget']);
      ?>

      <div class="service">
          <div class="icon-service ">
              <?php if($instance['icon']): ?>
                  <i class="fa <?php echo esc_attr($instance['icon']);?>"></i>
              <?php endif; ?>
          </div>
          <div class="service-description">
              <?php if($instance['title-service']){ ?>
                  <a href="<?php echo esc_url($instance['link']);?>"><span class="title-service"><?php  echo esc_attr($instance['title-service']);  ?></span></a>
              <?php } ?>
              <?php if($instance['description']): ?>
                  <p class="description"><?php echo esc_attr($instance['description']); ?></p>
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
              'icon'                => 'fa-truck',
              'title-service'       => 'Free shipping',
              'link'                => '#',
              'description'         => 'Free Shipping Worldwide',
          ));
          ?>
          <p>
              <label for=<?php echo esc_attr($this->get_field_id('icon')); ?>><?php esc_html_e('Icon service:','wide') ; ?></label>
              <input type="text" id="<?php echo esc_attr($this->get_field_id('icon')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('icon')); ?>" value="<?php echo esc_attr($instance['icon']); ?>" />
              <p><?php esc_html_e('Select icon from','wide'); ?><a href="<?php echo esc_url( 'http://fortawesome.github.io/Font-Awesome/icons' ); ?>"> Font Awesome</a><p>
          </p>
          <p>
              <label for=<?php echo esc_attr($this->get_field_id('link')); ?>><?php esc_html_e('link service:','wide') ; ?></label>
              <input type="text" id="<?php echo esc_attr($this->get_field_id('link')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('link')); ?>" value="<?php echo esc_attr($instance['link']); ?>" />
          </p>
          <p>
              <label for="<?php echo esc_attr($this->get_field_id('title-service')); ?>"><?php esc_html_e( 'Title service:', 'wide' ); ?></label>
              <textarea id="<?php echo esc_attr($this->get_field_id( 'title-service' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title-service')); ?>" style="width:95%;" rows="3"><?php echo esc_attr($instance['title-service']); ?></textarea>
          </p>

          <!-- description -->
          <p>
              <label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php esc_html_e('Description service:', 'wide'); ?></label>
              <textarea id="<?php echo esc_attr($this->get_field_id( 'description')); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>" style="width:95%;" rows="6"><?php echo esc_attr($instance['description']); ?></textarea>
          </p>

      <?php
      }

      /**
      * function update widget
      */
      public function update( $new_instance, $old_instance ) {
          $instance = $old_instance;
          $instance['icon'] = $new_instance['icon'];
          $instance['link'] = $new_instance['link'];
          $instance['title-service']    =   $new_instance['title-service'];
          $instance['description']    =   $new_instance['description'];
          return $instance;
      }
  }
  function wide_service(){
      register_widget('wide_service');
  }
  add_action('widgets_init','wide_service');
?>