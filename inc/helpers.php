<?php

namespace Hex;

/**
 * Return dist folder
 */
function asset_path($asset) {
	return HEX_CHILD_URL . "/dist/{$asset}";
}

/**
 * Return SVG markup
 */
function get_svg_contents($filename) {
	$svg      = get_svg($filename);
	$filepath = str_replace(get_stylesheet_directory_uri(), get_stylesheet_directory(), $svg);
	if (is_file($filepath)) {
		return file_get_contents($filepath);
	}
}

/**
 *
 * Return SVG path
 */
function get_svg($filename) {
	return asset_path("svg/{$filename}.svg");
}

/**
 * Return Image path
 */
function get_img($filename) {
	return asset_path("img/{$filename}");
}

/**
 * Custom Logo fallback ver < 4.7
 */
function custom_logo() {
	if (!function_exists('the_custom_logo')) {
		return;
	} else {
		the_custom_logo();
	}
}

/**
 * Page titles
 */
function title() {
	if (is_home()) {
		if ($home = get_option('page_for_posts', true)) {
			return get_the_title($home);
		}
		return __('Latest Posts', 'hex');
	}
	if (is_archive()) {
		return get_the_archive_title();
	}
	if (is_search()) {
		return sprintf(__('Search Results for %s', 'hex'), get_search_query());
	}
	if (is_404()) {
		return __('Not Found', 'hex');
	}
	return get_the_title();
}

/**
 * Get Brand logo or name
 * Backwards compatible with wordpress < 4.7
 */
function brand() {
	if (function_exists('get_custom_logo') && ($logo = get_custom_logo())) {
		echo $logo;
	} else {
		echo sprintf('<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
			esc_url(home_url('/')),
			get_bloginfo('name', 'display')
		);
	}
}

/**
 * Displays Navigation
 */
function navigation() {
	if (is_single()) {
		the_post_navigation();
	} else {
		the_posts_navigation();
	}
}

/**
 * Display post thumbnail
 *
 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
 */
function post_thumbnail($size = 'full') {
	if (has_post_thumbnail()) {
		the_post_thumbnail($size);
	}
}

/**
 * Display navigation to next/previous post when applicable.
 */
function post_nav() {
	$args = array(
		'next_text' => '%title',
		'prev_text' => '%title',
	);
	the_post_navigation($args);
}

/**
 * Display comments
 */

function display_comments() {
	// If comments are open or we have at least one comment, load up the comment template.
	if (comments_open() || '0' != get_comments_number()):
		comments_template();
	endif;
}

/**
 * sidebar
 */

function display_sidebar() {
	return apply_filters('hex_display_sidebar', true);
}

function get_sidebar() {
	if (display_sidebar()) {
		\get_sidebar();
	}
}

function dynamic_sidebar() {
	if (is_active_sidebar('sidebar-primary')) {
		\dynamic_sidebar('sidebar-primary');
	}
}

/**
 * General
 */

function outdated_browser_alert() {
	get_template_part('components/global/outdated-browser-alert');
}

function container_wrapper_start() {
	echo '<div class="wrapper"><div class="row">';
}

function container_wrapper_end() {
	echo '</div></div>';
}

/**
 * Header
 */

function primary_navigation() {
	get_template_part('components/header/nav');
}

/**
 * Footer
 */

function footer_widgets() {
	get_template_part('components/footer/widgets');
}

function footer_menu() {
	get_template_part('components/footer/menu');
}