<?php if (koksijde_show_indicators()) : ?>
	
	<ol class="carousel-indicators">

		<?php foreach (koksijde_get_home_slider_slides() as $slide) : ?>
			<li data-target="#koksijde-home-slider" data-slide-to="<?php koksijde_home_slider_slide_icon_counter(); ?>" class="<?php koksijde_home_slider_slide_icon_classes(); ?>"></li>
		<?php endforeach; ?>
	
	</ol>
	
<?php endif; ?>