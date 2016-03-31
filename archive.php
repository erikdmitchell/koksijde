<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * @package WordPress
 * @subpackage koksijde
 * @since koksijde 1.3.0
 */
?>
<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<?php if ( have_posts() ) : ?>
				<header class="archive-header">
					<h1 class="archive-title"><?php
						if ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'koksijde' ), get_the_date() );
						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'koksijde' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'koksijde' ) ) );
						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'koksijde' ), get_the_date( _x( 'Y', 'yearly archives date format', 'koksijde' ) ) );
						else :
							_e( 'Archives', 'koksijde' );
						endif;
					?></h1>
				</header><!-- .archive-header -->

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part('content'); ?>
				<?php endwhile; ?>

				<?php koksijde_theme_paging_nav(); // Previous/next post navigation. ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		</div>
		<div class="col-md-4">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div><!-- .container -->

<?php get_footer(); ?>