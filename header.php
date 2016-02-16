<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

  <head>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
	    <script src="<?php echo get_template_directory_uri(); ?>/inc/js/html5shiv.min.js</script>
	    <script src="<?php echo get_template_directory_uri(); ?>/inc/js/respond.min.js</script>
    <![endif]-->

    <?php wp_head(); ?>

  </head>

  <body <?php body_class(); ?>>

		<div class="container-fluid primary-nav">
			<div class="container">
				<nav class="navbar navbar-default" role="navigation">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".mdw-wp-theme-mobile-menu">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<?php mdw_theme_navbar_brand(); ?>
					</div>
					<?php mdw_secondary_navigation_setup(); ?>
					<div class="collapse navbar-collapse primary-menu">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'primary',
							'container' => false,
							'menu_class' => 'nav navbar-nav pull-right',
							'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
							'walker' => new wp_bootstrap_navwalker()
						));
						?>
					</div> <!-- .primary-menu -->
					<?php mdw_mobile_navigation_setup(); ?>
				</nav>
			</div><!-- .container -->
		</div><!-- .navigation -->
