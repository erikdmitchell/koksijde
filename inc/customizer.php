<?php

function koksijde_customize_register($wp_customize) {
	$wp_customize->add_section('home_slider', array(
	  'title' => __('Home Slider'),
	  'description' => __('Setup a slider on the home page.'),
	  'priority' => 160,
	  'capability' => 'edit_theme_options',
	));
	
	$wp_customize->add_setting('home_slider_active', array(
		'type' => 'theme_mod',
		'default' => '',
		'transport' => 'refresh', // or postMessage
		'sanitize_callback' => '',
		'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control('home_slider_active', array(
		'type' => 'checkbox',
		'priority' => 10, // Within the section.
		'section' => 'home_slider', // Required, core or custom.
		'label' => __('Activate Home Slider'),
		//'active_callback' => 'is_front_page',
	));

	$wp_customize->add_setting('home_slider_post_type', array(
		'type' => 'theme_mod',
		'default' => '',
		'transport' => 'refresh', // or postMessage
		'sanitize_callback' => '',
		'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control(
	    new Koksijde_PostTypes_Control(
	        $wp_customize,
	        'home_slider_post_type',
	        array(
	            'label'    => __('Post Type'),
	            'section'  => 'home_slider'
	        )
	    )
	);

	$wp_customize->add_setting('home_slider_limit', array(
		'type' => 'theme_mod',
		'default' => '-1',
		'transport' => 'refresh', // or postMessage
		'sanitize_callback' => '',
		'sanitize_js_callback' => '', // Basically to_json.
	));

	$wp_customize->add_control('home_slider_limit', array(
		'type' => 'number',
		'priority' => 10, // Within the section.
		'section' => 'home_slider', // Required, core or custom.
		'label' => __('Limit'),
		'description' => __('Total number of slides displayed.'),
		'active_callback' => 'is_front_page',
	));	
	
	
/*
$wp_customize->add_control(
    new Koksijde_TrueFalse_Control(
        $wp_customize,
        'setting_id',
        array(
            'label'    => __('Indicators'),
            'section'  => 'home_slider'
        )
    )
);
*/

/*
	$wp_customize->add_control('setting_id', array(
		'type' => 'date',
		'priority' => 10, // Within the section.
		'section' => 'home_slider', // Required, core or custom.
		'label' => __('Date'),
		'description' => __('This is a date control with a red border.'),
		'input_attrs' => array(
			'class' => 'my-custom-class-for-js',
			'style' => 'border: 1px solid #900',
			'placeholder' => __('mm/dd/yyyy'),
		),
		'active_callback' => 'is_front_page',
	));
*/
	
}
add_action('customize_register', 'koksijde_customize_register');

/*
Indicators - t/f
Slides - t/f
Captions - t/f
Caption Field - excerpt, content, title
More Button - t/f
Read More - text
Controls - t/f
*/

if (class_exists('WP_Customize_Control')) :
    class Koksijde_PostTypes_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         *
         * @since 3.4.0
         */
        public function render_content() {
            $html=null;
            
            $html.='<span class="customize-control-title">'.esc_html($this->label).'</span>';
            $html.=koksijde_theme_get_post_types_list();
            
            echo $html;
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
            $html=null;
            
            $html.='<span class="customize-control-title">'.esc_html($this->label).'</span>';
            $html.='<select name="" id="" class="">';
            	$html.='<option value="1">True</option>';
            	$html.='<option value="0">False</option>';            	
            $html.='</select>';
            
            echo $html;	        
        }
    }
endif;
?>