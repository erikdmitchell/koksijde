		<footer>
			<div class="footer-widgets">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<?php dynamic_sidebar('footer-1'); ?>
						</div>
						<div class="col-md-4">
							<?php dynamic_sidebar('footer-2'); ?>
						</div>
						<div class="col-md-4">
							<?php dynamic_sidebar('footer-3'); ?>
						</div>
					</div>
				</div> <!-- /container -->
			</div><!-- .footer-widgets -->
			<div class="copyright">
				<?php echo get_bloginfo('name'); ?> <?php _e('&copy', 'koksijde'); ?> <?php echo date_i18n(esc_html__('Y', 'koksijde')); ?>
			</div>
		</footer>

		<?php wp_footer(); ?>
	</body>
</html>