<?php
/**
 * MDWThemeOptionsLegacy class.
 *
 * @since 1.6.0
 */
class MDWThemeOptionsLegacy {

	public $admin_page_url='options.php?page=mdw-theme-upgrade';
	public $old_theme_options_name='old_mdw_theme_options';
	public $theme_plugins_list=array(
		'mdw-full-bg-slider' => 'http://www.millerdesignworks.com/mdw-wp-plugins/mdw-full-bg-slider.zip'
	);
	public $upgraded_theme_version='1.6.0';

	protected $theme_upgrade_option='mdw_theme_upgrade';

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action('admin_menu',array($this,'admin_menu'));
		add_action('admin_notices',array($this,'admin_update_notice'));
	}

	/**
	 * admin_update_notice function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_update_notice() {
		$html=null;

		// check if we really need our update //
		if (!$this->mdw_need_theme_upgrade()) :
			return false;
		endif;

		$html.='<div class="update-nag notice">';
    	$html.='
    		<strong>MDW Theme</strong>: <a href="'.admin_url($this->admin_page_url).'">Click here</a> to run some minor theme updates.
    		<strong>You must do this to make the Theme Options work.</strong>
    	';
		$html.='</div>';

		echo $html;
	}

	/**
	 * mdw_need_theme_upgrade function.
	 *
	 * @access public
	 * @return void
	 */
	public function mdw_need_theme_upgrade() {
		$mdw_theme=wp_get_theme('mdw-wp-theme');
		$mdw_theme_version=$mdw_theme->get('Version');
		$mdw_theme_options=get_option('mdw_wp_theme_options');

		// we are past our upgraded theme version //
		if ($mdw_theme_version>$this->upgraded_theme_version) :
			update_option($this->theme_upgrade_option,0); // upgrade not needed
			return false;
		endif;

		// is the "old" slider active //
		if (isset($mdw_theme_options['bg_slider']['active']) && $mdw_theme_options['bg_slider']['active'])
			return true;

		// anything else bail //
		update_option($this->theme_upgrade_option,0); // upgrade not needed

		return false;
	}

	/**
	 * admin_menu function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_menu() {
		// this page is hidden, you can access via the url ADMIN/options.php?page=mdw-theme-upgrade //
		add_submenu_page('options.php','MDW Theme Upgrade','Theme Upgrade','manage_options','mdw-theme-upgrade',array($this,'admin_page'));
	}

	public function admin_page() {
		?>
		<div class="wrap">
			<h1>MDW Theme Upgrade</h1>
			<?php if (isset($_POST['mdw_update_theme']) && wp_verify_nonce($_POST['mdw_update_theme'],'run_updater')) : ?>
				<?php $this->update_theme(); ?>
			<?php else : ?>
				<p>
					As of theme version <?php echo $this->upgraded_theme_version; ?> there have been some backend changes to the way theme options work.
					This was designed to enhance the theme overall by allowing developers to create custom add ons for the theme. It also cleaned up the
					theme making it faster and cleaner on the backend. Click the button below to do some minor updates to the theme options page(s).
				</p>
				<form name="update_mdw_theme" action="" method="post">
					<?php wp_nonce_field('run_updater','mdw_update_theme'); ?>
					<p class="submit"><input type="submit" name="update_theme" id="update_theme" class="button button-primary" value="Update Theme"></p>
				</form>
			<?php endif; ?>
		</div>

		<?php
	}

	/**
	 * update_theme function.
	 *
	 * @access public
	 * @return void
	 */
	public function update_theme() {
		$result=null;

		$result.='<p>';
			$result.=$this->add_theme_plugins(); // download and install our plugins
			$result.=$this->update_theme_options(); // update theme options
			$result.=$this->clean_up_options(); // clean options up
		$result.='</p>';
		$result.='<p><strong>Theme update is complete<strong> <a href="'.admin_url().'">Click here</p>';

		echo $result;

		wp_die();
	}

	/**
	 * add_theme_plugins function.
	 *
	 * @access protected
	 * @return void
	 */
	protected function add_theme_plugins() {
		WP_Filesystem();
		$plugins=get_plugins();
		$html=null;

		foreach ($this->theme_plugins_list as $slug => $url) :
			$flag=0;

			// check if plugin already exists //
			foreach ($plugins as $plugin_slug => $plugin) :
				if ($plugin_slug==$slug.'/'.$slug.'.php')
					$flag=1;
			endforeach;

			$html.='<strong>Plugin: '.$slug.'</strong><br />';

			// if plugin exists install it and move on //
			if ($flag) :
				$html.='Plugin is already installed...<br />';
				$this->install_plugin($slug);
				continue;
			endif;

			// download our plugin and move it to the plugins folder, then activate //
			if ($file=download_url($url)) :
				$unzipfile=unzip_file($file,WP_PLUGIN_DIR);
				$html.='Plugin downloaded...<br />';

				if (is_wp_error($unzipfile)) :
					$html.=$unzipfile->get_error_message();
				else :
					$html.='Plugin moved to proper directory...<br />';
					$this->install_plugin($slug);
				endif;
			else :
				$html.='Unable to download file. Please check url.<br />';
			endif;

		endforeach;

		return $html;
	}

	/**
	 * install_plugin function.
	 *
	 * @access protected
	 * @param string $slug (default: '')
	 * @return void
	 */
	protected function install_plugin($slug='') {
		$plugin=$slug.'/'.$slug.'.php';
		$html=null;

		if (is_plugin_active($plugin)) :
			$html.='Plugin is already active.<br />';
		else :
			$activate=activate_plugin($plugin);

			if (is_wp_error($activate)) :
				$html.=$activate->get_error_message();
			else :
				$html.='Plugin activated!<br />';
			endif;
		endif;

		return $html;
	}

	/**
	 * update_theme_options function.
	 *
	 * @access protected
	 * @return void
	 */
	protected function update_theme_options() {
		global $mdw_theme_options;
		$html=null;

		$current_mdw_theme_options=get_option('mdw_wp_theme_options');

		if (!get_option($this->old_theme_options_name)) :
			$old_mdw_theme_options=get_option('mdw_wp_theme_options');
			add_option($this->old_theme_options_name,$current_mdw_theme_options); // this way we do not lose old settings
		else :
			$old_mdw_theme_options=get_option($this->old_theme_options_name);
		endif;

		$old_slider=$old_mdw_theme_options['bg_slider'];
		$old_featured_image=$old_mdw_theme_options['featured_image'];
		$old_logo=$old_mdw_theme_options['logo'];
		$old_home_slider=$old_mdw_theme_options['home_slider'];
		$old_non_responsive=$old_mdw_theme_options['non_responsive'];

		// update slider //
		$mdw_theme_options['slider']=mdw_wp_parse_args($old_slider,$mdw_theme_options['slider']);
		$mdw_theme_options['slider']['active_featured_image_as_background']=$old_featured_image['pages'];

		// update logo, home slider and non responsive //
		$mdw_theme_options['default']['logo']=mdw_wp_parse_args($old_logo,$mdw_theme_options['default']['logo']);
		$mdw_theme_options['default']['home_slider']=mdw_wp_parse_args($old_home_slider,$mdw_theme_options['default']['home_slider']);
		$mdw_theme_options['default']['non_responsive']=mdw_wp_parse_args($old_non_responsive,$mdw_theme_options['default']['non_responsive']);

		$html.='Updated logo, home slider, non responsive and slider theme options.<br />';

		return $html;
	}

	/**
	 * clean_up_options function.
	 *
	 * @access protected
	 * @return void
	 */
	protected function clean_up_options() {
		global $mdw_theme_options;

		$html=null;
		$old_mdw_theme_options=get_option($this->old_theme_options_name);
		$diff_arr=array_recursive_diff($mdw_theme_options,$old_mdw_theme_options); // gets rid of all the old stuff

		$mdw_theme_options=$diff_arr; // set our global variable
		update_option($mdw_theme_options['option_name'],$diff_arr);

		return 'Theme Options database field has been cleaned up.<br />';
	}

}

new MDWThemeOptionsLegacy();
?>
