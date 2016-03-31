<?php
/**
 * Template Name: Front Page
**/
?>
<?php get_header(); ?>

	<?php koksijde_slider(); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php while (have_posts()) : the_post(); ?>
					<h2><?php the_title(); ?></h2>
					<?php
					if (has_post_thumbnail()) :
						the_post_thumbnail('thumbnail');
					endif;
					?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>
		</div><!-- .row -->
	</div><!-- .container -->

<?php get_footer(); ?>