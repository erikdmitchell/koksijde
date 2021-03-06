<?php
/**
 * Template Name: Front Page
 *
 * @subpackage koksijde
 * @since koksijde 1.0.0
 */
?>
<?php get_header(); ?>

	<?php get_template_part('template-parts/home', 'slider'); ?>

	<?php while (have_posts()) : the_post(); ?>
	
		<?php if (!koksijde_home_slider_is_active() && has_post_thumbnail()) : ?>
		
			<div class="container-full home-featured-image">
				<?php koksijde_home_image(); ?>
			</div>
			
		<?php endif; ?>

		<?php if (koksijde_display_home_content()) : ?>
		
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		
		<?php endif; ?>
		
		<?php if (koksijde_home_blog_posts_is_active()) : ?>
		
			<div class="container">
				<div class="row eq-height">
					<?php foreach (koksijde_home_blog_posts() as $post) : ?>
						<div class="col-xs-12 col-sm-6 blog-post">
							<h2><?php echo get_the_title($post->ID); ?></h2>
							<div class="blog-post-thumbnail">
								<?php echo get_the_post_thumbnail($post->ID, 'koksijde-home-blog-post-image'); ?>
							</div>
							<div class="blog-post-excerpt">
								<?php echo koksijde_get_excerpt_by_id($post->ID, 40, '', '<a href="'.get_permalink($post->ID).'">...more</a>'); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">More posts</a>
					</div>
				</div>
			</div>
		
		<?php endif; ?>

	<?php endwhile; ?>
	
<?php get_footer(); ?>