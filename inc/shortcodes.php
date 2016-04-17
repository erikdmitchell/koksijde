<?php
function koksijde_recent_posts_shortcode($atts) {
	$atts = shortcode_atts( array(
		'posts_per_page' => 3,
		'cols' => 3,
		'excerpt_length' => 75,
	), $atts, 'koksijde-recent-posts' );

	return koksijde_recent_posts($atts);
}
add_shortcode('koksijde-recent-posts', 'koksijde_recent_posts_shortcode');

function koksijde_recent_posts($args=array()) {
	$html=null;
	$default_args=array(
		'posts_per_page' => 3,
		'cols' => 3,
		'excerpt_length' => 75,
		'thumb_size' => 'post-thumbnail',
	);
	$args=wp_parse_args($args, $default_args);

	extract($args);

	$posts=get_posts(array(
		'posts_per_page' => $posts_per_page,
	));

	if (!count($posts))
		return false;

	$html.='<div class="koksijde-recent-posts">';
		$html.='<div class="row">';
			foreach ($posts as $post) :
				$thumb_classes=array(
					'attachment-'.$thumb_size,
					'size-'.$thumb_size,
					'wp-post-image',
					'img-responsive'
				);
				$thumb_classes=apply_filters('koksijde_recent_posts_thumb_classes', $thumb_classes, $thumb_size);

				$html.='<div id="post-'.$post->ID.'" class="col-md-4 recent-post">';
					if (has_post_thumbnail($post->ID))
						$html.='<a href="'.get_permalink($post->ID).'">'.get_the_post_thumbnail($post->ID, $thumb_size, implode(' ', $thumb_classes)).'</a>';

					$html.='<h3><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h3>';
					$html.=koksijde_get_excerpt_by_id($post, $excerpt_length, '', ' ...<a href="'.get_permalink($post->ID).'">more</a>');
				$html.='</div>';
			endforeach;
		$html.='</div>';
	$html.='</div>';

	return $html;
}
?>