<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php koksijde_theme_post_thumbnail(); ?>
		</div>
	</div>
	<div class="row content">
		<div class="col-md-8">
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
		<div class="col-md-4">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div><!-- .container -->

<?php get_footer(); ?>