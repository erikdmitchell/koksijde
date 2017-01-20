<?php
/**
 * koksijde_slider_shortcode function.
 * 
 * @access public
 * @param mixed $atts
 * @return void
 */
function koksijde_slider_shortcode($atts) {
	global $koksijde_gallery, $koksijde_gallery_slide;
	
	$atts = shortcode_atts( array(
		'id' => 'koksijde-slider',
		'post_type' => 'post',
		'limit' => 4,
		'indicators' => true,
		'slides' => true,
		'captions' => true,
		'caption_field' => 'content',
		'more' => true,
		'more_text' => 'More',
		'controls' => true,
	), $atts, 'koksijde_slider');
	
	ob_start();
    
	$koksijde_gallery=new Koksijde_Gallery($atts);

	include(locate_template('template-parts/shortcode-slider.php'));  // Replace your template file name with "your-template-file-name.php"
    
    return ob_get_clean();
}
add_shortcode('koksijde_slider', 'koksijde_slider_shortcode');

/**/
global $koksijde_gallery;
global $koksijde_gallery_slide;

class Koksijde_Gallery {

	public $slides;

	public $query_vars;

	public $current_slide=-1;

	public $slide_count=0;

	public $slide;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @param string $query (default: '')
	 * @return void
	 */
	public function __construct($query='') {
		$this->query($query);
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
			'id' => 'koksijde-slider',
			'post_type' => 'post',
			'limit' => 4,
			'indicators' => true,
			'slides' => true,
			'captions' => true,
			'caption_field' => 'content',
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
		$this->query_vars=$this->set_query_vars($query);

		$this->get_slides();

		return $this;
	}

	/**
	 * get_slides function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_slides() {
		$posts=get_posts(array(
			'posts_per_page' => $this->query_vars['limit'],
			'post_type' => $this->query_vars['post_type'],			
		));

		$this->slides=$posts;
		$this->slide_count=count($posts);

		return $this->slides;
	}

	/**
	 * have_slides function.
	 *
	 * @access public
	 * @return void
	 */
	public function have_slides() {
		if ($this->current_slide + 1 < $this->slide_count) :
			return true;
		elseif ( $this->current_slide + 1 == $this->slide_count && $this->slide_count > 0 ) :
			$this->rewind_slides();
		endif;

		return false;
	}

	/**
	 * the_slide function.
	 *
	 * @access public
	 * @return void
	 */
	public function the_slide() {
		global $koksijde_gallery_slide;

		$koksijde_gallery_slide=$this->next_slide();
	}

  /**
   * next_slide function.
   *
   * @access public
   * @return void
   */
  public function next_slide() {
		$this->current_slide++;

		$this->slide=$this->slides[$this->current_slide];
		$this->slide->number=$this->current_slide;

		return $this->slide;
	}

	/**
	 * rewind_slides function.
	 *
	 * @access public
	 * @return void
	 */
	public function rewind_slides() {
		$this->current_slide = -1;

		if ( $this->slide_count > 0 )
			$this->slide = $this->slides[0];
	}

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
 * koksijde_slider_slide_class function.
 * 
 * @access public
 * @param string $class (default: '')
 * @return void
 */
function koksijde_slider_slide_class($class='') {
	global $koksijde_gallery_slide;
	
	$classes=array('item');
	
	if ($koksijde_gallery_slide->number==0)
		$classes[]='active';
		
	echo apply_filters('koksijde_slider_slide_class', implode(' ', $classes), $classes);
}

/**
 * koksijde_slider_show_captions function.
 * 
 * @access public
 * @return void
 */
function koksijde_slider_show_captions() {
	global $koksijde_gallery;

	if ($koksijde_gallery->query_vars['captions'])
		return true;
		
	return false;
}

/**
 * koksijde_slider_get_caption function.
 * 
 * @access public
 * @return void
 */
function koksijde_slider_get_caption() {
	global $koksijde_gallery, $koksijde_gallery_slide;

	$html=null;

	if (!$koksijde_gallery_slide)
		return false;

	switch ($koksijde_gallery->query_vars['caption_field']):
		case 'excerpt' :
			$html.=$koksijde_gallery_slide->post_excerpt;
			break;
		case 'content' :
			$html.=$koksijde_gallery_slide->post_content;
			break;
		case 'title' :
			$html.=$koksijde_gallery_slide->post_title;
			break;
		default:
			$html.=$koksijde_gallery_slide->post_excerpt;
			break;
	endswitch;
	
	$html=apply_filters('the_content', $html);
	
	echo apply_filters('koksijde_slider_caption', $html, $koksijde_gallery_slide);
}

/**
 * koksijde_slider_show_more function.
 * 
 * @access public
 * @return void
 */
function koksijde_slider_show_more() {
	global $koksijde_gallery;

	if ($koksijde_gallery->query_vars['more'])
		return true;
		
	return false;
}

/**
 * koksijde_slider_show_more_text function.
 * 
 * @access public
 * @return void
 */
function koksijde_slider_show_more_text() {
	global $koksijde_gallery;

	echo $koksijde_gallery->query_vars['more_text'];
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

/**
 * koksijde_slider_slide_icon_counter function.
 * 
 * @access public
 * @return void
 */
function koksijde_slider_slide_icon_counter() {
	global $koksijde_gallery_slide;

	echo $koksijde_gallery_slide->number;
}

/**
 * koksijde_slider_slide_icon_classes function.
 * 
 * @access public
 * @param string $class (default: '')
 * @return void
 */
function koksijde_slider_slide_icon_classes($class='') {
	global $koksijde_gallery_slide;
	
	$classes=array('');
	
	if ($koksijde_gallery_slide->number==0)
		$classes[]='active';
		
	echo apply_filters('koksijde_slider_slide_icon_classes', implode(' ', $classes), $classes);
}

function koksijde_slider_id() {
	global $koksijde_gallery;

	echo $koksijde_gallery->query_vars['id'];
}
?>