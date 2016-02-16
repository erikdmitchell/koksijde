<?php
//_deprecated_function(__FUNCTION__,'1.5.0','function()');
/*
 @since 0.71
 * @deprecated 0.71
 * @deprecated use get_the_category_by_ID()
 * @see get_the_category_by_ID()
*/


// theme-meta.php
/**
 * mdw_wp_theme_meta function.
 *
 * adds default theme meta to header
 * hooks directly after meta robots
 *
 * @access public
 * @return void
 */
function mdw_wp_theme_meta() {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_meta()');

	echo apply_filters('mdw_wp_meta_charset', '<meta charset="'.get_bloginfo( 'charset' ).'" />'."\n");
	echo apply_filters('mdw_wp_meta_http-equiv', '<meta http-equiv="X-UA-Compatible" content="IE=edge">'."\n");
	echo apply_filters('mdw_wp_meta_viewport', '<meta name="viewport" content="width=device-width, initial-scale=1.0">'."\n");
	echo apply_filters('mdw_wp_meta_description', '<meta name="description" content="'.display_meta_description().'">'."\n");
	echo apply_filters('mdw_wp_meta_author', '<meta name="author" content="">'."\n");

}

/**
 * mdw_wp_theme_disable_seo_meta function.
 *
 * checks for Yoast SEO and removes description meta
 * fires on 0 so that's it's before our meta
 *
 * @access public
 * @return void
 */
function mdw_wp_theme_disable_seo_meta() {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_disable_seo_meta()');

	if ( defined('WPSEO_VERSION') ) :
		add_filter('mdw_wp_meta_description', 'disable_mdw_wp_meta_description', 10, 1);
	endif;
}

/**
 * disable_mdw_wp_meta_description function.
 *
 * simply returns a null value so no description is output
 *
 * @access public
 * @param mixed $meta
 * @return null
 */
function disable_mdw_wp_meta_description($meta) {
	_deprecated_function(__FUNCTION__,'1.5.0','disable_mdw_meta_description()');

	return null;
}

// functions.php


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Modded utalizing Twenty Fifteen for latest standards.
 *
 * @since MDW Theme 1.1.9
 */
function mdw_wp_theme_setup() {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_setup()');

	/**
	 * add our theme support options
	 */
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('menus');
	add_theme_support('title-tag');

	/**
	 * add our image size(s)
	 */
	add_image_size('navbar-logo', 163, 100, true);

	/**
	 * include legacy functions
	 */
	include_once(get_template_directory().'/inc/legacy.php');

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

/**
 * Register widget area.
 *
 * @since MDW Theme 1.0.0
 */
function mdw_wp_theme_widgets_init() {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_widgets_init()');

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

/**
 * Enqueue scripts and styles.
 *
 * @since MDW Theme 1.1.9
 */
function mdw_wp_theme_scripts() {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_scripts()');

	$theme_options=array();
	$load_slider_scripts=false;

	if (class_exists('MDWWPThemeOptions')) :
		$mdw_wp_theme_options=new MDWWPThemeOptions();
		$theme_options=get_option($mdw_wp_theme_options->option_name);
	endif;

	// font awesome
	wp_enqueue_style('font-awesome-style',get_template_directory_uri().'/inc/css/font-awesome.min.css',array(),'4.2.0');

	// Load our main stylesheet.
	wp_enqueue_style( 'mdw-wp-theme-style', get_stylesheet_uri() );

	// enqueue our scripts for bootstrap, slider and theme
	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap',get_template_directory_uri().'/inc/js/bootstrap.min.js',array('jquery'),'3.3.2',true);
	wp_enqueue_script('jquery-actual-script',get_template_directory_uri().'/inc/js/jquery.actual.min.js',array('jquery'),'1.0.16',true);

	wp_enqueue_script('mdw-theme-script',get_template_directory_uri().'/inc/js/mdw-theme.js',array('jquery'),'1.2.0',true);

	// utalize theme options to setup our custom slider //
	if (has_page_background()) :
		$load_slider_scripts=true;
	elseif (isset($theme_options['bg_slider']['active']) && $theme_options['bg_slider']['active']) :
		$load_slider_scripts=true;
	endif;

	if ($load_slider_scripts) :

		wp_enqueue_style('background-slider-style',get_template_directory_uri().'/inc/css/background-slider.css',array(),'1.0.0');

		wp_enqueue_script('avia-fullscreen-slider',get_template_directory_uri().'/inc/js/aviaFullscreenSlider.js',array('jquery'));
		wp_enqueue_script('avia-fullscreen-slider-custom',get_template_directory_uri().'/inc/js/aviaSliderCustom.js',array('avia-fullscreen-slider'),'1.0.0',true);

		wp_localize_script('avia-fullscreen-slider-custom','options',$theme_options['bg_slider']['options']);
	endif;

	if ( is_singular() ) :
		wp_enqueue_script( 'comment-reply' );
	endif;

}

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
function mdw_wp_theme_post_thumbnail($size='full') {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_post_thumbnail()');

	// this was removed in 1.6.0 //
	//if (has_page_background())
		//return false;

	$attr=array(
		'class' => 'img-responsive'
	);

	if ( post_password_required() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

		<div class="post-thumbnail">
			<?php the_post_thumbnail($size,$attr);	?>
		</div>

	<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail($size,$attr);	?>
		</a>

	<?php endif; // End is_singular()
}

/**
 * Find out if blog has more than one category.
 *
 * @since MDW Theme 1.0
 * @based on twentyfourteen ----- DOESNT WORK
 *
 * @return boolean true if blog has more than 1 category
 */
function bootstrap_categorized_blog() {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_categorized_blog()');

	if ( false === ( $all_the_cool_cats = get_transient( 'wpbootstrap_category_count' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'wpbootstrap_category_count', $all_the_cool_cats );
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
function bootstrap_posted_on() {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_posted_on()');

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
function bootstrap_paging_nav() {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_paging_nav()');

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
function bootstrap_post_nav() {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_post_nav()');

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
 * mdw_wp_theme_navbar_brand function.
 *
 * adds our logo or text based on theme options
 *
 * @access public
 * @return void
 */
function mdw_wp_theme_navbar_brand() {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_navbar_brand()');

	$html=null;
	$theme_options=array();
	$url=site_url();
	$logo=false;
	$text=get_bloginfo('name');
	$attachment_id=false;

	if (class_exists('MDWWPThemeOptions'))
		$theme_options=new MDWWPThemeOptions();

	if (isset($theme_options->options['logo']['image']) && $theme_options->options['logo']['image']!='')
		$attachment_id=$theme_options->get_image_id_from_url($theme_options->options['logo']['image']);

	if ($attachment_id)
		$logo=wp_get_attachment_image($attachment_id, 'navbar-logo', false, array('class' => 'img-responsive'));

	if (isset($theme_options->options['logo']['text']) && $theme_options->options['logo']['text']!='')
		$text=$theme_options->options['logo']['text'];

	if ($logo) :
		$html.='<a class="navbar-brand logo" href="'.$url.'">'.$logo.'</a>';
	else :
		$html.='<a class="navbar-brand" href="'.$url.'">'.$text.'</a>';
	endif;

	echo $html;
}

/**
 * mdw_wp_theme_special_nav_classes function.
 *
 * allows us to add more specific classes to the wp nav menu
 * more specifically, we can add a logo class depending on theme options
 *
 * @access public
 * @param mixed $args
 * @return void
 */
function mdw_wp_theme_special_nav_classes($args) {
	_deprecated_function(__FUNCTION__,'1.5.0','mdw_theme_special_nav_classes()');

	$theme_options=array();

	if (class_exists('MDWWPThemeOptions'))
		$theme_options=new MDWWPThemeOptions();

	if (isset($theme_options->options['logo']['image']) && $theme_options->options['logo']['image']!='')
		$args['menu_class'].=' logo';

	return $args;
}
?>
