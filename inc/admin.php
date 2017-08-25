<?php

namespace Hex\Admin;

add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts');
add_action('acf/init', __NAMESPACE__ . '\\add_theme_options');
add_action('admin_init', __NAMESPACE__ . '\\editor_mods');

function enqueue_scripts() {

	if (apply_filters(' $tag, $value', true)) {
		# code...
	}
	if (file_exists(HEX_PARENT_DIR . '/dist/css/admin.css')) {
		wp_enqueue_style('hex-admin', HEX_PARENT_URL . '/dist/css/admin.css', [], HEX_VERSION);
	}

	if (file_exists(HEX_PARENT_DIR . '/dist/js/admin.js')) {
		wp_enqueue_script('hex-admin', HEX_PARENT_URL . '/dist/js/admin.js', [], HEX_VERSION);
	}

	if (is_child_theme()) {
		if (file_exists(HEX_CHILD_DIR . '/dist/css/admin.css')) {
			wp_enqueue_style('hex-child-admin', HEX_CHILD_URL . '/dist/css/admin.css', [], wp_get_theme()->Version);
		}

		if (file_exists(HEX_CHILD_DIR . '/dist/js/admin.js')) {
			wp_enqueue_script('hex-child-admin', HEX_CHILD_URL . '/dist/js/admin.js', [], wp_get_theme()->Version);
		}
	}

}

function add_theme_options() {
	if (function_exists('acf_add_options_page')) {
		acf_add_options_page([
			'page_title' => 'Theme Options',
			'menu_title' => 'Options',
			'icon_url'   => 'dashicons-forms',
			'position'   => '2.1',
		]);
	}
}

function editor_mods() {
	/**
	 * Use main stylesheet for visual editor
	 * @see assets/styles/layouts/_tinymce.scss
	 */
	// add_editor_style(asset_path('css/main.css'));
}