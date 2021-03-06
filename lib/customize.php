<?php
/**
 * Altitude Pro.
 *
 * This file adds the Customizer additions to the Altitude Pro Theme.
 *
 * @package Altitude Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/altitude/
 */

add_action( 'customize_register', 'altitude_customizer_register' );
/**
 * Registers settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function altitude_customizer_register( $wp_customize ) {

	$images = apply_filters( 'altitude_images', array( '1', '3', '5', '7' ) );

	$wp_customize->add_section(
		'altitude-settings',
		array(
			'description' => __( 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1600 pixels wide and 1050 pixels tall</strong>.', 'wmw' ),
			'title'       => __( 'Front Page Background Images', 'wmw' ),
			'priority'    => 35,
		)
	);

	foreach ( $images as $key => $image ) {

		$wp_customize->add_setting(
			$image . '-altitude-image',
			array(
				'default'           => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
				'sanitize_callback' => 'esc_url_raw',
				'type'              => 'option',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$image . '-altitude-image',
				array(
					/* translators: %s is replaced with a number representing the section, such as "3" */
					'label'    => sprintf( __( 'Featured Section %s Image:', 'wmw' ), $image ),
					'section'  => 'altitude-settings',
					'settings' => $image . '-altitude-image',
					'priority' => $key + 1,
				)
			)
		);

	}

	// Adds the link color picker.
	$wp_customize->add_setting(
		'altitude_link_color',
		array(
			'default'           => altitude_customizer_get_default_link_color(),
			'sanatize_callback' => 'sanatize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'altitude_link_color',
			array(
				'description' => __( 'Change the color of links, buttons in content and white front page sections, the hover color of linked titles, the footer widget background color, and more.', 'wmw' ),
				'label'       => __( 'Link Color', 'wmw' ),
				'section'     => 'colors',
				'settings'    => 'altitude_link_color',
			)
		)
	);

	// Add the accent color picker.
	$wp_customize->add_setting(
		'altitude_accent_color',
		array(
			'default'           => altitude_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'altitude_accent_color',
			array(
				'description' => __( 'Change the color of buttons used in front page image sections, the focus color of mobile menu buttons, and the hover color for footer links.', 'wmw' ),
				'label'       => __( 'Accent Color', 'wmw' ),
				'section'     => 'colors',
				'settings'    => 'altitude_accent_color',
			)
		)
	);

}
