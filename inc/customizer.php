<?php

/**
 * koksijde_customize_register function.
 * 
 * @access public
 * @param mixed $wp_customize
 * @return void
 */
function koksijde_customize_register($wp_customize) {
	$wp_customize->add_section('home_slider', array(
	  'title' => __('Home Slider', 'koksijde'),
	  'description' => __('Setup a slider on the home page.', 'koksijde'),
	  'priority' => 160,
	  'capability' => 'edit_theme_options',
	));
	
	$wp_customize->add_setting('home_slider_active', array(
		'type' => 'theme_mod',
		'default' => 0,
		//'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'esc_attr',
		//'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control('home_slider_active', array(
		'type' => 'checkbox',
		'priority' => 10, // Within the section.
		'section' => 'home_slider', // Required, core or custom.
		'label' => __('Activate Home Slider', 'koksijde'),
		//'active_callback' => 'is_front_page',
	));

	$wp_customize->add_setting('home_slider_post_type', array(
		'type' => 'theme_mod',
		'default' => 'post',
		//'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'esc_attr',
		//'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control(
	    new Koksijde_PostTypes_Control(
	        $wp_customize,
	        'home_slider_post_type',
	        array(
	            'label'    => __('Post Type', 'koksijde'),
	            'section'  => 'home_slider'
	        )
	    )
	);

	$wp_customize->add_setting('home_slider_limit', array(
		'type' => 'theme_mod',
		'default' => '-1',
		//'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'esc_attr',
		//'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control('home_slider_limit', array(
		'type' => 'number',
		'priority' => 10, // Within the section.
		'section' => 'home_slider', // Required, core or custom.
		'label' => __('Limit', 'koksijde'),
		'description' => __('Total number of slides displayed.', 'koksijde'),
		'active_callback' => 'is_front_page',
	));	
	
	$wp_customize->add_setting('home_slider_indicators', array(
		'type' => 'theme_mod',
		'default' => 1,
		//'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'esc_attr',
		//'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control(
	    new Koksijde_TrueFalse_Control(
	        $wp_customize,
	        'home_slider_indicators',
	        array(
	            'label'    => __('Show Indicators', 'koksijde'),
	            'section'  => 'home_slider'
	        )
	    )
	);

	$wp_customize->add_setting('home_slider_slides', array(
		'type' => 'theme_mod',
		'default' => 1,
		//'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'esc_attr',
		//'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control(
	    new Koksijde_TrueFalse_Control(
	        $wp_customize,
	        'home_slider_slides',
	        array(
	            'label'    => __('Show Slides', 'koksijde'),
	            'section'  => 'home_slider'
	        )
	    )
	);

	$wp_customize->add_setting('home_slider_captions', array(
		'type' => 'theme_mod',
		'default' => 0,
		//'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'esc_attr',
		//'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control(
	    new Koksijde_TrueFalse_Control(
	        $wp_customize,
	        'home_slider_captions',
	        array(
	            'label'    => __('Show Captions', 'koksijde'),
	            'section'  => 'home_slider'
	        )
	    )
	);	

	$wp_customize->add_setting('home_slider_caption_field', array(
		'type' => 'theme_mod',
		'default' => 'excerpt',
		//'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'esc_attr',
		//'sanitize_js_callback' => '', // Basically to_json.
	));		

	$wp_customize->add_control(
	    new Koksijde_Caption_Field_Control(
	        $wp_customize,
	        'home_slider_caption_field',
	        array(
	            'label'    => __('Caption Field', 'koksijde'),
	            'section'  => 'home_slider'
	        )
	    )
	);

	$wp_customize->add_setting('home_slider_more_button', array(
		'type' => 'theme_mod',
		'default' => 1,
		//'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'esc_attr',
		//'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control(
	    new Koksijde_TrueFalse_Control(
	        $wp_customize,
	        'home_slider_more_button',
	        array(
	            'label'    => __('Show More Button', 'koksijde'),
	            'section'  => 'home_slider'
	        )
	    )
	);	

	$wp_customize->add_setting('home_slider_read_more_text', array(
		'type' => 'theme_mod',
		'default' => 'Read more...',
		'sanitize_callback' => 'esc_html',
	));
	
	$wp_customize->add_control('home_slider_read_more_text', array(
		'type' => 'text',
		'priority' => 10, // Within the section.
		'section' => 'home_slider', // Required, core or custom.
		'label' => __('More Text', 'koksijde'),
		//'active_callback' => 'is_front_page',
	));	
	
	$wp_customize->add_setting('home_slider_controls', array(
		'type' => 'theme_mod',
		'default' => 1,
		//'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'esc_attr',
		//'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control(
	    new Koksijde_TrueFalse_Control(
	        $wp_customize,
	        'home_slider_controls',
	        array(
	            'label'    => __('Show Controls', 'koksijde'),
	            'section'  => 'home_slider'
	        )
	    )
	);		
	
}
add_action('customize_register', 'koksijde_customize_register');

if (class_exists('WP_Customize_Control')) :
    class Koksijde_PostTypes_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         *
         * @since 3.4.0
         */
        public function render_content() {
			$args=array(
				'public' => true
			);
			$post_types_arr=get_post_types($args);
			?>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>

			<select <?php $this->link(); ?>>
				<?php foreach ($post_types_arr as $type) : ?>
					<option value="<?php echo $type; ?>" <?php selected($this->value(), $type); ?>><?php echo $type; ?></option>
				<?php endforeach; ?>
			</select>
			<?php
        }
    }
endif;

if (class_exists('WP_Customize_Control')) :
    class Koksijde_TrueFalse_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         *
         * @since 3.4.0
         */
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

if (class_exists('WP_Customize_Control')) :
    class Koksijde_Caption_Field_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         *
         * @since 3.4.0
         */
        public function render_content() {
            ?>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <select <?php $this->link(); ?>>
            	<option value="excerpt" <?php selected($this->value(), 'excerpt'); ?>>Excerpt</option>
            	<option value="content" <?php selected($this->value(), 'content'); ?>>Content</option>
            	<option value="title" <?php selected($this->value(), 'title'); ?>>Title</option>            	
            </select>
            <?php        
        }
    }
endif;
?>