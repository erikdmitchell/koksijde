<?php if (koksijde_slider_show_captions()) : ?>

	<div class="carousel-caption">
		<div class="caption-text"><?php koksijde_slider_get_caption(); ?></div>

		<?php if (koksijde_slider_show_more()) : ?>
			<p><a class="btn btn-primary btn-lg" role="button"><?php koksijde_slider_show_more_text(); ?></a></p>
		<?php endif; ?>
	</div>
	
<?php endif; ?>