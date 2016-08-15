<?php

/**
 * koksijdeDefaultThemeOptions class.
 */
class koksijdeDefaultThemeOptions {

	public $version='0.1.0';
	public $options=array();

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts_styles'));
		add_action('init', array($this,'register_page'));
		add_action('koksijde_theme_options_init', array($this, 'update_options'));
	}

	/**
	 * admin_scripts_styles function.
	 *
	 * @access public
	 * @param mixed $hook
	 * @return void
	 */
	public function admin_scripts_styles($hook) {
		if ($hook!='appearance_page_koksijde_options')
			return;

		wp_enqueue_style('koksijde-theme-options-default-style',get_template_directory_uri().'/inc/admin/css/default-options.css');

		wp_enqueue_script('koksijde-custom-media-uploader-script',get_template_directory_uri().'/inc/admin/js/custom-media-uploader.js',array('jquery'),'1.0.0',true);
		wp_enqueue_script('koksijde-wp-theme-options-script',get_template_directory_uri().'/inc/admin/js/default.js',array('jquery'),'1.0.0',true);

		wp_enqueue_media();
	}

	/**
	 * register_page function.
	 *
	 * @access public
	 * @return void
	 */
	public function register_page() {
		$options=array(
			'logo' => array(
				'text' => get_bloginfo('name')
			),
			'home_slider' => array(
				'active' => 0,
				'post_type' => 'post',
				'limit' => -1,
				'indicators' => 1,
				'slides' => 1,
				'captions' => 1,
				'caption_field' => 'excerpt',
				'more_button' => 1,
				'more_text' => 'Read More',
				'controls' => 1
			),
			'non_responsive' => 0,
		);

		register_koksijde_theme_option_page('default', 'Theme Options', array($this, 'admin_page'), 0, $options);
	}

	/**
	 * admin_page function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_page() {
		global $koksijde_theme_options;

		$html=null;
		$logo_img=null;

		if (isset($koksijde_theme_options['default']['logo']['image']) && $koksijde_theme_options['default']['logo']['image']!='')
			$logo_img=wp_get_attachment_image(koksijde_theme_get_image_id_from_url($koksijde_theme_options['default']['logo']['image']), 'navbar-logo', false, array('class' => 'img-responsive'));

		$html.='<form method="post">';

			$html.='<table class="form-table mdw-theme-options general">';
				$html.=wp_nonce_field('update_default_options', 'koksijde_theme_options', true, false);

				$html.='<tr>';
					$html.='<th scope="row">'.__('Logo', 'koksijde').'</th>';
					$html.='<td>';
						$html.='<p>';
							$html.='<label title="logo_text">';
								$html.='<span>Logo Text</span>';
								$html.='<input type="text" name="theme_options[logo][text]" id="logo_text" class="regular-text" value="'.$koksijde_theme_options['default']['logo']['text'].'" />';
							$html.='</label>';
						$html.='</p>';
						$html.='<p class="description">'.__('This theme supports the WordPress Custom Header functionality. To make your logo an image, <a href="'.admin_url('customize.php?return=%2Fwp-admin%2Fthemes.php%3Fpage%3Dmdw_theme_options&autofocus%5Bcontrol%5D=header_image').'">click here</a> or goto Appearance > Header..', 'koksidje').'</p>';
					$html.='</td>';
				$html.='</tr>';

				$html.='<tr>';
					$html.='<th scope="row">'.__('Home Slider', 'koksijde').'</th>';

					$html.='<td>';
						$html.='<label title="activate_home_slider">';
							$html.='<input type="checkbox" name="theme_options[home_slider][active]" id="activate_home_slider" class="" value="1" '.checked($koksijde_theme_options['default']['home_slider']['active'],1,false).' />';
							$html.=__('Activate Home Slider', 'koksijde');
						$html.='</label>';
					$html.='</td>';
				$html.='</tr>';

				$html.='<tr id="home-slider-options">';
					$html.='<th scope="row">'.__('Home Slider Options', 'koksijde').'</th>';

					$html.='<td>';
						$html.='<p>';
							$html.='<label title="home_slider_post_type">';
								$html.='<span>'.__('Post Type', 'koksijde').'</span>';
								$html.=koksijde_theme_get_post_types_list('theme_options[home_slider][post_type]',$koksijde_theme_options['default']['home_slider']['post_type']);
							$html.='</label>';
						$html.='</p>';

						$html.='<p>';
							$html.='<label title="home_slider_limit">';
								$html.='<span>'.__('Limit', 'koksijde').'</span>';
								$html.='<input type="text" name="theme_options[home_slider][limit]" id="home_slider_limit" class="small-text" value="'.$koksijde_theme_options['default']['home_slider']['limit'].'" />';
							$html.='</label>';
						$html.='</p>';

						$html.='<p>';
							$html.='<label title="home_slider_indicators">';
								$html.='<span>'.__('Indicators', 'koksijde').'</span>';
								$html.='<select name="theme_options[home_slider][indicators]" id="home_slider_indicators">';
									$html.='<option value="1" '.selected($koksijde_theme_options['default']['home_slider']['indicators'],'1',false).'>True</option>';
									$html.='<option value="0" '.selected($koksijde_theme_options['default']['home_slider']['indicators'],'0',false).'>False</option>';
								$html.='</select>';
							$html.='</label>';
						$html.='</p>';

						$html.='<p>';
							$html.='<label title="home_slider_slides">';
								$html.='<span>'.__('Slides', 'koksijde').'</span>';
								$html.='<select name="theme_options[home_slider][slides]" id="home_slider_slides">';
									$html.='<option value="1" '.selected($koksijde_theme_options['default']['home_slider']['slides'],'1',false).'>True</option>';
									$html.='<option value="0" '.selected($koksijde_theme_options['default']['home_slider']['slides'],'0',false).'>False</option>';
								$html.='</select>';
							$html.='</label>';
						$html.='</p>';

						$html.='<p>';
							$html.='<label title="home_slider_captions">';
								$html.='<span>'.__('Captions', 'koksijde').'</span>';
								$html.='<select name="theme_options[home_slider][captions]" id="home_slider_captions">';
									$html.='<option value="1" '.selected($koksijde_theme_options['default']['home_slider']['captions'],'1',false).'>True</option>';
									$html.='<option value="0" '.selected($koksijde_theme_options['default']['home_slider']['captions'],'0',false).'>False</option>';
								$html.='</select>';
							$html.='</label>';
						$html.='</p>';

						$html.='<p class="caption-field">';
							$html.='<label title="home_slider_caption_field">';
								$html.='<span>'.__('Caption Field', 'koksijde').'</span>';
								$html.='<select name="theme_options[home_slider][caption_field]" id="home_slider_caption_field">';
									$html.='<option value="excerpt" '.selected($koksijde_theme_options['default']['home_slider']['caption_field'],'excerpt',false).'>Excerpt</option>';
									$html.='<option value="content" '.selected($koksijde_theme_options['default']['home_slider']['caption_field'],'content',false).'>Content</option>';
									$html.='<option value="title" '.selected($koksijde_theme_options['default']['home_slider']['caption_field'],'title',false).'>Title</option>';
								$html.='</select>';
							$html.='</label>';
						$html.='</p>';

						$html.='<p>';
							$html.='<label title="home_slider_more_btn">';
								$html.='<span>'.__('More Button', 'koksijde').'</span>';
								$html.='<select name="theme_options[home_slider][more_button]" id="home_slider_more_btn">';
									$html.='<option value="1" '.selected($koksijde_theme_options['default']['home_slider']['more_button'],'1',false).'>True</option>';
									$html.='<option value="0" '.selected($koksijde_theme_options['default']['home_slider']['more_button'],'0',false).'>False</option>';
								$html.='</select>';
							$html.='</label>';
						$html.='</p>';

						$html.='<p class="more-btn-extra">';
							$html.='<label title="home_slider_read_more">';
								$html.='<span>'.__('Read More', 'koksijde').'</span>';
								$html.='<input type="text" name="theme_options[home_slider][more_text]" id="home_slider_read_more" class="regular-text" value="'.$koksijde_theme_options['default']['home_slider']['more_text'].'" />';
							$html.='</label>';
						$html.='</p>';

						$html.='<p>';
							$html.='<label title="home_slider_controls">';
								$html.='<span>'.__('Controls', 'koksijde').'</span>';
								$html.='<select name="theme_options[home_slider][controls]" id="home_slider_controls">';
									$html.='<option value="1" '.selected($koksijde_theme_options['default']['home_slider']['controls'],'1',false).'>True</option>';
									$html.='<option value="0" '.selected($koksijde_theme_options['default']['home_slider']['controls'],'0',false).'>False</option>';
								$html.='</select>';
							$html.='</label>';
						$html.='</p>';

					$html.='</td>';

				$html.='</tr>';

				$html.='<tr>';
					$html.='<th scope="row">'.__('Non-Responsive', 'koksijde').'</th>';
					$html.='<td>';
						$html.='<p>';
							$html.='<label title="activate_home_slider">';
								$html.='<input type="checkbox" name="theme_options[non_responsive]" id="non_responsive" class="" value="1" '.checked($koksijde_theme_options['default']['non_responsive'],1,false).' />';
							$html.=__('Make site non-responsive', 'koksijde');
							$html.='</label>';
						$html.='</p>';
					$html.='</td>';
				$html.='</tr>';

			$html.='</table>';

			$html.='<p class="submit">';
				$html.='<input type="submit" name="update-theme-options" id="submit" class="button button-primary" value="Save Changes">';
			$html.='</p>';
			$html.='<input type="hidden" name="update-theme-options-general-check" value="true" />';

		$html.='</form>';
		echo $html;
		?>
		<?php _e('<h2 class="title">koksijde Theme Add Ons</h2>', 'koksijde'); ?>
		<p>
			<?php _e('We have decided to reduce the size and load of the koksijde theme on both the front and backend. As a result, we offer plugins that will
			hook into our theme. Developers can also their own features (plugins) and theme options and hook them into the theme.', 'koksijde'); ?>
		</p>
		<p>
			<?php _e('Below are a list of koksijde created "theme addons" that you can use with the koksijde theme. They install like normal plugins and can be
			activated and deactivated in the Plugins section. However, once activated, they will hook directly into this theme options page via a
			new tab.', 'koksijde'); ?>
		</p>

		<?php $addons=koksijde_get_theme_addons(); ?>

		<table class="wp-list-table widefat mdw-theme-addons">
			<thead>
				<tr>
					<th scope="col" id="name" class="manage-column column-name column-primary"><?php _e('Add On', 'koksijde'); ?></th>
					<th scope="col" id="description" class="manage-column column-description"><?php _e('Description', 'koksijde'); ?></th>
				</tr>
			</thead>

			<tbody id="the-list">
				<?php foreach ($addons as $data) : ?>
					<?php $data_obj=json_decode($data['body']); ?>

					<tr id="<?php echo $data_obj->slug; ?>" class="">
						<td class="addon-title column-primary">
							<strong><?php echo $data_obj->name; ?></strong>
							<div class="row-actions visible">
								<span class="download">
									<a href="<?php echo $data_obj->download_url; ?>" class="download">Download</a>
								</span>
							</div>
						</td>
						<td class="column-description desc">
							<div class="addon-description"><p><?php echo $data_obj->sections->description; ?></p></div>
							<div class="second addon-version-author-uri">
								Version <?php echo $data_obj->version; ?> | By <a href="<?php echo $data_obj->author_homepage; ?>"><?php echo $data_obj->author; ?></a>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
		//echo $html;
	}

	/**
	 * update_options function.
	 *
	 * @access public
	 * @return void
	 */
	public function update_options() {
		global $koksijde_theme_options;

		if (!isset($_POST['koksijde_theme_options']) || !wp_verify_nonce($_POST['koksijde_theme_options'],'update_default_options'))
			return false;

		if (!isset($_POST['theme_options']['home_slider']['active']))
			$_POST['theme_options']['home_slider']['active']=0;

		if (!isset($_POST['theme_options']['non_responsive']))
			$_POST['theme_options']['non_responsive']=0;

		// sanitize //
		$_POST['theme_options']['logo']['text']=sanitize_text_field($_POST['theme_options']['logo']['text']);
		$_POST['theme_options']['home_slider']['limit']=intval($_POST['theme_options']['home_slider']['limit']);
		$_POST['theme_options']['home_slider']['more_text']=sanitize_text_field($_POST['theme_options']['home_slider']['more_text']);

		$koksijde_theme_options['default']=koksijde_wp_parse_args($_POST['theme_options'], $koksijde_theme_options['default']); // merger post (updated) options with previous options

		update_option($koksijde_theme_options['option_name'], $koksijde_theme_options);

		echo '<div class="updated mdw-theme-options-updated">'.__('Theme Options have been updated.', 'koksijde').'</div>';
	}

}

new koksijdeDefaultThemeOptions();

/**
 * koksijde_get_theme_addons function.
 *
 * @access public
 * @return void
 */
function koksijde_get_theme_addons() {
	// list of urls in array
	$addons=array(
		//'http://www.millerdesignworks.com/mdw-wp-plugins/mdw-full-bg-slider.json'
	);
	$addons_data=array();

	foreach ($addons as $addon_url) :
		$addons_data[]=koksijde_get_addon_url_contents($addon_url);
	endforeach;

	return $addons_data;
}

/**
 * koksijde_get_addon_url_contents function.
 *
 * @access public
 * @param bool $url (default: false)
 * @return void
 */
function koksijde_get_addon_url_contents($url=false) {
	if (!$url)
		return false;

	$response=wp_remote_get($url);

	if (is_array($response))
		return $response;

	return false;
}
?>