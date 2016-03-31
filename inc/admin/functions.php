<?php
/**
 * register_koksijde_theme_option_page function.
 *
 * @access public
 * @param bool $slug (default: false)
 * @param string $name (default: '')
 * @param bool $function (default: false)
 * @param int $order (default: 0)
 * @return void
 */
function register_koksijde_theme_option_page($slug=false, $name='', $function=false, $order=0, $options=array()) {
	global $koksijde_theme_options_tabs, $koksijde_theme_options_hooks, $koksijde_theme_options;

	if (!$function)
		return false;

	if (!$slug)
		$slug=strtolower($function);

	// setup our action hook //
	$hookname='koksijde_theme_options_tab-'.$slug;
	add_action($hookname,$function);

	// add tab //
	$koksijde_theme_options_tabs[$slug]=array(
		'name' => $name,
		'function' => $function,
		'order' => $order,
	);
	$koksijde_theme_options_hooks[$hookname]=true;

	// add options //
	$koksijde_theme_options[$slug]=$options;
}

/**
 * koksijde_theme_get_image_id_from_url function.
 *
 * @access public
 * @param mixed $image_url
 * @return void
 */
function koksijde_theme_get_image_id_from_url($image_url) {
	global $wpdb;

	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));

	return $attachment[0];
}

/**
 * koksijde_theme_get_post_types_list function.
 *
 * @access public
 * @param string $name (default: '')
 * @param bool $selected (default: false)
 * @param string $output (default: 'dropdown')
 * @return void
 */
function koksijde_theme_get_post_types_list($name='', $selected=false, $output='dropdown') {
	$html=null;
	$args=array(
		'public' => true
	);
	$post_types_arr=get_post_types($args);

	$html.='<select name="'.$name.'" class="post-type-list-admin">';
		foreach ($post_types_arr as $type) :
			$html.='<option value="'.$type.'" '.selected($selected, $type, false).'>'.$type.'</option>';
		endforeach;
	$html.='</select>';

	return $html;
}

/**
 * array_recursive_diff function.
 *
 * @access public
 * @param mixed $aArray1
 * @param mixed $aArray2
 * @return void
 */
if (!function_exists('array_recursive_diff')) :
	function array_recursive_diff($aArray1, $aArray2) {
	  $aReturn = array();

	  foreach ($aArray1 as $mKey => $mValue) {
	    if (array_key_exists($mKey, $aArray2)) {
	      if (is_array($mValue)) {
	        $aRecursiveDiff = array_recursive_diff($mValue, $aArray2[$mKey]);
	        if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
	      } else {
	        if ($mValue != $aArray2[$mKey]) {
	          $aReturn[$mKey] = $mValue;
	        }
	      }
	    } else {
	      $aReturn[$mKey] = $mValue;
	    }
	  }
	  return $aReturn;
	}
endif;
?>