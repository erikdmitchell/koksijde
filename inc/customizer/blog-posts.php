<?php

/**
 * koksijde_home_blog_posts_is_active function.
 * 
 * @access public
 * @return void
 */
function koksijde_home_blog_posts_is_active() {
	if (get_theme_mod('blog_posts_active', 0))
		return true;
		
	return false;
}

/**
 * koksijde_home_blog_posts function.
 * 
 * @access public
 * @return void
 */
function koksijde_home_blog_posts() {
	$posts=get_posts(array(
		'posts_per_page' => get_theme_mod('blog_posts_limit', 6),
		'post_type' => get_theme_mod('blog_posts_post_type', 'post'),
		'ignore_sticky_posts' => 1,
	));

	return $posts;
}
	
?>