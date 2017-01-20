<?php
/**
 * The template for displaying the slider
 *
 * @package WordPress
 * @subpackage koksijde
 * @since koksijde 1.0.2
 */
?>

<div id="koksijde-home-slider" class="carousel slide koksijde-slider" data-ride="carousel">
	<?php //get_template_part('template-parts/home-slider/slider', 'indicators'); ?>
	<?php //get_template_part('template-parts/home-slider/slider', 'slides'); ?>		
	
	<div class="carousel-inner">
		
		<?php if ($koksijde_gallery->have_slides()) : while ($koksijde_gallery->have_slides()) : $koksijde_gallery->the_slide(); ?>
			<div class="<?php koksijde_gallery_slide_class(); ?>">
				
				<?php //koksijde_slider_thumbnail($slide->ID); ?>
				<?php //get_template_part('template-parts/home-slider/slide', 'captions'); ?>
			</div>

		<?php endwhile; endif; ?>
		

	
	

	</div>
	
	<?php //get_template_part('template-parts/home-slider/slider', 'controls'); ?>	
</div>