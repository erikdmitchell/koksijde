<?php

/**
 * koksijde_customize_register function.
 * 
 * @access public
 * @param mixed $wp_customize
 * @return void
 */
function koksijde_customize_register($wp_customize) {	
	$wp_customize->add_panel('koksijde_home_page', array(
		'priority' => 200,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __('Home Page', 'koksijde'),
		'description' => __('Settings pertaining to the home page.', 'koksijde'),
	));

	// Slider section //
	$wp_customize->add_section('slider', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __('Slider', 'koksijde'),
	    'description' =>  __('Slider configuration', 'koksijde'),
	    'panel' => 'koksijde_home_page',
	));
	
	// home slider active //
	$wp_customize->add_setting('slider_active', array(
		'type' => 'theme_mod',
		'default' => 0,
		'sanitize_callback' => 'koksijde_sanitize_checkbox',
	));

	$wp_customize->add_control('slider_active', array(
		'type' => 'checkbox',
		'priority' => 10,
		'section' => 'slider',
		'label' => __('Activate Home Slider', 'koksijde'),
	));

	// home slider post type //
	$wp_customize->add_setting('slider_post_type', array(
		'type' => 'theme_mod',
		'default' => 'post',
		'sanitize_callback' => 'koksijde_sanitize_select',		
	));

	$wp_customize->add_control(
	    new Koksijde_Post_Types_Control(
	        $wp_customize,
	        'slider_post_type',
	        array(
	            'label'    => __('Post Type', 'koksijde'),
	            'section'  => 'slider'
	        )
	    )
	);

	// slider limit //
	$wp_customize->add_setting('slider_limit', array(
		'type' => 'theme_mod',
		'default' => -1,
		'sanitize_callback' => 'koksijde_sanitize_number',
	));

	$wp_customize->add_control('slider_limit', array(
		'type' => 'number',
		'priority' => 10, // Within the section.
		'section' => 'slider', // Required, core or custom.
		'label' => __('Limit', 'koksijde'),
		'description' => __('Total number of slides displayed.', 'koksijde'),
		'active_callback' => 'is_front_page',
	));	
	
	// slider indicators //
	$wp_customize->add_setting('slider_indicators', array(
		'type' => 'theme_mod',
		'default' => 1,
		'sanitize_callback' => 'koksijde_sanitize_select',
	));

	$wp_customize->add_control(
	    new Koksijde_True_False_Control(
	        $wp_customize,
	        'slider_indicators',
	        array(
	            'label'    => __('Show Indicators', 'koksijde'),
	            'section'  => 'slider'
	        )
	    )
	);

	// captions //
	$wp_customize->add_setting('slider_captions', array(
		'type' => 'theme_mod',
		'default' => 0,
		'sanitize_callback' => 'koksijde_sanitize_select',
	));

	$wp_customize->add_control(
	    new Koksijde_True_False_Control(
	        $wp_customize,
	        'slider_captions',
	        array(
	            'label'    => __('Show Captions', 'koksijde'),
	            'section'  => 'slider'
	        )
	    )
	);	

	// caption field //
	$wp_customize->add_setting('slider_caption_field', array(
		'type' => 'theme_mod',
		'default' => 'excerpt',
		'sanitize_callback' => 'koksijde_sanitize_select',
	));		

	$wp_customize->add_control('slider_caption_field', array(
		'label' => __('Caption Field', 'koksijde'),
        'section'  => 'slider',
        'type'     => 'select',
        'choices'  => array(
            'excerpt' => __('Excerpt', 'koksijde'),
            'content' => __('Content', 'koksijde'),
            'title' => __('Title', 'koksijde'),
        ),
	));

	// more button //
	$wp_customize->add_setting('slider_more_button', array(
		'type' => 'theme_mod',
		'default' => 1,
		'sanitize_callback' => 'koksijde_sanitize_select',
	));

	$wp_customize->add_control(
	    new Koksijde_True_False_Control(
	        $wp_customize,
	        'slider_more_button',
	        array(
	            'label'    => __('Show More Button', 'koksijde'),
	            'section'  => 'slider'
	        )
	    )
	);	

	// more text //
	$wp_customize->add_setting('slider_read_more_text', array(
		'type' => 'theme_mod',
		'default' => 'Read more...',
		'sanitize_callback' => 'koksijde_sanitize_html',
	));
	
	$wp_customize->add_control('slider_read_more_text', array(
		'type' => 'text',
		'priority' => 10, // Within the section.
		'section' => 'slider', // Required, core or custom.
		'label' => __('More Text', 'koksijde'),
	));	
	
	// slider controls //
	$wp_customize->add_setting('slider_controls', array(
		'type' => 'theme_mod',
		'default' => 1,
		'sanitize_callback' => 'koksijde_sanitize_select',
	));

	$wp_customize->add_control(
	    new Koksijde_True_False_Control(
	        $wp_customize,
	        'slider_controls',
	        array(
	            'label'    => __('Show Controls', 'koksijde'),
	            'section'  => 'slider'
	        )
	    )
	);
	
	// Blog Posts section
	$wp_customize->add_section('blog_posts', array(
	    'priority' => 15,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __('Blog Posts', 'koksijde'),
	    'description' =>  __('Blog posts configuration', 'koksijde'),
	    'panel' => 'koksijde_home_page',
	));
	
	// blog posts active //
	$wp_customize->add_setting('blog_posts_active', array(
		'type' => 'theme_mod',
		'default' => 1,
		'sanitize_callback' => 'koksijde_sanitize_checkbox',
	));

	$wp_customize->add_control('blog_posts_active', array(
		'type' => 'checkbox',
		'priority' => 10,
		'section' => 'blog_posts',
		'label' => __('Display Blog Posts', 'koksijde'),
	));

	// home blog posts post type //
	$wp_customize->add_setting('blog_posts_post_type', array(
		'type' => 'theme_mod',
		'default' => 'post',
		'sanitize_callback' => 'koksijde_sanitize_select',
	));

	$wp_customize->add_control(
	    new Koksijde_Post_Types_Control(
	        $wp_customize,
	        'blog_posts_post_type',
	        array(
	            'label'    => __('Post Type', 'koksijde'),
	            'section'  => 'blog_posts',
	        )
	    )
	);

	// blog posts limit //
	$wp_customize->add_setting('blog_posts_limit', array(
		'type' => 'theme_mod',
		'default' => 6,
		'sanitize_callback' => 'koksijde_sanitize_number',
	));

	$wp_customize->add_control('blog_posts_limit', array(
		'type' => 'number',
		'priority' => 10,
		'section' => 'home_blog_posts', 
		'label' => __('Limit', 'koksijde'),
		'description' => __('Total number of posts displayed.', 'koksijde'),
		'active_callback' => 'is_front_page',
	));			

	// General section
	$wp_customize->add_section('general', array(
	    'priority' => 20,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __('General', 'koksijde'),
	    'description' =>  __('General configuration', 'koksijde'),
	    'panel' => 'koksijde_home_page',
	));

	// home slider content displayed //
	$wp_customize->add_setting('display_content', array(
		'type' => 'theme_mod',
		'default' => 0,
		'sanitize_callback' => 'koksijde_sanitize_checkbox',
	));

	$wp_customize->add_control('display_content', array(
		'type' => 'checkbox',
		'priority' => 10,
		'section' => 'general',
		'label' => __('Display page content', 'koksijde'),
	));	
}
add_action('customize_register', 'koksijde_customize_register');


if (class_exists('WP_Customize_Control')) :
    class Koksijde_Post_Types_Control extends WP_Customize_Control {

		// we need to setup our "choices" var by overriding the construct //
		public function __construct($manager, $id, $args=array()) {
			parent::__construct($manager, $id, $args);
			
			$post_types_args=array(
				'public' => true,	
			);
			
			$this->choices=get_post_types($post_types_args);
		}

        public function render_content() {        
			?>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>

			<select <?php $this->link(); ?>>
				<?php foreach ($this->choices as $type) : ?>
					<option value="<?php echo $type; ?>" <?php selected($this->value(), $type); ?>><?php echo $type; ?></option>
				<?php endforeach; ?>
			</select>
			<?php
        }
        
    }
endif;

if (class_exists('WP_Customize_Control')) :
    class Koksijde_True_False_Control extends WP_Customize_Control {
 
 		// we need to setup our "choices" var by overriding the construct //
		public function __construct($manager, $id, $args=array()) {
			parent::__construct($manager, $id, $args);

			$this->choices=array(
				'1' => 'True',
				'0' => 'False',	
			);
		}
 
        public function render_content() {
            ?>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <select <?php $this->link(); ?>>
            	<option value="1" <?php selected($this->value(), 1); ?>>True</option>
            	<option value="0" <?php selected($this->value(), 0); ?>>False</option>           	
            </select>
            <?php        
        }
    }
endif;

/**
 * CALLBACKS
 *
 * credit: https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 */

/**
 * Checkbox sanitization callback example.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function koksijde_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 * 
 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
 * as a slug, and then validates `$input` against the choices defined for the control.
 * 
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function koksijde_sanitize_select($input, $setting) {
	// Ensure input is a slug.
	$input=sanitize_key($input);
	
	// Get list of choices from the control associated with the setting.
	$choices=$setting->manager->get_control($setting->id)->choices;
//print_r($choices);
	// If the input is a valid key, return it; otherwise, return the default.
	return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * HTML sanitization callback example.
 *
 * - Sanitization: html
 * - Control: text, textarea
 * 
 * Sanitization callback for 'html' type text inputs. This callback sanitizes `$html`
 * for HTML allowable in posts.
 * 
 * NOTE: wp_filter_post_kses() can be passed directly as `$wp_customize->add_setting()`
 * 'sanitize_callback'. It is wrapped in a callback here merely for example purposes.
 * 
 * @see wp_filter_post_kses() https://developer.wordpress.org/reference/functions/wp_filter_post_kses/
 *
 * @param string $html HTML to sanitize.
 * @return string Sanitized HTML.
 */
function koksijde_sanitize_html( $html ) {
	return wp_filter_post_kses( $html );
}

/**
 * Number sanitization callback example.
 *
 * @param int $number  Number to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int Sanitized number; otherwise, the setting default.
 */
function koksijde_sanitize_number( $number, $setting ) {
	if (is_numeric($number)) :
		$number=$number;
	else :
		$number=-1;
	endif;
	
	return $number;
}
?>