<?php
/**
 * @package     wide
 * @version     1.0
 * @author      NanoAgency
 * @link        http://www.nanoagency.co
 * @copyright   Copyright (c) 2016 NanoAgency
 * @license     GPL v2
 */

/* Customize font Google  =========================================================================================== */
if(!function_exists('wide_googlefont')){
    function wide_googlefont(){
        global $wp_filesystem;
        $filepath = get_template_directory().'/assets/googlefont/googlefont.json';
        if( empty( $wp_filesystem ) ) {
            require_once( ABSPATH .'/wp-admin/includes/file.php' );
            WP_Filesystem();
        }
        if( $wp_filesystem ) {
            $listGoogleFont=$wp_filesystem->get_contents($filepath);
        }
        if($listGoogleFont){
            $gfont = json_decode($listGoogleFont);
            $fontarray = $gfont->items;
            $options = array();
            foreach($fontarray as $font){
                $options[$font->family] = $font->family;
            }
            return $options;
        }
        return false;
    }
}

/* Post Thumbnail =================================================================================================== */
if ( ! function_exists( 'wide_post_thumbnail' ) ) :
    function wide_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
            ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
                <?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
            </a>

        <?php endif; // End is_singular()
    }
endif;

/* Excerpt more  ==================================================================================================== */
function new_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

if(!function_exists('wide_string_limit_words')){
    function wide_string_limit_words($string, $word_limit)
    {
        $words = explode(' ', $string, ($word_limit + 1));

        if(count($words) > $word_limit) {
            array_pop($words);
        }

        return implode(' ', $words);
    }
}

function wide_excerpt( $class = 'entry-excerpt' ) {
    $class = esc_attr( $class );
    if ( has_excerpt() || is_search() ) : ?>
        <div class="<?php echo esc_attr($class); ?>">
            <?php the_excerpt(); ?>
        </div><!-- .<?php echo esc_attr($class); ?> -->
    <?php endif;
}

/* Top Bar Disable ===================================================================================================*/
if(!function_exists('wide_topbar_config')){
    function wide_topbar_config() {
        global  $post,$wp_query;
        $configTopbar = get_theme_mod('wide_topbar_config','');
        if(is_page()){
            $configTopbar=get_post_meta($post->ID, 'menu_topbar',true);
        }
        if(isset($configTopbar) & $configTopbar == '0'){
            $configTopbar='hidden';
        }
        return $configTopbar;
    }
}
if(!function_exists('wide_menu_topbar')){
    function wide_menu_topbar() {
        global  $post,$wp_query;
        $menu_topbar="";
        if(is_page()){
            $menu_topbar=get_post_meta($post->ID, 'menu_topbar',true);
            if(isset($menu_topbar) & $menu_topbar == '0'){
                $menu_topbar='topbar-hiden';
            }
            else{
                $menu_topbar="topbar-show";
            }
        }
        return $menu_topbar;
    }
}

/* Keep Menu =========================================================================================================*/
if(!function_exists('wide_keep_menu')){
    function wide_keep_menu() {
        $configMenu = get_theme_mod('wide_menu_keep',false);
        if(isset($configMenu) & $configMenu == '1'){
            $configMenu='fixed';
        }
        return $configMenu;
    }
}

/* Boxed Menu =========================================================================================================*/
if(!function_exists('wide_menu_boxed')){
    function wide_menu_boxed() {
        global  $post,$wp_query;

        $menu_boxed = get_theme_mod('wide_header_boxed',false);//true flase

        if($menu_boxed & !empty($menu_boxed)){
            $menu_boxed='boxed';
        }
        if(is_page()){
            $menu_boxed=implode(get_post_meta($post->ID, 'header_boxed',false));
            if(isset($menu_boxed) & $menu_boxed ==='1'){
                $menu_boxed='boxed';
            }
            else{
                $menu_boxed='';
            }
        }
        return $menu_boxed;
    }

}

/* Sub String Content =============================================================================================== */
if(!function_exists('wide_content')) {
    function wide_content($limit)
    {
        $content = explode(' ', get_the_content(), $limit);
        if (count($content) >= $limit) {
            array_pop($content);
            $content = implode(" ", $content) . '...';
        } else {
            $content = implode(" ", $content) . '';
        }
        $content = preg_replace('/\[.+\]/', '', $content);
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        return $content;
    }
}

/* Get Category  ==================================================================================================== */
if(!function_exists('wide_category')) {
    function wide_category($separator)
    {
        $first_time = 1;
        foreach ((get_the_category()) as $category) {
            if ($first_time == 1) {?>
               <a href="<?php echo esc_url(get_category_link($category->term_id));?>" title="<?php  sprintf(esc_html__('View all posts in %s', 'wide'), $category->name); ?>" ><?php echo esc_attr($category->name);?></a>
               <?php $first_time = 0; ?>
            <?php } else {
                echo esc_attr($separator) ?>
                <a href="<?php esc_url(get_category_link($category->term_id)); ?>" title="<?php  sprintf(esc_html__('View all posts in %s', 'wide'), $category->name) ?>" ><?php  echo esc_attr($category->name); ?></a>
            <?php }
        }
    }
}

/* Language ========================================================================================================= */
// show / hidden  Language
// language switch
function wide_language_selector() {
    if ( in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if(!empty($languages)){
            $active="";
            echo '<div id ="language-switch">';
            foreach($languages as $language){
                if($language['active']==1){?>
                    <div  data-toggle="dropdown" class="dropdown-toggle" data-animation="500">
                        <?php if($language['country_flag_url']){
                                if(!$language['active']){?>
                                    <a href="<?php echo esc_url($language['url']);?>">
                                <?php }?>
                                <img src="<?php echo esc_url($language['country_flag_url']);?>" height="12" alt="<?php echo esc_attr($language['language_code']);?>" width="18" />
                                <?php if(!$language['active']) echo '</a>';
                        }
                        if(!$language['active']){?>
                           <a href="<?php echo esc_url($language['url']);?>">
                        <?php }
                        echo icl_disp_language($language['native_name'], $language['translated_name']);
                        if(!$language['active']) echo '</a>';
                        echo '<i class="fa fa-angle-down"></i>';
                    echo '</div>';
                }

            }
            echo '<ul class="dropdown-menu">';
            foreach($languages as $l){
                echo '<li>';
                if($l['country_flag_url']){
                    if(!$l['active']) {?>
                        <a href="<?php echo esc_url($l['url']);?>">
                    <?php }?>
                    <img src="<?php echo esc_url($l['country_flag_url']);?>" height="12" alt="<?php echo esc_url($l['language_code']);?>" width="18" />
                    <?php if(!$l['active']) echo '</a>';
                }
                if(!$l['active']){?>
                    <a href="<?php echo esc_url($l['url']);?>">
                <?php }
                echo icl_disp_language($l['native_name'], $l['translated_name']);
                if(!$l['active']) echo '</a>';
                echo '</li>';
            }
            echo '</ul></div>';
        }
    }
    else{?>
        <div id ="language-switch">
            <div  data-toggle="dropdown" class="dropdown-toggle"  data-delay="300">
                <a href="">
                    <span class="icl_lang_sel_current"><?php echo esc_html__('English', 'wide'); ?></span>
                    <i class="fa fa-angle-down"></i>
                </a>
            </div>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" class="ltr-en">
                        <span class="icl_lang_sel_current"><?php echo esc_html__('English', 'wide'); ?></span>
                    </a>
                </li>
                <li>
                    <a class="rtl-ar" href="#">
                        <span class="icl_lang_sel_current"><?php echo esc_html__('Arabic', 'wide'); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    <?php }
}

/* Config Sidebar Blog ============================================================================================== */
add_action( 'single-sidebar-left', 'wide_single_sidebar_left' );
function wide_single_sidebar_left() {
    $single_sidebar=get_theme_mod( 'wide_sidebar_single', 'right' );
    if ( $single_sidebar && $single_sidebar == 'left') { ?>
        <div id="archive-sidebar" class="sidebar sidebar-left col-sx-4 col-sm-4 col-md-4 col-lg-4 archive-sidebar">
            <?php get_sidebar('sidebar'); ?>
        </div>
    <?php }
}
add_action( 'single-sidebar-right', 'wide_single_sidebar_right' );
function wide_single_sidebar_right() {
    $single_sidebar=get_theme_mod( 'wide_sidebar_single', 'right' );
    if ( $single_sidebar && $single_sidebar == 'right') {?>
        <div id="archive-sidebar" class="sidebar sidebar-right col-sx-4 col-sm-4 col-md-4 col-lg-4 archive-sidebar">
            <?php get_sidebar('sidebar'); ?>
        </div>
    <?php }
}
//content
add_action( 'single-content-before', 'wide_single_content_before' );
function wide_single_content_before() {
    $single_sidebar=get_theme_mod( 'wide_sidebar_single', 'right' );
    if ( $single_sidebar && $single_sidebar == 'full') {?>
        <div class="main-content">
    <?php }
    else{?>
        <div class="main-content  col-sx-8 col-sm-12 col-md-8 col-lg-8">
    <?php }
}
add_action( 'single-content-after', 'wide_single_content_after' );
function wide_single_content_after() {
    $single_sidebar=get_theme_mod( 'wide_sidebar_single', 'right' );
    if ( $single_sidebar){?>
        </div>
    <?php }
}

/* Config Sidebar archive =========================================================================================== */
add_action( 'archive-sidebar-left', 'wide_cat_sidebar_left' );
function wide_cat_sidebar_left() {
    $cat_sidebar=get_theme_mod( 'wide_sidebar_cat', 'right' );
    if(isset($_GET['layout'])){
        $cat_sidebar=$_GET['layout'];
    }
    if ( $cat_sidebar && $cat_sidebar == 'left') {?>
         <div id="archive-sidebar" class="sidebar sidebar-left col-sx-4 col-sm-4 col-md-4 col-lg-4 archive-sidebar">
            <?php get_sidebar('sidebar'); ?>
        </div>
    <?php }
}
add_action( 'archive-sidebar-right', 'wide_cat_sidebar_right' );
function wide_cat_sidebar_right() {
    $cat_sidebar=get_theme_mod( 'wide_sidebar_cat', 'right' );
    if(isset($_GET['layout'])){
        $cat_sidebar=$_GET['layout'];
    }
    if ( $cat_sidebar && $cat_sidebar == 'right') {?>
         <div id="archive-sidebar" class="sidebar sidebar-right col-sx-4 col-sm-4 col-md-4 col-lg-4 archive-sidebar">
            <?php get_sidebar('sidebar'); ?>
        </div>
    <?php }
}
//content
add_action( 'archive-content-before', 'wide_cat_content_before' );
function wide_cat_content_before() {
    $cat_sidebar=get_theme_mod( 'wide_sidebar_cat', 'right' );
    if(isset($_GET['layout'])){
        $cat_sidebar=$_GET['layout'];
    }
    if ( $cat_sidebar && $cat_sidebar == 'full') {?>
        <div class="main-content">
    <?php }
    else{?>
        <div class="main-content col-sx-8 col-sm-8 col-md-8 col-lg-8">
    <?php }
}
add_action( 'archive-content-after', 'wide_cat_content_after' );
function wide_cat_content_after() {
    $cat_sidebar=get_theme_mod( 'wide_sidebar_cat', 'right' );
    if ( $cat_sidebar){?>
        </div>
    <?php }
}


/* Comment Form ===================================================================================================== */
function wide_comment_form($arg,$class='btn-variant',$id='submit'){
    ob_start();
    comment_form($arg);
    $form = ob_get_clean();
    echo str_replace('id="submit"','id="'.$id.'" class="'.$class.'"', $form);
}

function wide_list_comments($comment, $args, $depth){
    $path = get_template_directory() . '/templates/list_comments.php';
    if( is_file($path) ) require ($path);
}


/* Facebook Comments =================================================================================================*/
add_action('wp_head', 'wide_facebook_comments');
function wide_facebook_comments() {
        $app_id=get_theme_mod('wide_comments_single',''); ?>
        <meta property="fb:app_id" content="<?php echo esc_attr($app_id);?>" />
<?php }

/* Breadcrumb ========================================================================================================*/
function wide_breadcrumb(){?>
	<nav id="wide_breadcrumbs">
        <?php
        if(in_array("search-no-results",get_body_class())){ ?>
           <div class="breadcrumb" class="col-sm-12">
           <a href="<?php get_template_directory_uri().'/'; ?>"><?php echo esc_html__('Home','wide'); ?></a>
           <span class="delimiter">/</span>
           <span class="current"><?php echo esc_html__('Search results for','wide'); ?> "<?php echo get_search_query(); ?>"</span> </div>
        <?php
            }else{
//            	$delimiter = '&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;';
            	$delimiter = '&nbsp;&nbsp;';
		        $home = esc_html__('Home','wide');
		        $before = '';
		        $after = '';
		        global $post;
		        global $wp_query;
		        $homeLink = home_url();
		        echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
		        if ( is_category() ) {
			        global $wp_query;
			        $cat_obj = $wp_query->get_queried_object();
			        $thisCat = $cat_obj->term_id;
			        $thisCat = get_category($thisCat);
			        $parentCat = get_category($thisCat->parent);
			        if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			        echo esc_attr($before) . '' . single_cat_title('', false) . '' . $after;
		        } elseif ( is_day() ) {
			        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			        echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			        echo esc_attr($before) .esc_html__('Archive by date','wide').'"' . get_the_time('d') . '"' . $after;
		        } elseif ( is_month() ) {
			        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			        echo esc_attr($before) .esc_html__('Archive by month ','wide').'"' . get_the_time('F') . '"' . $after;
		        } elseif ( is_year() ) {
		        	echo esc_attr($before) .esc_html__('Archive by year ','wide').'"' . get_the_time('Y') . '"' . $after;
		        } elseif ( is_single() && !is_attachment() ) {
			        if ( get_post_type() != 'post' ) {
				        $post_type = get_post_type_object(get_post_type());
				        $slug = $post_type->rewrite;
				        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>' . $delimiter . ' ';
				        echo esc_attr($before) . get_the_title() . $after;
			        } else {
				        $cat = get_the_category(); $cat = $cat[0];
				        echo ' ' . get_category_parents($cat, TRUE, ' ' . $delimiter . ' ') . ' ';
				        echo esc_attr($before) . '' . get_the_title() . '' . $after;
			        }
		        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			        $post_type = get_post_type_object(get_post_type());
			        echo esc_attr($before) . $post_type->labels->singular_name . $after;
		        } elseif ( is_attachment() ) {
			        $parent_id  = $post->post_parent;
			        $breadcrumbs = array();
			        while ($parent_id) {
				        $page = get_page($parent_id);
				        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				        $parent_id    = $page->post_parent;
			        }
			        $breadcrumbs = array_reverse($breadcrumbs);
			        foreach ($breadcrumbs as $crumb) echo ' ' . $crumb . ' ' . $delimiter . ' ';
			        echo esc_attr($before) . '' . get_the_title() . '' . $after;
		        } elseif ( is_page() && !$post->post_parent ) {
		        	echo esc_attr($before) . '' . get_the_title() . '' . $after;
		        } elseif ( is_page() && $post->post_parent ) {
			        $parent_id  = $post->post_parent;
			        $breadcrumbs = array();
			        while ($parent_id) {
				        $page = get_page($parent_id);
				        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				        $parent_id    = $page->post_parent;
			        }
			        $breadcrumbs = array_reverse($breadcrumbs);
			        foreach ($breadcrumbs as $crumb) echo ' ' . $crumb . ' ' . $delimiter . ' ';
		        	echo esc_attr($before) . '' . get_the_title() . '"' . $after;
		        } elseif ( is_search()) {
		            echo esc_attr($before) . esc_html__('Search results for ','wide').'"' . get_search_query() . '"' . $after;
		        } elseif ( is_tag() ) {
		        	echo esc_attr($before) . esc_html__('Archive by tag ','wide').'"' . single_tag_title('', false) . '"' . $after;
		        } elseif ( is_author() ) {
		        global $author;
		        $userdata = get_userdata($author);
		        	echo esc_attr($before) . esc_html__('Articles posted by ','wide').'"' . $userdata->display_name . '"' . $after;
		        } elseif ( is_404() ) {
		        	echo esc_attr($before) . esc_html__('You got it ','wide').'"' .esc_html__('Error 404 not Found','wide').'"&nbsp;' . $after;
		        }
		        if ( get_query_var('paged') ) {
			        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' ';
			        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo '';
		        }
            }
        ?>
</nav>
<?php }
    /* Ajax Feature Post =================================================================================================*/
    add_action('wp_ajax_feature_post', 'wide_feature_post');
    add_action('wp_ajax_nopriv_feature_post', 'wide_feature_post');
    function wide_feature_post() {

        if (check_admin_referer( 'wide-feature-post' ) ) {
            $post_id = absint( $_GET['post_id'] );
            if ( 'post' === get_post_type( $post_id ) ) {
                update_post_meta( $post_id, '_featured', get_post_meta( $post_id, '_featured', true ) === 'yes' ? 'no' : 'yes' );
                delete_transient( 'wide_featured_post' );
            }
        }
        wp_safe_redirect( wp_get_referer() ? remove_query_arg( array( 'trashed', 'untrashed', 'deleted', 'ids' ), wp_get_referer() ) : admin_url( 'edit.php' ) );
        die();
    }

    // add featured thumbnail to admin post columns
    function wide_add_thumbnail_columns( $columns ) {
        $columns['post_featured'] = esc_html__('Featured', 'wide');
        return $columns;
    }
    function wide_is_featured() {
        $featured =get_post_meta( get_the_ID(), '_featured', true );
        return $featured === 'yes' ? true : false;
    }
    function wide_add_thumbnail_columns_data( $column_name, $post_id) {
        if ($column_name === 'post_featured') {
            $url = wp_nonce_url( admin_url( 'admin-ajax.php?action=feature_post&post_id=' . get_the_ID() ), 'wide-feature-post' );
            echo '<a href="' . esc_url( $url ) . '" title="'. __( 'Toggle featured', 'wide' ) . '">';
            if (wide_is_featured()) {
                echo '<span class="wide-featured tips" data-tip="' . esc_attr__( 'Yes', 'wide' ) . '"><span class="dashicons dashicons-star-filled"></span> </span>';
            } else {
                echo '<span class="wide-featured not-featured tips" data-tip="' . esc_attr__( 'No', 'wide' ) . '"><span class="dashicons dashicons-star-empty"></span></span>';
            }
            echo '</a>';
        }
    }

    if ( function_exists( 'add_theme_support' ) ) {
        add_filter( 'manage_posts_columns' , 'wide_add_thumbnail_columns' );
        add_action( 'manage_posts_custom_column' , 'wide_add_thumbnail_columns_data', 10, 2 );
    }

    /* PostViews =========================================================================================================*/
    function wide_post_views($post_ID)
    {
        $count_key = 'post_views_count';
        $count = get_post_meta($post_ID, $count_key, true);
        if ($count == '') {
            $count = 0;
            delete_post_meta($post_ID, $count_key);
            add_post_meta($post_ID, $count_key, '0');
        } else {
            $count++;
            update_post_meta($post_ID, $count_key, $count);
        }
    }

    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    function wide_track_post_views($post_id)
    {
        if (!is_single()) return;
        if (empty ($post_id)) {
            global $post;
            $post_id = $post->ID;
        }
        wide_post_views($post_id);
    }

    add_action('wp_head', 'wide_track_post_views');
    function wide_get_PostViews($post_ID)
    {
        $count_key = 'post_views_count';
        $count = get_post_meta($post_ID, $count_key, true);

        return $count;
    }

    function wide_post_column_views($newcolumn)
    {
        $newcolumn['post_views'] = esc_html__('Views', 'wide');
        return $newcolumn;
    }
    function wide_post_custom_column_views($column_name, $id)
    {

        if ($column_name === 'post_views') {
            echo esc_attr(wide_get_PostViews(get_the_ID()));
        }
    }

    add_filter('manage_posts_columns', 'wide_post_column_views');
    add_action('manage_posts_custom_column', 'wide_post_custom_column_views', 10, 2);

    /* Move comment field to bottom ======================================================================================*/
    function wide_move_comment_field_to_bottom( $fields ) {
        $comment_field = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;
        return $fields;
    }
    add_filter( 'comment_form_fields', 'wide_move_comment_field_to_bottom' );
?>
