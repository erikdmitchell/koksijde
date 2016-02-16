<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage MDW Theme
 * @since MDW Theme 1.1.0
 */
?>
<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<h1 class="page-title"><?php _e( 'Not Found', 'mdw-theme' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<h2><?php _e( 'This is somewhat embarrassing, isn\'t it?', 'mdw-theme' ); ?></h2>
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'mdw-theme' ); ?></p>

					<?php get_search_form(); ?>
				</div><!-- .entry-content -->

			</article><!-- #post-## -->
		</div>
	</div>
</div>

<?php get_footer(); ?>