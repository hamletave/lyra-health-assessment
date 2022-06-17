<?php

defined('ABSPATH') || exit;

/**
 * https://codex.wordpress.org/Theme_Customization_API
 *
 * How do I "output" custom theme modification settings? https://developer.wordpress.org/reference/functions/get_theme_mod
 * echo get_theme_mod( 'copyright_info' );
 * or: echo get_theme_mod( 'copyright_info', 'Default (c) Copyright Info if nothing provided' );
 *
 * "sanitize_callback": https://codex.wordpress.org/Data_Validation
 */

/**
 * Implement Theme Customizer additions and adjustments.
 */
function lyra_assessment_customize($wp_customize)
{

	/**
	 * Initialize sections
	 */
	$wp_customize->add_section(
		'theme_header_section',
		array(
			'title'    => __('Header', 'lyra-assessment'),
			'priority' => 1000,
		)
	);

	/**
	 * Section: Page Layout
	 */
	// Header Logo.
	$wp_customize->add_setting(
		'header_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'header_logo',
			array(
				'label'       => __('Upload Header Logo', 'lyra-assessment'),
				'description' => __('Height: &gt;80px', 'lyra-assessment'),
				'section'     => 'theme_header_section',
				'settings'    => 'header_logo',
				'priority'    => 1,
			)
		)
	);

	// Predefined Navbar scheme.
	$wp_customize->add_setting(
		'navbar_scheme',
		array(
			'default'           => 'default',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'navbar_scheme',
		array(
			'type'     => 'radio',
			'label'    => __('Navbar Scheme', 'lyra-assessment'),
			'section'  => 'theme_header_section',
			'choices'  => array(
				'navbar-light bg-light'  => __('Default', 'lyra-assessment'),
				'navbar-dark bg-dark'    => __('Dark', 'lyra-assessment'),
				'navbar-dark bg-primary' => __('Primary', 'lyra-assessment'),
			),
			'settings' => 'navbar_scheme',
			'priority' => 1,
		)
	);

	// Fixed Header?
	$wp_customize->add_setting(
		'navbar_position',
		array(
			'default'           => 'static',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'navbar_position',
		array(
			'type'     => 'radio',
			'label'    => __('Navbar', 'lyra-assessment'),
			'section'  => 'theme_header_section',
			'choices'  => array(
				'static'       => __('Static', 'lyra-assessment'),
				'fixed_top'    => __('Fixed to top', 'lyra-assessment'),
				'fixed_bottom' => __('Fixed to bottom', 'lyra-assessment'),
			),
			'settings' => 'navbar_position',
			'priority' => 2,
		)
	);
}
add_action('customize_register', 'lyra_assessment_customize');
