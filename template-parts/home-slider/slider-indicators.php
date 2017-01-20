<?php global $koksijde_gallery; ?>

<?php if ($koksijde_gallery->have_slides()) : ?>
	<ol class="carousel-indicators">
		<?php while ($koksijde_gallery->have_slides()) : $koksijde_gallery->the_slide(); ?>
			<li data-target="#<?php koksijde_slider_id(); ?>" data-slide-to="<?php koksijde_slider_slide_icon_counter(); ?>" class="<?php koksijde_slider_slide_icon_classes(); ?>"></li>
		<?php endwhile; ?>
	</ol>
<?php endif; ?>