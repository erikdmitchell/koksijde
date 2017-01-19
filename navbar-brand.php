<div class="koksijde-header-image">
	<?php koksijde_header_markup(); ?>
</div>

<?php if (display_header_text()) : ?>
	<a class="navbar-brand" href="<?php home_url(); ?>"><?php bloginfo('name'); ?></a>

	<?php $description = get_bloginfo( 'description', 'display' ); ?>
	<?php if ( $description || is_customize_preview() ) : ?>
		<p class="site-description"><?php echo $description; ?></p>
	<?php endif; ?>

<?php endif; ?>