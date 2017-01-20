<div class="carousel-inner">
	<?php foreach (koksijde_get_home_slider_slides() as $slide) : ?>

		<div class="<?php koksijde_home_slider_slide_classes(); ?>">
			<?php koksijde_slider_thumbnail($slide->ID); ?>
			<?php get_template_part('template-parts/home-slider/slide', 'captions'); ?>
		</div>

	<?php endforeach; ?>
</div>