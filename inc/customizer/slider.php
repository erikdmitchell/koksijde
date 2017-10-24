<?php
global $slide_counter;
global $slide_icon_counter;

$slide_counter=0;
$slide_icon_counter=0;

/**
 * koksijde_home_slider_is_active function.
 * 
 * @access public
 * @return void
 */
function koksijde_home_slider_is_active() {
	if (get_theme_mod('slider_active', 0))
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
add_action('after_setup_theme', 'koksijde_add_slider_image_sizes');

/**
 * koksijde_get_home_slider_slides function.
 * 
 * @access public
 * @return void
 */
function koksijde_get_home_slider_slides() {
	// post args //
	$args=array(
		'posts_per_page' => get_theme_mod('slider_limit', -1),
		'post_type' => get_theme_mod('home_slider_post_type', 'post'),
		'meta_query' => array( 
        	array(
            	'key' => '_thumbnail_id'
			) 
		),
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
	
	$classes=apply_filters('koksijde_home_slider_slide_classes', $classes);
	
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
	
	$classes=apply_filters('koksijde_home_slider_slide_icon_classes', $classes);
	
	$slide_icon_counter++;
	
	echo implode(' ', $classes);
}

/**
 * koksijde_home_slider_slide_icon_counter function.
 * 
 * @access public
 * @return void
 */
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
	//global $koksijde_slider_config;

	$html=null;

	if (!$post)
		return false;

	switch (get_theme_mod('slider_caption_field', 'excerpt')):
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
	$image_size=apply_filters('koksijde_slider_image_size', 'koksijde-theme-slider');
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
		'class' => implode(' ',apply_filters('koksijde_slider_classes', $classes)),
		'alt'   => trim(strip_tags( get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true) )), // Use Alt field first
	);

	if ( empty($default_attr['alt']) )
		$default_attr['alt'] = trim(strip_tags( $attachment->post_excerpt )); // If not, Use the Caption

	if ( empty($default_attr['alt']) )
		$default_attr['alt'] = trim(strip_tags( $attachment->post_title )); // Finally, use the title

	$attr = wp_parse_args($attr, $default_attr);
	$width=apply_filters('koksijde_slider_image_width', $attr['src'][1]);
	$height=apply_filters('koksijde_slider_image_height', $attr['src'][2]);
	
	if (isset($attr['src'][0]))	:
		$image='<img width="'.$width.'" height="'.$height.'" src="'.$attr['src'][0].'" class="'.$attr['class'].'" alt="'.$attr['alt'].'">';
	else :
		$image='';
	endif;

	echo apply_filters('koksijde_slider_thumbnail', $image, $attr, $width, $height);
}

function koksijde_show_indicators() {
	if (get_theme_mod('slider_indicators', 1))
		return true;
		
	return false;
}
?>
