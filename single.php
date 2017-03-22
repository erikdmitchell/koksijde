<?php
/**
 * The template for displaying a single post
 *
 * @subpackage koksijde
 * @since koksijde 1.0.0
 */
?>

<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
					get_template_part('content');
					
					the_post_navigation( array(
						'prev_text' => '<span aria-hidden="true" class="nav-subtitle">' . __( 'Previous Post:', 'koksijde' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span aria-hidden="true" class="nav-subtitle">' . __( 'Next Post:', 'koksijde' ) . '</span> <span class="nav-title">%title</span>',
					) );					

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