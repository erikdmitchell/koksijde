<?php

/**
 * koksijde_customize_register function.
 * 
 * @access public
 * @param mixed $wp_customize
 * @return void
 */
function koksijde_customize_register($wp_customize) {
	/// make theme non responsive //
	$wp_customize->add_setting('koksijde_non_responsive', array(
	  'default' => 0,
	));
	
	$wp_customize->add_control('koksijde_non_responsive', array(
	  'type' => 'checkbox',
	  'priority' => 160,
	  'section' => 'title_tagline',
	  'label' => __('Disable Responsiveness'),
	  'description' => __('Will make the theme non responsive.'),
	));
}
add_action('customize_register', 'koksijde_customize_register');
?>