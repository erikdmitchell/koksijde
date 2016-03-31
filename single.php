<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
					get_template_part('content');

					// Previous/next post navigation.
					koksijde_theme_post_nav();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div>
		<div class="col-md-4">

			<?php get_sidebar(); ?>

		</div>
	</div>
</div><!-- .container -->

<?php get_footer(); ?>