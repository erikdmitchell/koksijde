<?php
/**
 * Template Name: Full Width (no sidebars)
**/
?>
<?php get_header(); ?>

<div class="container">
	<div class="row content">
		<div class="col-md-12">
			<?php koksijde_theme_post_thumbnail(); ?>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('content'); ?>
				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
				<!-- // Previous/next post navigation. NEEDS TO BE ADDED -->
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, this page does not exist.','koksijde'); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div><!-- .container -->

<?php get_footer(); ?>