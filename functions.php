<?php
/**
 * Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @subpackage koksijde
 * @since koksijde 1.0.0
 */

/**
 * Set our global variables for theme options.
 *
 * @since koksijde 1.0.0
 */
if (!isset($koksijde_theme_options))
	$koksijde_theme_options=array('option_name' => 'koksijde_theme_options');

if (!isset($koksijde_theme_options_tabs))
	$koksijde_theme_options_tabs=array();

if (!isset($koksijde_theme_options_hooks))
	$koksijde_theme_options_hooks=array();

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since koksijde 1.0.0
 */
function koksijde_theme_setup() {
	// Set the content width based on the theme's design and stylesheet //
	$GLOBALS['content_width']=apply_filters('koksijde_content_width', 1200);

	/**
	 * add our theme support options
	 */
	$custom_header_args=array(
		'width' => 163,
		'height' => 76,
		'flex-width' => true,
		'flex-height' => true
	);

	$custom_background_args=array(
		'deafult-color' => 'ffffff'
	);

	add_theme_support('automatic-feed-links');
	add_theme_support('custom-header', $custom_header_args);
	add_theme_support('custom-background', $custom_background_args);
	add_theme_support('menus');
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');

	/**
	 * add our image size(s)
	 */
	add_image_size('koksijde-navbar-logo', 163, 100, true);
	add_image_size('koksijde-home-image', 9999, 400, true);
	add_image_size('koksijde-home-blog-post-image', 555, 225, true);

	/**
	 * include bootstrap nav walker
	 */
	include_once(get_template_directory().'/inc/wp-bootstrap-navwalker.php');

	/**
	 * include bootstrap mobile nav walker
	 */
	include_once(get_template_directory().'/inc/mobile_nav_walker.php');

	/**
	 * include our customizer settings
	 */
	include_once(get_template_directory().'/inc/customizer/customizer.php');

	/**
	 * include our customizer functions
	 */
	include_once(get_template_directory().'/inc/customizer/slider.php');
	include_once(get_template_directory().'/inc/customizer/blog-posts.php');
	include_once(get_template_directory().'/inc/customizer/general.php');

	// register our navigation area
	register_nav_menus( array(
		'primary' => __('Primary Menu', 'koksijde'),
		'mobile' => __('Mobile Menu', 'koksijde'),
		'secondary' => __('Secondary Menu', 'koksijde'),
	) );

	/**
	 * This theme styles the visual editor to resemble the theme style
	 */
	add_editor_style('inc/css/editor-style.css');

}
add_action('after_setup_theme','koksijde_theme_setup');

/**
 * Register widget area.
 *
 * @since koksijde 1.0.0
 */
function koksijde_theme_widgets_init() {

	register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'Footer 1',
		'id' => 'footer-1',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'Footer 2',
		'id' => 'footer-2',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'Footer 3',
		'id' => 'footer-3',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

}
add_action('widgets_init','koksijde_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 *
 * @since koksijde 1.1.9
 */
function koksijde_theme_scripts() {
	global $wp_scripts;

	// enqueue our scripts for bootstrap, slider and theme
	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap', get_template_directory_uri().'/inc/js/bootstrap.js', array('jquery'), '3.3.7', true);
	wp_enqueue_script('jquery-actual', get_template_directory_uri().'/inc/js/jquery.actual.js', array('jquery'), '1.0.16', true);
	wp_enqueue_script('koksijde-theme-script', get_template_directory_uri().'/inc/js/koksijde-theme.js', array('jquery'), '1.0.2', true);

	if ( is_singular() )
		wp_enqueue_script( 'comment-reply' );

	/**
	 * Load our IE specific scripts for a range of older versions:
	 * <!--[if lt IE 9]> ... <![endif]-->
	 * <!--[if lte IE 8]> ... <![endif]-->
	*/
	// HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries //
	wp_enqueue_script('html5shiv', get_template_directory_uri().'/inc/js/html5shiv.js', array(), '3.7.3-pre');
	wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');
	
	wp_enqueue_script('respond', get_template_directory_uri().'/inc/js/respond.js', array(), '1.4.2');
	wp_script_add_data('respond', 'conditional', 'lt IE 9');

	// enqueue font awesome and our main stylesheet
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/inc/css/font-awesome.css', array(), '4.6.3');
	wp_enqueue_style('bootstrap', get_template_directory_uri().'/inc/css/bootstrap.css', array(), '3.3.7');
	wp_enqueue_style('koksijde-theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts','koksijde_theme_scripts');

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @since koksijde 1.0
 * @based on twentyfourteen
 *
 * @return void
*/
function koksijde_theme_post_thumbnail($size='full') {
	global $post;

	$html=null;
	$attr=array(
		'class' => 'img-responsive'
	);

	if (post_password_required() || !has_post_thumbnail())
		return;

	if (is_singular()) :
		$html.='<div class="post-thumbnail">';
			$html.=get_the_post_thumbnail($post->ID, $size, $attr);
		$html.='</div>';
	else :
		$html.='<a class="post-thumbnail" href="'.esc_url(get_permalink($post->ID)).'">';
			$html.=get_the_post_thumbnail($post->ID, $size, $attr);
		$html.='</a>';
	endif;

	$image=apply_filters('koksijde_theme_post_thumbnail', $html, $size, $attr);

	echo $image;
}

/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since koksijde 1.0
 * @based on twentyfourteen
 *
 * @return void
 */
function koksijde_theme_posted_on() {
	$html=null;

	if ( is_sticky() && is_home() && ! is_paged() ) :
		$html='<span class="featured-post"><span class="glyphicon glyphicon-pushpin"></span>' . __( 'Sticky', 'koksijde' ) . '</span>';
	elseif (!is_sticky()) : 	// Set up and print post meta information. -- hide date if sticky
		$html='<span class="entry-date"><span class="glyphicon glyphicon-time"></span><a href="'.esc_url(get_permalink()).'" rel="bookmark"><time class="entry-date" datetime="'.get_the_date('c').'">'.get_the_date().'</time></a></span>';
	else :
		$html='<span class="byline"><span class="glyphicon glyphicon-user"></span><span class="author vcard"><a class="url fn n" href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" rel="author">'.get_the_author().'</a></span></span>';
	endif;

	echo apply_filters('koksijde_posted_on', $html);
}

/**
 * koksijde_display_meta_description function.
 *
 * a custom function to display a meta description for our site pages
 *
 * @access public
 * @return void
 */
function koksijde_display_meta_description() {
	global $post;

	$title=null;

	if (isset($post->post_title))
		$title=$post->post_title;

	if ( is_single() ) :
		return apply_filters('koksijde_display_meta_description', single_post_title('', false));
	else :
		return apply_filters('koksijde_display_meta_description', $title.' - '.get_bloginfo('name').' - '.get_bloginfo('description'));
	endif;

	return false;
}

/**
 * koksijde_header_markup function.
 * 
 * @access public
 * @return void
 */
function koksijde_header_markup() {
	$html=null;
	
	if (get_header_image()) :
		$html.='<div class="koksijde-header-image">';
			$html.='<img src="'.esc_url(get_header_image()).'" height="'.absint(get_custom_header()->height).'" width="'.absint(get_custom_header()->width).'" alt="" />';
		$html.='</div>';
	endif;
	
	echo $html;
}

/**
 * koksijde_theme_special_nav_classes function.
 *
 * allows us to add more specific classes to the wp nav menu
 * more specifically, we can add a logo class depending on theme options
 *
 * @access public
 * @param mixed $args
 * @return void
 */
function koksijde_theme_special_nav_classes($args) {
	global $koksijde_theme_options;

	if (isset($koksijde_theme_options['default']['logo']['image']) && $koksijde_theme_options['default']['logo']['image']!='')
		$args['menu_class'].=' logo';

	return $args;
}
add_filter('wp_nav_menu_args', 'koksijde_theme_special_nav_classes', 10, 1);

/**
 * koksijde_mobile_navigation_setup function.
 *
 * checks if we have an active mobile menu
 * if active mobile, sets it, if not, default to primary
 *
 * @access public
 * @return void
 */
function koksijde_mobile_navigation_setup() {
	$html=null;

	if (has_nav_menu('mobile')) :
		$location='mobile';
	else :
		$location='primary';
	endif;

	$location=apply_filters('koksijde_mobile_navigation_setup_location', $location);

	if ($location=='primary' && !has_nav_menu($location))
		return false;

	$html.='<div id="koksijde-mobile-nav" class="collapse koksijde-mobile-menu hidden-sm hidden-md hidden-lg">';

		$html.=wp_nav_menu(array(
			'theme_location' => $location,
			'container' => 'div',
			'container_class' => 'panel-group navbar-nav',
			'container_id' => 'accordion',
			'echo' => false,
			'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
			'walker' => new koksijdeMobileNavWalker()
		));

	$html.='</div><!-- .koksijde-theme-mobile-menu -->';

	echo apply_filters('koksijde_mobile_navigation', $html);
}

/**
 * koksijde_secondary_navigation_setup function.
 *
 * if our secondary menu is set, this shows it
 *
 * @access public
 * @return void
 */
function koksijde_secondary_navigation_setup() {
	$html=null;

	if (!has_nav_menu('secondary'))
		return false;

	$html.='<div class="collapse navbar-collapse secondary-menu">';
		$html.=wp_nav_menu(array(
			'theme_location' => 'secondary',
			'container' => false,
			'menu_class' => 'nav navbar-nav pull-right secondary',
			'echo' => false,
			'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
			'walker' => new wp_bootstrap_navwalker()
		));
	$html.='</div> <!-- .secondary-menu -->';

	echo apply_filters('koksijde_secondary_navigation', $html);
}

/**
 * koksijde_back_to_top function.
 *
 * @access public
 * @return void
 */
function koksijde_back_to_top() {
	$html=null;

	$html.='<a href="#0" class="koksijde-back-to-top"></a>';

	echo apply_filters('koksijde_back_to_top', $html);
}
add_action('wp_footer', 'koksijde_back_to_top');

/**
 * koksijde_wp_parse_args function.
 *
 * Similar to wp_parse_args() just a bit extended to work with multidimensional arrays
 *
 * @access public
 * @param mixed &$a
 * @param mixed $b
 * @return void
 */
function koksijde_wp_parse_args(&$a,$b) {
	$a = (array) $a;
	$b = (array) $b;
	$result = $b;

	foreach ( $a as $k => &$v ) {
		if ( is_array( $v ) && isset( $result[ $k ] ) ) {
			$result[ $k ] = koksijde_wp_parse_args( $v, $result[ $k ] );
		} else {
			$result[ $k ] = $v;
		}
	}

	return $result;
}

/**
 * koksijde_get_excerpt_by_id function.
 *
 * @access public
 * @param string $post (default: '')
 * @param int $length (default: 10)
 * @param string $tags (default: '<a><em><strong>')
 * @param string $extra (default: '...')
 * @return void
 */
function koksijde_get_excerpt_by_id($post='', $length=10, $tags='<a><em><strong>', $extra='...') {
 	// if post is id, get the post, if it's the object we are ok, else bail //
	if (is_int($post)) :
		$post = get_post($post);
	elseif (!is_object($post)) :
		return false;
	endif;

	// check for excerpt and return that, else grab the post content //
	if (has_excerpt($post->ID)) :
		$the_excerpt = $post->post_excerpt;
		return apply_filters('the_content', $the_excerpt);
	else :
		$the_excerpt = $post->post_content;
	endif;

	$the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags); // remove shortcodes and tags
	$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1); // do our length (words)
	$excerpt_waste = array_pop($the_excerpt); // grab the "excerpt"
	$the_excerpt = implode($the_excerpt); // convert our array of words to an actual exceprt
	$the_excerpt .= $extra; // append the extra

	return apply_filters('the_content', $the_excerpt);
}

/**
 * koksijde_theme_get_image_id_from_url function.
 *
 * @access public
 * @param mixed $image_url
 * @return void
 */
function koksijde_theme_get_image_id_from_url($image_url) {
	global $wpdb;

	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));

	return $attachment[0];
}

/**
 * koksijde_array_recursive_diff function.
 *
 * @access public
 * @param mixed $aArray1
 * @param mixed $aArray2
 * @return void
 */
function koksijde_array_recursive_diff($aArray1, $aArray2) {
  $aReturn = array();

  foreach ($aArray1 as $mKey => $mValue) {
    if (array_key_exists($mKey, $aArray2)) {
      if (is_array($mValue)) {
        $aRecursiveDiff = koksijde_array_recursive_diff($mValue, $aArray2[$mKey]);
        if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
      } else {
        if ($mValue != $aArray2[$mKey]) {
          $aReturn[$mKey] = $mValue;
        }
      }
    } else {
      $aReturn[$mKey] = $mValue;
    }
  }
  return $aReturn;
}

/**
 * koksijde_home_image function.
 * 
 * @access public
 * @return void
 */
function koksijde_home_image() {
	global $post;
	
	$thumb_url=get_the_post_thumbnail_url($post->ID, 'koksijde-home-image');
	
	echo '<div style="background-image: url('.$thumb_url.')"></div>';
}
?>