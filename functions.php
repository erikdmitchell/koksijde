<?php
/**
 * MDW Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @package WordPress
 * @subpackage MDW Theme
 * @since MDW Theme 1.0.0
 */

/**
 * Set our global variable for theme options.
 *
 * @since MDW Theme 1.6.0
 */
if (!isset($mdw_theme_options))
	$mdw_theme_options=array(
		'option_name' => 'mdw_wp_theme_options'
	);

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since MDW Theme 1.0.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since MDW Theme 1.1.9
 */
function mdw_theme_setup() {
	/**
	 * add our theme support options
	 */
	$custom_header_args=array(
		'width' => 163,
		'height' => 76
	);

	add_theme_support('automatic-feed-links');
	add_theme_support('custom-header',$custom_header_args);
	add_theme_support('menus');
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');

	/**
	 * add our image size(s)
	 */
	add_image_size('navbar-logo', 163, 100, true);

	/**
	 * include deprecated functions
	 */
	include_once(get_template_directory().'/inc/deprecated.php');

	/**
	 * include admin stuff
	 */
	include_once(get_template_directory().'/inc/admin/init.php');

	/**
	 * include bootstrap nav walker
	 */
	include_once(get_template_directory().'/inc/wp_bootstrap_navwalker.php');

	/**
	 * include bootstrap mobile nav walker
	 */
	include_once(get_template_directory().'/inc/wp_bootstrap_mobile_nav_walker.php');

	/**
	 * include theme slider class
	 */
	include_once(get_template_directory().'/inc/slider.php');

	/**
	 * include theme meta page
	 * allows users to hook and filter into the default meta tags in the header
	 */
	include_once(get_template_directory().'/inc/theme-meta.php');

	/**
	 * include theme options
	 */
	include_once(get_template_directory().'/theme-options.php');


	// run our function to disable the responsivness of the theme (set in theme options)
	if (!is_admin())
		disable_responsive();

	// register our navigation area
	register_nav_menus( array(
		'primary' => __('Primary Menu','mdw-theme'),
		'mobile' => __('Mobile Menu','mdw-theme'),
		'secondary' => __('Secondary Menu','mdw-theme'),
	) );

	/**
	 * This theme styles the visual editor to resemble the theme style
	 */
	add_editor_style('inc/css/editor-style.css');

}
add_action('after_setup_theme','mdw_theme_setup');

/**
 * Register widget area.
 *
 * @since MDW Theme 1.0.0
 */
function mdw_theme_widgets_init() {

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
add_action('widgets_init','mdw_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 *
 * @since MDW Theme 1.1.9
 */
function mdw_theme_scripts() {
	// font awesome
	wp_enqueue_style('font-awesome-style',get_template_directory_uri().'/inc/css/font-awesome.min.css',array(),'4.5.0');

	// Load our main stylesheet.
	wp_enqueue_style('mdw-wp-theme-style',get_stylesheet_uri());

	// enqueue our scripts for bootstrap, slider and theme
	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap',get_template_directory_uri().'/inc/js/bootstrap.min.js',array('jquery'),'3.3.2',true);
	wp_enqueue_script('jquery-actual-script',get_template_directory_uri().'/inc/js/jquery.actual.min.js',array('jquery'),'1.0.16',true);

	wp_enqueue_script('mdw-theme-script',get_template_directory_uri().'/inc/js/mdw-theme.js',array('jquery'),'1.2.0',true);

	if ( is_singular() ) :
		wp_enqueue_script( 'comment-reply' );
	endif;

}
add_action('wp_enqueue_scripts','mdw_theme_scripts');

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @since MDW Theme 1.0
 * @based on twentyfourteen
 *
 * @return void
*/
function mdw_theme_post_thumbnail($size='full') {
	global $post;

	$html=null;
	$attr=array(
		'class' => 'img-responsive'
	);

	if (post_password_required() || !has_post_thumbnail())
		return;

	if (is_singular()) :
		$html.='<div class="post-thumbnail">';
			$html.=get_the_post_thumbnail($post->ID,$size,$attr);
		$html.='</div>';
	else :
		$html.='<a class="post-thumbnail" href="'.the_permalink().'">';
			$html.=get_the_post_thumbnail($post->ID,$size,$attr);
		$html.='</a>';
	endif;

	$image=apply_filters('mdw_theme_post_thumbnail',$html,$size,$attr);

	echo $image;
}

/**
 * Find out if blog has more than one category.
 *
 * @since MDW Theme 1.0
 * @based on twentyfourteen ----- DOESNT WORK
 *
 * @return boolean true if blog has more than 1 category
 */
function mdw_theme_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'mdw_theme_category_count' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'mdw_theme_category_count', $all_the_cool_cats );
	}

	if ( 1 !== (int) $all_the_cool_cats ) {
		// This blog has more than 1 category so wpbootstrap_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so wpbootstrap_categorized_blog should return false
		return false;
	}
}

/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since MDW Theme 1.0
 * @based on twentyfourteen
 *
 * @return void
 */
function mdw_theme_posted_on() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		echo '<span class="featured-post"><span class="glyphicon glyphicon-pushpin"></span>' . __( 'Sticky', 'mdw-theme' ) . '</span>';
	}

	// Set up and print post meta information. -- hide date if sticky
	if (!is_sticky()) :
		echo '<span class="entry-date"><span class="glyphicon glyphicon-time"></span><a href="'.get_permalink().'" rel="bookmark"><time class="entry-date" datetime="'.get_the_date('c').'">'.get_the_date().'</time></a></span>';
	endif;
	echo '<span class="byline"><span class="glyphicon glyphicon-user"></span><span class="author vcard"><a class="url fn n" href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" rel="author">'.get_the_author().'</a></span></span>';
}

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since MDW Theme 1.0
 * @based on twentyfourteen
 *
 * @return void
 */
function mdw_theme_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), esc_url($pagenum_link) );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&laquo; Previous', 'mdw-theme' ),
		'next_text' => __( 'Next &raquo;', 'mdw-theme' ),
	) );

	if ( $links ) :
		?>
		<nav class="navigation paging-navigation" role="navigation">
			<div class="pagination loop-pagination">
				<?php echo $links; ?>
			</div><!-- .pagination -->
		</nav><!-- .navigation -->
		<?php
	endif;
}

/**
 * Display navigation to next/previous post when applicable.
 *
 * @since MDW Theme 1.0.1
 * @based on twentyfourteen
 *
 * @return void
 */
function mdw_theme_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'mdw-theme' ) );
			else :
				previous_post_link( '%link', __( '<span class="meta-nav">Previous Post</span>%title', 'mdw-theme' ) );
				next_post_link( '%link', __( '<span class="meta-nav">Next Post</span>%title', 'mdw-theme' ) );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

/**
 * display_meta_description function.
 *
 * a custom function to display a meta description for our site pages
 *
 * @access public
 * @return void
 */
function display_meta_description() {
	global $post;

	$title=null;

	if (isset($post->post_title))
		$title=$post->post_title;

	if ( is_single() ) {
		return single_post_title('', false);
	} else {
		return $title.' - '.get_bloginfo('name').' - '.get_bloginfo('description');
	}

	return false;
}

/**
 * mdw_theme_navbar_brand function.
 *
 * adds our logo or text based on theme options
 *
 * @access public
 * @return void
 */
function mdw_theme_navbar_brand() {
	global $mdw_theme_options;

	$text=get_bloginfo('name');

	if (isset($mdw_theme_options['default']['logo']['text']) && $mdw_theme_options['default']['logo']['text']!='')
		$text=$mdw_theme_options['default']['logo']['text'];

	// display header image or text //
	if (get_header_image()) :
		echo '<img src="'.get_header_image().'" height="'.get_custom_header()->height.'" width="'.get_custom_header()->width.'" alt="" />';
	else :
		echo '<a class="navbar-brand" href="'.$url.'">'.$text.'</a>';
	endif;
}

/**
 * mdw_theme_special_nav_classes function.
 *
 * allows us to add more specific classes to the wp nav menu
 * more specifically, we can add a logo class depending on theme options
 *
 * @access public
 * @param mixed $args
 * @return void
 */
function mdw_theme_special_nav_classes($args) {
	$theme_options=array();

	if (class_exists('MDWWPThemeOptions'))
		$theme_options=new MDWWPThemeOptions();

	if (isset($theme_options->options['logo']['image']) && $theme_options->options['logo']['image']!='')
		$args['menu_class'].=' logo';

	return $args;
}
add_filter('wp_nav_menu_args','mdw_theme_special_nav_classes',10,1);

/**
 * mdw_mobile_navigation_setup function.
 *
 * checks if we have an active mobile menu
 * if active mobile, sets it, if not, default to primary
 *
 * @access public
 * @return void
 */
function mdw_mobile_navigation_setup() {
	$html=null;

	if (has_nav_menu('mobile')) :
		$location='mobile';
	else :
		$location='primary';
	endif;

	$location=apply_filters('mdw_mobile_navigation_setup_location',$location);

	if ($location=='primary' && !has_nav_menu($location))
		return false;

	$html.='<div id="mdw-mobile-nav" class="collapse navbar-collapse mdw-wp-theme-mobile-menu hidden-sm hidden-md hidden-lg">';

		$html.=wp_nav_menu(array(
			'theme_location' => $location,
			'container' => 'div',
			'container_class' => 'panel-group navbar-nav',
			'container_id' => 'accordion',
			'echo' => false,
			//'items_wrap'=>'%3$s',
			'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
			'walker' => new MDWwpMobileNavWalker()
		));

	$html.='</div><!-- .mdw-wp-theme-mobile-menu -->';

	echo $html;
}

/**
 * mdw_secondary_navigation_setup function.
 *
 * if our secondary menu is set, this shows it
 *
 * @access public
 * @return void
 */
function mdw_secondary_navigation_setup() {
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

	echo $html;
}

/**
 * disable_responsive function.
 *
 * @access public
 * @return void
 */
function disable_responsive() {
	if (!class_exists('MDWWPThemeOptions'))
		return false;

	$theme_options=new MDWWPThemeOptions();

	if (!isset($theme_options->options['non_responsive']) || !$theme_options->options['non_responsive'])
		return false;

	// remove our viewport meta tag //
	add_filter('mdw_wp_meta_viewport', function($meta) { return ''; });

	// remove image responsive from our home slider //
	add_filter('mdw-wp-theme-slider-classes', function($classes) {
		unset($classes['img-responsive']);
		return $classes;
	});

	// force styles into the footer so that they override the responsiveness
	add_action('wp_footer',function() {
		$non_responsive_styles=array();

		$non_responsive_styles[]='
			.container {
				width: 970px !important;
			}
			.mdw-wp-slider {
				width: 100% !important;
			}
		';

		echo '<style>'.implode(' ',$non_responsive_styles).'</style>';

	});

	return true;
}

/**
 * mdw_back_to_top function.
 *
 * @access public
 * @return void
 */
function mdw_back_to_top() {
	$html=null;

	$html.='<a href="#0" class="mdw-back-to-top"></a>';

	echo $html;
}
add_action('wp_footer','mdw_back_to_top');

/* Similar to wp_parse_args() just a bit extended to work with multidimensional arrays :) */
function mdw_wp_parse_args(&$a,$b) {
	$a = (array) $a;
	$b = (array) $b;
	$result = $b;
	foreach ( $a as $k => &$v ) {
		if ( is_array( $v ) && isset( $result[ $k ] ) ) {
			$result[ $k ] = mdw_wp_parse_args( $v, $result[ $k ] );
		} else {
			$result[ $k ] = $v;
		}
	}
	return $result;
}

/**
 * Initialize theme updater function. Utalizes the theme-update-checker.php file in theme-updates
 * Develpoed by W-Shadow (http://w-shadow.com/blog/2011/06/02/automatic-updates-for-commercial-themes/)
 */
require_once(get_template_directory().'/inc/theme-updates/theme-update-checker.php');
$update_checker = new ThemeUpdateChecker(
	'mdw-wp-theme',
	'http://www.millerdesignworks.com/mdw-wp-themes/mdw-wp-theme.json'
);
?>
