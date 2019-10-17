<?php
/**
 * Framework  Nano
 * @package     Nano
 * @version     1.0
 * @author      Nanoagency
 * @link        http://www.nanoagency.co
 * @copyright   Copyright (c) 2016 Nanoagency
 * @license     GPL v2
 */


if (!function_exists('na_get_part')) {
    function na_get_part($slug = null, $name = null, array $params = array())
    {
        global $wp_query;
        $slug = 'woocommerce/'.$slug;
        do_action("get_template_part_{$slug}", $slug, $name);

        $templates = array();
        if (isset($name))
            $templates[] = "{$slug}-{$name}.php";
        $templates[] = "{$slug}.php";

        $_template_file = locate_template($templates, false, false);


        if (is_array($wp_query->query_vars)) {
            extract($wp_query->query_vars, EXTR_SKIP);
        }
        extract($params, EXTR_SKIP);


        if (file_exists($_template_file)) {
            require($_template_file);
        }
    }
}
if (!function_exists('na_part_templates')) {
    function na_part_templates($slug = null, $name = null, array $params = array())
    {
        global $wp_query;
        $slug = 'templates/'.$slug;
        do_action("get_template_part_{$slug}", $slug, $name);

        $templates = array();
        if (isset($name))
            $templates[] = "{$slug}-{$name}.php";
        $templates[] = "{$slug}.php";

        $_template_file = locate_template($templates, false, false);


        if (is_array($wp_query->query_vars)) {
            extract($wp_query->query_vars, EXTR_SKIP);
        }
        extract($params, EXTR_SKIP);


        if (file_exists($_template_file)) {
            require($_template_file);
        }
    }
}
if (!function_exists('nano_template_part')) {
    function nano_template_part($slug = null, $name = null, array $params = array())
    {
        global $wp_query;
        $template_slug = NANO_DIRECTORY_NAME . '/' . $slug;
        do_action("get_template_part_{$template_slug}", $template_slug, $name);

        $templates = array();
        $pluginTemplates = array();
        if (isset($name)){
            $templates[] = "{$template_slug}-{$name}.php";
            $pluginTemplates[] = "{$slug}-{$name}.php";
        }

        $templates[] = "{$template_slug}.php";
        $pluginTemplates[] = "{$slug}.php";

        $_template_file = locate_template($templates, false, false);

        if (is_array($wp_query->query_vars)) {
            extract($wp_query->query_vars, EXTR_SKIP);
        }
        extract($params, EXTR_SKIP);

        if (file_exists($_template_file)) {
            include($_template_file);
        } elseif((file_exists(NANO_PLUGIN_PATH . '/html/' . $pluginTemplates[0]))){
            include(NANO_PLUGIN_PATH . '/html/' . $pluginTemplates[0]);
        }
    }
}

function nano_multi_select_categories($settings, $value, $taxonomies = 'category'){
    $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
    $type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    $categories = get_terms( $taxonomies );

    $output = $selected = $ids = '';
    if ( $value !== '' ) {
        $ids = explode( ',', $value );
        $ids = array_map( 'trim', $ids );
    } else {
        $ids = array();
    }
    $output .= '<select class="nano-select-multi-category" multiple="multiple" style="min-width:200px;">';
    foreach($categories as $cat){
        if(in_array($cat->slug, $ids)){
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        $output .= '<option '.esc_attr($selected).' value="'. esc_attr($cat->slug) .'">'. esc_html__($cat->name,'na-nano') .'</option>';
    }
    $output .= '</select>';

    $output .= "<input type='hidden' name='". esc_attr($param_name) ."' value='".esc_attr( $value) ."' class='wpb_vc_param_value ". esc_attr($param_name) ." ".esc_attr($type) ." ". esc_attr($class) ."'>";
    $output .= '<script type="text/javascript">
							jQuery(".nano-select-multi-category").select({
								placeholder: "Select Categories",
								allowClear: true
							});
							jQuery(".nano-select-multi-category").on("change",function(){
								jQuery(this).next().val(jQuery(this).val());
							});
						</script>';
    return $output;

}

function vc_field_nano_multi_select($settings, $value){
    $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
    $type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    $options = isset($settings['value']) ? $settings['value'] : array();

    $output = $selected = $ids = '';

    if ( $value !== '' ) {
        $ids = explode( ',', $value );
        $ids = array_map( 'trim', $ids );
    } else {
        $ids = array();
    }

    $output .= '<select class="nano-select-multi" multiple="multiple" style="min-width:200px;">';
    foreach($options as $name => $val ){

        if(in_array($val, $ids)){
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        $output .= '<option '. esc_attr($selected) .' value="'.esc_attr($val).'">'. esc_html__($name, 'na-nano') .'</option>';
    }
    $output .= '</select>';

    $output .= "<input type='hidden' name='". esc_attr($param_name) ."' value='". esc_attr($value) ."' class='wpb_vc_param_value ". esc_attr($param_name)." ".esc_attr($type)." ".esc_attr($class)."'>";
    $output .= '<script type="text/javascript">
							jQuery(".nano-select-multi").select({
								placeholder: "Select Categories",
								allowClear: true
							});
							jQuery(".nano-select-multi").on("change",function(){
								jQuery(this).next().val(jQuery(this).val());
							});
						</script>';
    return $output;
}

function vc_field_post_categories($settings, $value) {
    return nano_multi_select_categories($settings, $value, 'category');
}

function vc_field_portfolio_categories($settings, $value) {
    return nano_multi_select_categories($settings, $value, 'portfolio_category');
}

function vc_field_testimonial_categories($settings, $value) {
    return nano_multi_select_categories($settings, $value, 'testimonial_category');
}

function vc_field_product_categories($settings, $value) {
    return nano_multi_select_categories($settings, $value, 'product_cat');
}

function vc_field_image_radio($settings, $value) {
    $type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    $output = '<input class="wpb_vc_param_value '. esc_attr($settings['param_name']).' '.esc_attr($type).' '.esc_attr($class).'"  type="hidden" name="'.esc_attr($settings['param_name']).'" value="'.esc_attr($value).'">';
    $width = isset($settings['width']) ? $settings['width'] : '120px';
    $height = isset($settings['height']) ? $settings['height'] : '80px';
    if(count($settings['value']) > 0 ){
        foreach($settings['value'] as $param => $param_val) {
            $border_color = 'white';
            if($param_val == $value){
                $border_color = 'green';
            }
            $output .= '<img class="nano-image-radio-'.esc_attr($settings['param_name']).'" src="'.esc_url($param).'" data-value="'.esc_attr($param_val).'" style="width:'.esc_attr($width).';height:'.esc_attr($height).';border-style: solid;border-width: 5px;border-color: '.esc_attr($border_color).';margin-left:0px;">';
        }
        $output .= '<script type="text/javascript">
							jQuery(".nano-image-radio-'.esc_js($settings['param_name']).'").click(function() {
							    jQuery("input[name=\''.esc_js($settings['param_name']).'\']").val(jQuery(this).data("value"));
							    jQuery(".nano-image-radio-'.esc_js($settings['param_name']).'").css("border-color", "white");
							    jQuery(this).css("border-color", "green");
							});
						</script>';
    }
    return $output;
}


if (function_exists('vc_add_shortcode_param')){
    vc_add_shortcode_param('nano_post_categories', 'vc_field_post_categories');
    vc_add_shortcode_param('nano_portfolio_categories', 'vc_field_portfolio_categories');
    vc_add_shortcode_param('nano_testimonial_categories', 'vc_field_testimonial_categories');
    vc_add_shortcode_param('nano_product_categories', 'vc_field_product_categories');
    vc_add_shortcode_param('nano_image_radio', 'vc_field_image_radio');
    vc_add_shortcode_param('nano_multi_select', 'vc_field_nano_multi_select');
}

// Author Link Social
function na_social_author( $contactmethods ) {
    $contactmethods['twitter']   = 'Twitter Username';
    $contactmethods['facebook']  = 'Facebook Username';
    $contactmethods['google']    = 'Google Plus Username';
    $contactmethods['instagram'] = 'Instagram Username';
    $contactmethods['pinterest'] = 'Pinterest Username';
    return $contactmethods;
}
add_filter('user_contactmethods','na_social_author',10,1);

/* Count share =======================================================================================================*/
if(!function_exists('share_count')){
    function share_count( $url ) {
        $count_face=facebook_like_share_count($url);
        $count_twitter=twitter_tweet_count($url);
        $count_linkedin=linkedin_count($url);
        $count_pinterest=pinterest_count($url);
        $count_google=google_count($url);
        $count=$count_face + $count_twitter + $count_linkedin + $count_pinterest + $count_google;
        return $count;
    };
}
function facebook_like_share_count( $url ) {
    global $wp_filesystem;
    $api ='http://graph.facebook.com/?id=' . $url ;

    if( empty( $wp_filesystem ) ) {
        require_once( ABSPATH .'/wp-admin/includes/file.php' );
        WP_Filesystem();
    }
    if( $wp_filesystem ) {
        $count_face=$wp_filesystem->get_contents($api);
    }
    if($count_face){
        $count = json_decode( $count_face );
        return $count->share->share_count;
    }
    return false;
};

function twitter_tweet_count( $url ) {
    global $wp_filesystem;
    $api ='http://public.newsharecounts.com/count.json?url=' . $url;
    if( empty( $wp_filesystem ) ) {
        require_once( ABSPATH .'/wp-admin/includes/file.php' );
        WP_Filesystem();
    }
    if( $wp_filesystem ) {
        $count_tweet=$wp_filesystem->get_contents($api);
    }
    if($count_tweet){
        $count = json_decode( $count_tweet );
        return $count->count;
    }
    return false;
};

function linkedin_count( $url ) {
    global $wp_filesystem;
    $api ='https://www.linkedin.com/countserv/count/share?url=' . urlencode( $url ).'&format=json';
    if( empty( $wp_filesystem ) ) {
        require_once( ABSPATH .'/wp-admin/includes/file.php' );
        WP_Filesystem();
    }
    if( $wp_filesystem ) {
        $count_linkedin=$wp_filesystem->get_contents($api);
    }
    if($count_linkedin){
        $count = json_decode( $count_linkedin );
        return  $count->count;
    }
    return false;
}

function pinterest_count( $url ) {
    $check_url = 'http://api.pinterest.com/v1/urls/count.json?callback=pin&url=' . urlencode( $url );
    $response = wp_remote_retrieve_body( wp_remote_get( $check_url ) );

    $response = str_replace( 'pin({', '{', $response);
    $response = str_replace( '})', '}', $response);
    $encoded_response = json_decode( $response, true );

    $share_count = intval( $encoded_response['count'] );
    return $share_count;
}

function google_count( $url ) {
    if( !$url ) {
        return 0;
    }
    if ( !filter_var($url, FILTER_VALIDATE_URL) ){
        return 0;
    }
    foreach (array('apis', 'plusone') as $host) {
        $ch = curl_init(sprintf('https://%s.google.com/u/0/_/+1/fastbutton?url=%s',
            $host, urlencode($url)));
        curl_setopt_array($ch, array(
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; WOW64) ' .
                'AppleWebKit/537.36 (KHTML, like Gecko) ' .
                'Chrome/32.0.1700.72 Safari/537.36' ));
        $response = curl_exec($ch);
        $curlinfo = curl_getinfo($ch);
        curl_close($ch);
        if (200 === $curlinfo['http_code'] && 0 < strlen($response)) { break 1; }
        $response = 0;
    }

    if( !$response ) {
        return 0;
    }
    preg_match_all('/window\.__SSR\s\=\s\{c:\s(\d+?)\./', $response, $match, PREG_SET_ORDER);
    return (1 === sizeof($match) && 2 === sizeof($match[0])) ? intval($match[0][1]) : 0;
}

if( ! function_exists( 'nano_pagination' ) ) {
    function nano_pagination(  $range = 2, $current_query = '', $pages = '' ) {
        $showitems = ($range * 2)+1;

        if( $current_query == '' ) {
            global $paged;
            if( empty( $paged ) ) $paged = 1;
        } else {
            $paged = $current_query->query_vars['paged'];
        }

        if( $pages == '' ) {
            if( $current_query == '' ) {
                global $wp_query;
                $pages = $wp_query->max_num_pages;
                if(!$pages) {
                    $pages = 1;
                }
            } else {
                $pages = $current_query->max_num_pages;
            }
        }

        if(1 != $pages) { ?>
            <div class="navigation pagination clearfix">
                <?php if ( $paged > 1 ) { ?>
                    <a class="prev page-numbers" href="<?php echo esc_url(get_pagenum_link($paged - 1)) ?>"><i class="fa fa-angle-left"></i></a>
                <?php }

                for ($i=1; $i <= $pages; $i++) {
                    if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                        if ($paged == $i) { ?>
                            <span class="page-numbers current"><?php echo esc_html($i) ?></span>
                        <?php } else { ?>
                            <a href="<?php echo esc_url(get_pagenum_link($i)) ?>" class="inactive page-numbers"><?php echo esc_html($i) ?></a>
                            <?php
                        }
                    }
                }
                if ($paged < $pages) { ?>
                    <a class="next page-numbers" href="<?php echo esc_url(get_pagenum_link($paged + 1)) ?>"><i class="fa fa-angle-right"></i></a>
                <?php } ?>
            </div>
            <?php
        }
    }
}
if( !function_exists( 'nano_get_query_var' ) ) {
    function nano_get_query_var( $var, $default = null){
        if((is_front_page() || is_home()) && $var == 'paged'){
            $var = 'page';
        }
        return  get_query_var( $var, $default );
    }
}