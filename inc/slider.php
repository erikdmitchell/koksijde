<?php
/**
 * koksijdeSlider class.
 */
class koksijdeSlider {

	public $version='0.1.0';
	public $image_width=1400;
	public $image_height=500;
	public $image_size_name='koksijde_theme_slider';
	public $config=array();

	private $posts=null;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @param array $config (default: array())
	 * @return void
	 */
	public function __construct($config=array()) {
		$old_config=array_filter($config);

		if (!empty($old_config))
			$this->setup_slider($old_config);

		add_action('init', array($this,'add_slider_image_sizes'));
	}

	/**
	 * setup_slider function.
	 *
	 * @access public
	 * @param array $config (default: array())
	 * @param bool $use_theme_options (default: true)
	 * @return void
	 */
	public function setup_slider($config=array(),$use_theme_options=true) {
		global $koksijde_theme_options;

		$theme_options_config=array();

		if (isset($koksijde_theme_options['default']['home_slider']) && $koksijde_theme_options['default']['home_slider']['active'] && $use_theme_options)
			$theme_options_config=$koksijde_theme_options['default']['home_slider'];

		$default_config=array(
			'slider_id' => 'slider-id',
			'post_type' => 'posts',
			'limit' => -1,
			'indicators' => true,
			'slides' => true,
			'captions' => false,
			'caption_field' => 'excerpt',
			'more_button' => true,
			'more_text' => 'Read More',
			'controls' => true
		);

		$default_config_plus_theme_options=array_merge($default_config,$theme_options_config);
		$this->config=array_merge($default_config_plus_theme_options,$config);

		$args=array(
			'posts_per_page' => $this->config['limit'],
			'post_type' => $this->config['post_type'],
		);

		$this->posts=get_posts($args);

		return $this->build_slider();
	}

	/**
	 * build_slider function.
	 *
	 * @access public
	 * @return void
	 */
	public function build_slider() {
		$html=null;

		$html.='<div id="'.$this->config['slider_id'].'" class="carousel slide mdw-wp-slider" data-ride="carousel">';
			$html.=$this->generate_indicators();
			$html.=$this->generate_slides($this->config['captions']);
			$html.=$this->generate_controls();
		$html.='</div>';

		return $html;
	}

	/**
	 * generate_indicators function.
	 *
	 * @access public
	 * @return void
	 */
	public function generate_indicators() {
		if (!count($this->posts) || !$this->config['indicators'])
			return false;

		$html=null;
		$counter=0;

		$html.='<ol class="carousel-indicators">';
			foreach ($this->posts as $post) :
				if ($counter==0) :
					$class='active';
				else :
					$class=null;
				endif;

				$html.='<li data-target="#'.$this->config['slider_id'].'" data-slide-to="'.$counter.'" class="'.$class.'"></li>';

			  $counter++;
		  endforeach;
		$html.='</ol>';

		return $html;
	}

	/**
	 * generate_slides function.
	 *
	 * @access public
	 * @param bool $captions (default: false)
	 * @return void
	 */
	public function generate_slides($captions=false) {
		if (!count($this->posts))
			return false;

		$html=null;
		$counter=0;

		$html.='<div class="carousel-inner">';
			foreach ($this->posts as $post) :
				if ($counter==0) :
					$class='active';
				else :
					$class=null;
				endif;

				$html.='<div class="item '.$class.'">';
					$html.=$this->custom_slider_post_thumbnail($post->ID);
					if ($captions) :
						$html.='<div class="carousel-caption">';
							$html.='<div class="caption-text">'.apply_filters('the_content',$this->get_caption($post)).'</div>';
							if ($this->config['more_button'])
								$html.='<p><a class="btn btn-primary btn-lg" role="button">'.$this->config['more_text'].'</a></p>';
						$html.='</div>';
					endif;
				$html.='</div>';

				$counter++;
			endforeach;
		$html.='</div>';

		return $html;
	}

	/**
	 * generate_controls function.
	 *
	 * @access public
	 * @return void
	 */
	public function generate_controls() {
		if (!count($this->posts) || !$this->config['controls'])
			return false;

		$html=null;

		$html.='<a class="left carousel-control" href="#'.$this->config['slider_id'].'" data-slide="prev">';
			$html.='<span class="glyphicon glyphicon-chevron-left"></span>';
		$html.='</a>';
		$html.='<a class="right carousel-control" href="#'.$this->config['slider_id'].'" data-slide="next">';
			$html.='<span class="glyphicon glyphicon-chevron-right"></span>';
		$html.='</a>';

		return $html;
	}

	/**
	 * get_caption function.
	 *
	 * @access public
	 * @param bool $post (default: false)
	 * @return void
	 */
	public function get_caption($post=false) {
		$html=null;
		if (!$post)
			return false;

		switch ($this->config['caption_field']):
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

		return $html;
	}

	/**
	 * custom_slider_post_thumbnail function.
	 *
	 * this is a knock off of the get_post_thumbnail WP function
	 * we rework it so we can hijack the width to make the images 100% wide
	 * we alos add some classes such as img-responsive for better theme integration
	 *
	 * @access public
	 * @param mixed $post_id
	 * @return void
	 */
	public function custom_slider_post_thumbnail($post_id) {
		$image=null;
		$attr=null;
		$class=array();
		$image_size=apply_filters('koksijde-slider-image-size',$this->image_size_name);
		$post_thumbnail_id=get_post_thumbnail_id($post_id);
		$post_thumbnail_image_src=wp_get_attachment_image_src($post_thumbnail_id,$image_size,false);
		$attachment=get_post($post_thumbnail_id);

		// get size class //
    $size_class=$image_size;
		if (is_array($size_class)) :
			$size_class=join('x',$size_class);
		endif;

		$classes['attachment-size']='attachment-'.$size_class;
		$classes['img-responsive']='img-responsive';

		// setup out attributes //
		$default_attr = array(
			'src'   => $post_thumbnail_image_src,
			'class' => implode(' ',apply_filters('koksijde-slider-classes',$classes)),
			'alt'   => trim(strip_tags( get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true) )), // Use Alt field first
		);

		if ( empty($default_attr['alt']) )
			$default_attr['alt'] = trim(strip_tags( $attachment->post_excerpt )); // If not, Use the Caption

		if ( empty($default_attr['alt']) )
			$default_attr['alt'] = trim(strip_tags( $attachment->post_title )); // Finally, use the title

		$attr = wp_parse_args($attr, $default_attr);
		$width=apply_filters('koksijde-slider-image-width',$attr['src'][1]);
		$height=apply_filters('koksijde-slider-image-height',$attr['src'][2]);

		$image='<img width="'.$width.'" height="'.$height.'" src="'.$attr['src'][0].'" class="'.$attr['class'].'" alt="'.$attr['alt'].'">';

		return $image;
	}

}

/**
 * koksijde_slider function.
 *
 * @access public
 * @return void
 */
function koksijde_slider() {
	echo get_koksijde_slider();
}

/**
 * get_koksijde_slider function.
 *
 * @access public
 * @return void
 */
function get_koksijde_slider() {
	$koksijdeSlider=new koksijdeSlider();

	return $koksijdeSlider->setup_slider();
}
?>
