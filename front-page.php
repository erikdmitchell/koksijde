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
				<div class="row">
					<div class="col-xs-12">
						<?php koksijde_home_image(); ?>
					</div>
				</div>
			</div>
			
		<?php endif; ?>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
		
		<?php if (koksijde_home_blog_posts_is_active()) : ?>
		
		<?php //$blog_posts=koksijde_home_blog_posts(); ?>
		
		<div class="container">
			<div class="row eq-height">
				<?php //while ($blog_posts->have_posts()) : $blog_posts->the_post(); ?>
				<?php foreach (koksijde_home_blog_posts() as $post) : ?>
					<div class="col-md-4 blog-post">
						<?php the_title('<h2>', '</h2>'); ?>
						<div class="blog-post-thumbnail">
							<?php the_post_thumbnail('koksijde-home-blog-post-image'); ?>
						</div>
						<div class="blog-post-excerpt">
							<?php echo koksijde_get_excerpt_by_id($post->ID, 10, '', '...'); ?>
						</div>
					</div>
				<?php endforeach; ?>
				<?php //endwhile; ?>
			</div>
		</div>
		
		<?php endif; ?>
		
		PERHAPS WE ADD AN OPTION TO NOT DISPLAY CONTENT (customizer)<br>

	<?php endwhile; ?>
	
<?php get_footer(); ?>