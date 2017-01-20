<?php
/**
 * The template for displaying the slider
 *
 * @package WordPress
 * @subpackage koksijde
 * @since koksijde 1.0.2
 */
?>


<pre>
	<?php //print_r($koksijde_gallery); ?>
</pre>

<div id="koksijde-home-slider" class="carousel slide koksijde-slider" data-ride="carousel">
	<?php //get_template_part('template-parts/home-slider/slider', 'indicators'); ?>
	<?php //get_template_part('template-parts/home-slider/slider', 'slides'); ?>		
	
	<div class="carousel-inner">
		
		<?php //if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
		<?php //endwhile; endif; ?>
		
		<?php foreach (koksijde_get_home_slider_slides() as $slide) : ?>
	
			<div class="<?php koksijde_home_slider_slide_classes(); ?>">
				<?php koksijde_slider_thumbnail($slide->ID); ?>
				<?php get_template_part('template-parts/home-slider/slide', 'captions'); ?>
			</div>
	
		<?php endforeach; ?>
	</div>
	
	<?php //get_template_part('template-parts/home-slider/slider', 'controls'); ?>	
</div>