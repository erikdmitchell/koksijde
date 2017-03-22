<?php
/**
 * The template for displaying the slider
 *
 * @subpackage koksijde
 * @since koksijde 1.0.0
 */
?>

<?php if (koksijde_home_slider_is_active()) : ?>
	<div id="koksijde-home-slider" class="carousel slide koksijde-slider" data-ride="carousel">
		<?php get_template_part('template-parts/home-slider/slider', 'indicators'); ?>
		<?php get_template_part('template-parts/home-slider/slider', 'slides'); ?>		
		<?php get_template_part('template-parts/home-slider/slider', 'controls'); ?>	
	</div>
<?php endif; ?>