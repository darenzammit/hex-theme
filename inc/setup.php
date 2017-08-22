<?php

namespace Hex;

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_styles');
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts');
add_action('after_setup_theme', __NAMESPACE__ . '\\theme_setup');
add_action('widgets_init', __NAMESPACE__ . '\\register_sidebars');

/**
 * Theme Styles
 */
function enqueue_styles() {

	/**
	 * Google Fonts
	 */

	$google_fonts = apply_filters('hex_google_font_families', array(
		'source-sans-pro' => 'Source+Sans+Pro:400,300,300italic,400italic,600,700,900',
	));

	if (!empty($google_fonts)) {
		
		$query_args = array(
			'family' => implode('|', $google_fonts),
			'subset' => urlencode('latin,latin-ext'),
		);

		$fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');

		wp_enqueue_style('hex-fonts', $fonts_url, [], null);
	}

	/**
	 * Base Style
	 */

	if (apply_filters('hex_load_css', true)) {
		wp_enqueue_style('hex-css', HEX_PARENT_URL . '/dist/css/hex.css', [], HEX_VERSION);
	}

	/**
	 * Child Style
	 */

	if (is_child_theme()) {
		wp_enqueue_style('hex-child-css', HEX_CHILD_URL . '/dist/css/main.css', [], wp_get_theme()->Version);
	}

}
/**
 * Theme Scripts
 */
function enqueue_scripts() {

	/**
	 * Base Scripts
	 */
	if (apply_filters('hex_load_js', true)) {
		wp_enqueue_script('hex-js', HEX_PARENT_URL . '/dist/js/hex.js', [], HEX_VERSION, true);
	}

	/**
	 * Child Style
	 */

	if (is_child_theme()) {
		wp_enqueue_script('hex-child-js', HEX_CHILD_URL . '/dist/js/main.js', [], wp_get_theme()->Version, true);
	}

	/**
	 * Comments
	 */
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

}

/**
 * Theme setup
 */
function theme_setup() {

	/**
	 * Enable features from Soil when plugin is activated
	 * @link https://roots.io/plugins/soil/
	 */
	add_theme_support('soil-clean-up');
	add_theme_support('soil-nav-walker');
	add_theme_support('soil-nice-search');
	add_theme_support('soil-relative-urls');

	/**
	 * Enable Google analytics
	 * @link https://github.com/roots/soil/wiki/Google-Analytics
	 */
	if ($ga = get_option('hex_google_analytics')) {
		$hook = get_option('hex_google_analytics_wp_head') ? 'wp_head' : 'wp_footer';
		add_theme_support('soil-google-analytics', $ga, $hook);
	}

	/**
	 * Enable plugins to manage the document title
	 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
	 */
	add_theme_support('title-tag');

	/**
	 * Register navigation menus
	 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
	 */
	register_nav_menus(apply_filters('hex_nav_menus', [
		'primary' => __('Primary', 'hex'),
		'mobile'  => __('Mobile', 'hex'),
		'social'  => __('Social Links', 'hex'),
		'footer'  => __('Footer', 'hex'),
	]));

	/**
	 * Add support for core custom logo.
	 * @link https://developer.wordpress.org/themes/functionality/custom-logo/
	 */
	add_theme_support('custom-logo', [
		'height'      => 200,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	]);

	/**
	 * Enable post thumbnails
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');
	add_image_size('xl', 1600, 900);

	/**
	 * Enable HTML5 markup support
	 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
	 */
	add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

	/**
	 * Enable selective refresh for widgets in customizer
	 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
	 */
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Starter content allows themes to define suggested settings, pages, widgets, and menus on new WordPress installations.
	 * You can customize the starter content in order to best suit your theme.
	 * @link https://make.wordpress.org/core/2016/11/30/starter-content-for-themes-in-4-7/
	 */
	add_theme_support('starter-content', []);

	/**
	 * Add Excerpt to pages
	 */
	add_post_type_support('page', 'excerpt');

}

/**
 * Register sidebars
 */
function register_sidebars() {

	$config = [
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	];

	$sidebars = [
		'sidebar-primary' => __('Primary', 'hex'),
		'sidebar-header'  => __('Header', 'hex'),
		'sidebar-footer'  => __('Footer', 'hex'),
	];

	if (class_exists('woocommerce')) {
		$sidebars['sidebar-shop'] = __('Shop', 'hex');
	}

	$sidebars = apply_filters('hex_sidebars', $sidebars);

	foreach ($sidebars as $id => $name) {
		register_sidebar([
			'id'   => $id,
			'name' => $name,
		] + $config);
	}

}

/**
 * Add API key to ACF gmaps
 */
add_filter('acf/fields/google_map/api', function ($api) {
	if ($key = get_option('hex_google_maps_api_key')) {
		$api['key'] = $key;
	}
	return $api;
});