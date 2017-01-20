<div class="koksijde-header-wrap ">
	<?php koksijde_header_markup(); ?>
	
	<?php if (display_header_text()) : ?>
		<div class="koksijde-header-text">
			<a class="site-title" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
		
			<?php $description = get_bloginfo( 'description', 'display' ); ?>
			<?php if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>