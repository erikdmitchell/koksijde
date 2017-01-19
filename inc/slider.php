<?php
global $koksijde_slider_config;

/**
 * koksijde_slider_config function.
 *
 * @access public
 * @return void
 */
function koksijde_slider_config() {
	global $koksijde_slider_config, $koksijde_theme_options;

	$theme_options_config=array();
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
		'controls' => true,
		'posts' => array(),
		'image_size_name' => 'koksijde-theme-slider'
	);

	// check that we have theme options and slider is active //
	if (isset($koksijde_theme_options['default']['home_slider']) && $koksijde_theme_options['default']['home_slider']['active'])
		$theme_options_config=$koksijde_theme_options['default']['home_slider'];

	// set global variable //
	$koksijde_slider_config=wp_parse_args($theme_options_config, $default_config);

	// post args //
	$args=array(
		'posts_per_page' => $koksijde_slider_config['limit'],
		'post_type' => $koksijde_slider_config['post_type'],
	);

	// get posts (slides) //
	$koksijde_slider_config['posts']=get_posts($args);
}
add_action('wp', 'koksijde_slider_config');

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
	$image_size=apply_filters('koksijde-slider-image-size', $koksijde_slider_config['image_size_name']);
	$post_thumbnail_id=get_post_thumbnail_id($post_id);
	$post_thumbnail_image_src=wp_get_attachment_image_src($post_thumbnail_id, $image_size, false);
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
	$width=apply_filters('koksijde-slider-image-width', $attr['src'][1]);
	$height=apply_filters('koksijde-slider-image-height', $attr['src'][2]);

	$image='<img width="'.$width.'" height="'.$height.'" src="'.$attr['src'][0].'" class="'.$attr['class'].'" alt="'.$attr['alt'].'">';

	return apply_filters('koksijde_slider_thumbnail', $image, $attr, $width, $height);
}
?>
