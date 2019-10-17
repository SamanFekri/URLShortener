<?php
/* *
 * widgets contact info
 **/
class wide_about extends WP_Widget{
	public $socials = array(
		'ion-social-facebook' => array(
			'title' => 'facebook',
			'name' => 'facebook_username',
			'link' => '*',
			'icon'=>'fa-facebook',
		),
		'ion-social-googleplus' => array(
			'title' => 'googleplus',
			'name' => 'googleplus_username',
			'link' => '*',
			'icon'=>'fa-google-plus',
		),
		'ion-social-twitter' => array(
			'title' => 'twitter',
			'name' => 'twitter_username',
			'link' => '*',
			'icon'=>'fa-twitter',
		),
		'ion-social-instagram' => array(
			'title' => 'instagram',
			'name' => 'instagram_username',
			'link' => '*',
			'icon'=>'fa-instagram',
		),
		'ion-social-pinterest' => array(
			'title' => 'pinterest',
			'name' => 'pinterest_username',
			'link' => '*',
			'icon'=>'fa-pinterest',
		),
		'ion-social-skype' => array(
			'title' => 'skype',
			'name' => 'skype_username',
			'link' => '*',
			'icon'=>'fa-skype',
		),
		'ion-social-vimeo' => array(
			'title' => 'vimeo',
			'name' => 'vimeo_username',
			'link' => '*',
			'icon'=>'fa-vimeo-square',
		),
		'ion-social-youtube' => array(
			'title' => 'youtube',
			'name' => 'youtube_username',
			'link' => '*',
			'icon'=>'fa-youtube',
		),
		'ion-social-dribbble' => array(
			'title' => 'dribbble',
			'name' => 'dribbble_username',
			'link' => '*',
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
			'link' => '*',
			'icon'=>'fa-rss',
		)
	);
	/*function construct*/
	public function __construct() {
		/* Widget control settings. */
		$control_ops = array('width' => 250, 'height' => 350, 'id_base' => 'about');
		$widget_ops = array('classname' => 'about', 'description' => esc_html__('Easy add About.', 'wide'));

		/* Create the widget. */
		parent::__construct('about', esc_html__('+NA: About', 'wide'), $widget_ops, $control_ops);
	}
	/**
	 * font-end widgets
	 */
	public function widget($args, $instance) {
		extract($args);
		$image = $instance['image'];
		$title = apply_filters('widget_title', $instance['title']);

		echo ent2ncr($args['before_widget']);

		if($title) {
			echo ent2ncr($args['before_title']) . esc_html($title) . ent2ncr($args['after_title']);
		}

		?>
		<?php if($image): ?>
			<img class="about-image" src="<?php echo esc_url($image)?>" alt="img" />
		<?php endif; ?>
		<?php if($instance['description']): ?>
			<div class="about-description">
				<span><?php echo esc_attr($instance['description']); ?></span>
			</div>
		<?php endif; ?>

		<div class="wide-social-icon clearfix">
			<?php
			foreach ($this->socials as $key => $social) {
				if (!empty($instance[$social['name']])) {
					echo '<a href="' . str_replace('*', esc_attr($instance[$social['name']]), $social['link']) . '" target="_blank" title="' . esc_attr($key) . '" class="' . esc_attr($key) . '"><i class="fa ' . esc_attr( $social['icon']) . '"></i></a>';
				}
			}?>
		</div>
		<?php
		echo ent2ncr($args['after_widget']);
	}

	/**
	 * Back-end widgets form
	 */
	public function form($instance){
		$instance =   wp_parse_args($instance,array(
			'title'       =>  'About',
			'image'       => '',
			'description' =>'',
		));
		?>
		<p>
			<label for=<?php echo esc_attr($this->get_field_id('title')); ?>><?php echo esc_html_e('Title:','wide') ; ?></label>
			<input type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p id="<?php echo esc_attr($this->get_field_id('image').'-wrapp'); ?>">
			<label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php esc_html_e('Image:', 'wide'); ?></label>
			<img id="<?php echo esc_attr($this->get_field_id('image').'-img'); ?>" src="<?php echo esc_url($instance['image'])?>" class="custom_media_image <?php echo($instance['image']==''?  esc_attr('hidden'):''); ?>"/>
			<input type="text" class="widefat custom_media_url hidden" name="<?php echo esc_attr($this->get_field_name('image')); ?>" id="<?php echo esc_attr($this->get_field_id('image')); ?>" value="<?php echo esc_attr($instance['image']); ?>" />
			<br>
			<input type="button" class="button button-primary custom_media_button" id="<?php echo esc_attr($this->get_field_id('image').'-button'); ?>" value="Select Image" />
		</p>
		<!-- description -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php echo esc_html_e('About me text::', 'wide'); ?></label>
			<textarea id="<?php echo esc_attr($this->get_field_id( 'description')); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>" style="width:95%;" rows="6"><?php echo esc_attr($instance['description']); ?></textarea>
		</p>
		<?php
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
		?>
		<?php
	}

	/**
	 * function update widget
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = $new_instance;
		$instance['title'] = $new_instance['title'];
		$instance['image'] = $new_instance['image'];
		$instance['description']    =   $new_instance['description'];
		return $instance;
	}
}
function wide_about(){
	register_widget('wide_about');
}
add_action('widgets_init','wide_about');
?>