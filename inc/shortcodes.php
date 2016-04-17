<?php
function koksijde_recent_posts_shortcode($atts) {
	$atts = shortcode_atts( array(
		'posts_per_page' => 3,
		'cols' => 3
	), $atts, 'koksijde-recent-posts' );

	return koksijde_recent_posts($atts);
}
add_shortcode('koksijde-recent-posts', 'koksijde_recent_posts_shortcode');

function koksijde_recent_posts($args=array()) {
	$html=null;
	$default_args=array(
		'posts_per_page' => 3,
		'cols' => 3,
	);
	$args=wp_parse_args($args, $default_args);

	extract($args);

	$posts=get_posts(array(
		'posts_per_page' => $posts_per_page,
	));

	if (!count($posts))
		return false;

	$html.='<div class="container koksijde-recent-posts">';
		$html.='<div class="row">';
			foreach ($posts as $post) :
				$html.='<div id="post-'.$post->ID.'" class="col-md-4 recent-post">';
					$html.='<h3>'.$post->post_title.'</h3>';
				$html.='</div>';
			endforeach;
		$html.='</div>';
	$html.='</div>';

	return $html;
}
?>