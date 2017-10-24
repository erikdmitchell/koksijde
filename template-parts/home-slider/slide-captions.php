<?php if (get_theme_mod('slider_captions', 0)) : ?>

	<div class="carousel-caption">
		<div class="caption-text"><?php echo apply_filters('the_content', koksijde_slider_get_caption($post)); ?></div>

	<?php if (get_theme_mod('slider_more_button', 0)) : ?>
		<p><a class="btn btn-primary btn-lg" role="button"><?php echo esc_html(get_theme_mod('slider_read_more_text', '')); ?></a></p>
	<?php endif; ?>
	</div>
	
<?php endif; ?>