<?php
/**
 * MDWWPThemeOptions class.
 *
 * @since 0.1.0
 */
class MDWWPThemeOptions {

	public $version='0.0.3';

	function __construct() {
		if (!defined('THEME_ADMIN_URL'))
			define('THEME_ADMIN_URL',get_template_directory_uri().'/inc/admin');

		add_action('admin_menu',array($this,'add_theme_page'));
		add_action('admin_enqueue_scripts',array($this,'admin_scripts_styles'));
		add_action('init',array($this,'setup_options'));
	}

	function admin_scripts_styles($hook) {
		if ($hook!='appearance_page_mdw_theme_options')
			return;

		wp_enqueue_style('mdw-wp-theme-options-style',THEME_ADMIN_URL.'/css/admin-theme-options.css');
	}

	/**
	 * add_theme_page function.
	 *
	 * @access public
	 * @return void
	 */
	function add_theme_page() {
    add_theme_page('Theme Options','Theme Options','edit_theme_options','mdw_theme_options',array($this,'mdw_display_theme_options'));
	}

	/**
	 * mdw_display_theme_options function.
	 *
	 * @access public
	 * @return void
	 */
	public function mdw_display_theme_options() {
		global $_mdw_theme_options_tabs,$_mdw_theme_options_hooks,$mdw_theme_options;

		$html=null;
		$classes=null;
		$active_tab=isset($_GET['tab']) ? $_GET['tab'] : 'default';

		do_action('mdw_theme_options_init');

		echo '<div class="wrap">';
			echo '<h1>MDW Theme Options</h1>';

			$this->display_admin_tabs($active_tab); // display tabs

			$this->display_admin_content($active_tab); // display our "hook"
		echo '</div>';
	}

	/**
	 * display_admin_tabs function.
	 *
	 * @access public
	 * @param string $active_tab (default: 'default')
	 * @return void
	 */
	public function display_admin_tabs($active_tab='default') {
		global $_mdw_theme_options_tabs;

		if (empty($_mdw_theme_options_tabs))
			return false;

		// sort tabs by order //
		uasort($_mdw_theme_options_tabs, function ($a, $b) {
			if (function_exists('bccomp')) :
				return bccomp($a['order'], $b['order']);
			else :
				return strcmp($a['order'], $b['order']);
			endif;
		});

		// output tabs //
		echo '<h2 class="nav-tabs">';
			foreach ($_mdw_theme_options_tabs as $slug => $tab) :
				if ($active_tab==$slug) :
					$classes='nav-tab-active';
				else :
					$classes=null;
				endif;

				echo '<a href="?page=mdw_theme_options&tab='.$slug.'" class="nav-tab '.$classes.'">'.$tab['name'].'</a>';
			endforeach;
		echo '</h2>';
	}

	/**
	 * display_admin_content function.
	 *
	 * @access public
	 * @param string $active_tab (default: 'default')
	 * @return void
	 */
	public function display_admin_content($active_tab='default') {
		global $_mdw_theme_options_hooks,$_mdw_theme_options_tabs;

		// cycle through hooks to display correct one //
		foreach ($_mdw_theme_options_hooks as $tag => $active) :
			$tag_arr=explode('-',$tag);
			$id=array_pop($tag_arr);

			// apply our hook //
			if ($active_tab==$id) :
				echo '<div class="mdw-theme-options-content">';
					do_action($tag,$_mdw_theme_options_tabs[$id]['function']);
				echo '</div>';
			endif;
		endforeach;
	}

	/**
	 * setup_options function.
	 *
	 * @access public
	 * @return void
	 */
	public function setup_options() {
		global $mdw_theme_options;

		$options=$mdw_theme_options;
		$stored_options=array();

		if (isset($mdw_theme_options['option_name']))
			$stored_options=get_option($mdw_theme_options['option_name']);

		if ($stored_options)
	 		$mdw_theme_options=mdw_wp_parse_args($stored_options,$mdw_theme_options); // append stored options
	}

}

new MDWWPThemeOptions();
?>