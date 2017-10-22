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
		
			<div class="container">
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

	<?php endwhile; ?>
	
<?php get_footer(); ?>