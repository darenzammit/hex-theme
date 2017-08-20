<?php
/**
 * Theme Customizer
 *
 * @link https://developer.wordpress.org/themes/customize-api/
 */

namespace Hex\Customizer;

add_action('customize_register', __NAMESPACE__ . '\\site_settings');
add_action('customize_preview_init', __NAMESPACE__ . '\\enqueue_scripts');

function site_settings($wp_customize) {

	$wp_customize->add_section('site_settings', array(
		'title'    => __('Settings', 'hex'),
		'priority' => 130,
	));

	$wp_customize->add_setting('hex_site_credits', ['default' => '']);
	$wp_customize->add_control('hex_site_credits', [
		'label'       => esc_html__('Site Credits', 'hex'),
		'description' => esc_html__('The copyright text will be displayed beneath the menu in the footer.', 'hex'),
		'section'     => 'site_settings',
		'type'        => 'text',
		'sanitize'    => 'html',
		'priority'    => 70,
	]);

	$wp_customize->add_setting('hex_google_analytics', ['default' => '', 'type' => 'option']);
	$wp_customize->add_control('hex_google_analytics', [
		'label'       => esc_html__('Google Analytics ID', 'hex'),
		'section'     => 'site_settings',
		'type'        => 'text',
		'sanitize'    => 'html',
		'priority'    => 71,
		'input_attrs' => [
			'placeholder' => 'UA-XXXXX-Y',
		],
	]);

	$wp_customize->add_setting('hex_google_analytics_wp_head', ['default' => '', 'type' => 'option']);
	$wp_customize->add_control('hex_google_analytics_wp_head', [
		'label'    => esc_html__('Load Google Analytics in <head>', 'hex'),
		'section'  => 'site_settings',
		'type'     => 'checkbox',
		'priority' => 72,
	]);

	$wp_customize->add_setting('hex_google_maps_api_key', ['default' => '', 'type' => 'option']);
	$wp_customize->add_control('hex_google_maps_api_key', [
		'label'       => esc_html__('Google Maps API Key', 'hex'),
		'section'     => 'site_settings',
		'type'        => 'text',
		'sanitize'    => 'html',
		'priority'    => 73,
		'input_attrs' => [
			'placeholder' => 'AIzaSyA1Vw_BU4fmVxdasKlftSdQWyydJqrr9Ek',
		],

	]);

}

function enqueue_scripts() {
	wp_enqueue_script('hex/customizer.js', Hex()->asset_path('js/customizer.js'), ['customize-preview'], null, true);
}
