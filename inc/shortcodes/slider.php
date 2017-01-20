<?php

/**
 * koksijde_slider_shortcode function.
 * 
 * @access public
 * @param mixed $atts
 * @return void
 */
function koksijde_slider_shortcode($atts) {
	$atts = shortcode_atts( array(
		'foo' => 'no foo',
		'baz' => 'default baz'
	), $atts, 'bartag' );
	
	ob_start();
    
    get_template_part('template-parts/shortcode', 'slider');
    
    return ob_get_clean();
}
add_shortcode('koksijde_slider', 'koksijde_slider_shortcode');

/**/

global $koksijde_gallery_query;
global $koksijde_gallery_slide;

class Koksijde_Gallery {

	public $slides;

	public $query;

	public $query_vars;

	public $current_post=-1;

	public $post_count=0;

	public $slide;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @param string $query (default: '')
	 * @return void
	 */
	public function __construct($query='') {
		global $koksijde_gallery_query;

		if (!empty($query))
			$koksijde_gallery_query=$this->query($query);
	}

	/**
	 * default_query_vars function.
	 *
	 * contains all our default query vars
	 *
	 * @access public
	 * @return void
	 */
	public function default_query_vars() {
		$array=array(
			'post_type' => 'post',
			'limit' => -1,
			'indicators' => true,
			'slides' => true,
			'captions' => true,
			'caption_field' => 'excerpt',
			'more' => true,
			'more_text' => 'More',
			'controls' => true,
		);

		return $array;
	}

	/**
	 * set_query_vars function.
	 *
	 * utalizes our query to setup our query vars
	 *
	 * @access public
	 * @param string $query (default: '')
	 * @return void
	 */
	public function set_query_vars($query='') {
		$args=wp_parse_args($query, $this->default_query_vars());

		return $args;
	}

	/**
	 * query function.
	 *
	 * @access public
	 * @param string $query (default: '')
	 * @return void
	 */
	public function query($query='') {
		global $wpdb;

		$limit='';
		$where='';
		$order='';
		$meta='';
		$select='';

		$this->query_vars=$this->set_query_vars($query);
		$q=$this->query_vars;

		// get posts ??? //

		$this->get_posts();

		return $this;
	}

	/**
	 * get_posts function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_posts() {
		global $wpdb;

		$posts=$wpdb->get_results($this->query);

		// set total number of posts found //
		$this->found_posts = $wpdb->get_var('SELECT FOUND_ROWS()');

		$this->posts=$posts;
		$this->post_count=count($posts);

		return $this->posts;
	}

	/**
	 * have_posts function.
	 *
	 * @access public
	 * @return void
	 */
	public function have_posts() {
		if ($this->current_post + 1 < $this->post_count) :
			return true;
		elseif ( $this->current_post + 1 == $this->post_count && $this->post_count > 0 ) :
			$this->rewind_posts();
		endif;

		return false;
	}

	/**
	 * the_post function.
	 *
	 * @access public
	 * @return void
	 */
	public function the_post() {
		global $uci_results_post;

		$uci_results_post = $this->next_post();
	}

  /**
   * next_post function.
   *
   * @access public
   * @return void
   */
  public function next_post() {
		$this->current_post++;

		$this->post = $this->posts[$this->current_post];

		return $this->post;
	}

	/**
	 * rewind_posts function.
	 *
	 * @access public
	 * @return void
	 */
	public function rewind_posts() {
		$this->current_post = -1;

		if ( $this->post_count > 0 )
			$this->post = $this->posts[0];
	}

}



/*-----------------//-----------------//-----------------*/

/**
 * koksijde_slider_is_active function.
 * 
 * @access public
 * @return void
 */
function koksijde_home_slider_is_active() {
	if (get_theme_mod('home_slider_active', 0))
		return true;
		
	return false;
}


/**
 * koksijde_add_slider_image_sizes function.
 *
 * @access public
 * @return void
 */
function koksijde_add_slider_image_sizes() {
	add_image_size('koksijde-theme-slider', 1400, 500, true);
}
add_action('init', 'koksijde_add_slider_image_sizes');

/**
 * koksijde_get_home_slider_slides function.
 * 
 * @access public
 * @return void
 */
function koksijde_get_home_slider_slides() {
	// post args //
	$args=array(
		'posts_per_page' => get_theme_mod('home_slider_limit', -1),
		'post_type' => get_theme_mod('home_slider_post_type', 'post'),
	);

	// get posts (slides) //
	$slides=get_posts($args);
	
	return $slides;	
}

/**
 * koksijde_home_slider_slide_classes function.
 * 
 * @access public
 * @return void
 */
function koksijde_home_slider_slide_classes() {
	global $slide_counter;
	
	$classes=array('item');
	
	if ($slide_counter==0)
		$classes[]='active';
	
	$classes=apply_filters('', $classes);
	
	$slide_counter++;
	
	echo implode(' ', $classes);
}

/**
 * koksijde_home_slider_slide_icon_classes function.
 * 
 * @access public
 * @return void
 */
function koksijde_home_slider_slide_icon_classes() {
	global $slide_icon_counter;
	
	$classes=array();
	
	if ($slide_icon_counter==0)
		$classes[]='active';
	
	$classes=apply_filters('', $classes);
	
	$slide_icon_counter++;
	
	echo implode(' ', $classes);
}

function koksijde_home_slider_slide_icon_counter() {
	global $slide_icon_counter;
	
	echo $slide_icon_counter;
}

/**
 * koksijde_slider_get_caption function.
 *
 * @access public
 * @param bool $post (default: false)
 * @return void
 */
function koksijde_slider_get_caption($post=false) {
	global $koksijde_slider_config;

	$html=null;

	if (!$post)
		return false;

	switch ($koksijde_slider_config['caption_field']):
		case 'excerpt' :
			$html.=$post->post_excerpt;
			break;
		case 'content' :
			$html.=$post->post_content;
			break;
		case 'title' :
			$html.=$post->post_title;
			break;
		default:
			$html.=$post->post_excerpt;
			break;
	endswitch;

	return apply_filters('koksijde_slider_caption', $html, $post);
}

/**
 * koksijde_slider_thumbnail function.
 *
 * this is a knock off of the get_post_thumbnail WP function
 * we rework it so we can hijack the width to make the images 100% wide
 * we alos add some classes such as img-responsive for better theme integration
 *
 * @access public
 * @param mixed $post_id
 * @return void
 */
function koksijde_slider_thumbnail($post_id) {
	global $koksijde_slider_config;

	$image=null;
	$attr=null;
	$class=array();
	$image_size=apply_filters('koksijde-slider-image-size', 'koksijde-theme-slider');
	$post_thumbnail_id=get_post_thumbnail_id($post_id);
	$post_thumbnail_image_src=wp_get_attachment_image_src($post_thumbnail_id, $image_size, false);
	$attachment=get_post($post_thumbnail_id);

	// get size class //
	$size_class=$image_size;
	if (is_array($size_class)) :
		$size_class=join('x', $size_class);
	endif;

	$classes['attachment-size']='attachment-'.$size_class;
	$classes['img-responsive']='img-responsive';

	// setup out attributes //
	$default_attr = array(
		'src'   => $post_thumbnail_image_src,
		'class' => implode(' ',apply_filters('koksijde-slider-classes', $classes)),
		'alt'   => trim(strip_tags( get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true) )), // Use Alt field first
	);

	if ( empty($default_attr['alt']) )
		$default_attr['alt'] = trim(strip_tags( $attachment->post_excerpt )); // If not, Use the Caption

	if ( empty($default_attr['alt']) )
		$default_attr['alt'] = trim(strip_tags( $attachment->post_title )); // Finally, use the title

	$attr = wp_parse_args($attr, $default_attr);
	$width=apply_filters('koksijde-slider-image-width', $attr['src'][1]);
	$height=apply_filters('koksijde-slider-image-height', $attr['src'][2]);

	$image='<img width="'.$width.'" height="'.$height.'" src="'.$attr['src'][0].'" class="'.$attr['class'].'" alt="'.$attr['alt'].'">';

	echo apply_filters('koksijde_slider_thumbnail', $image, $attr, $width, $height);
}
?>
