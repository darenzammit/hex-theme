<?php

namespace Hex;

add_filter('body_class', __NAMESPACE__ . '\\body_class');
add_filter('post_thumbnail_html', __NAMESPACE__ . '\\default_thumbnail', 10, 5);
add_filter('wp_pagenavi', __NAMESPACE__ . '\\wp_pagenavi_markup');
add_filter('widget_nav_menu_args', __NAMESPACE__ . '\\social_menu_args', 10, 3);

/**
 * Add <body> classes
 */
function body_class(array $classes) {

	// Add page slug if it doesn't exist
	if (is_single() || is_page() && !is_front_page()) {
		if (!in_array(basename(get_permalink()), $classes)) {
			$classes[] = basename(get_permalink());
		}
	}

	//add sidebar
	if (display_sidebar()) {
		$classes[] = 'sidebar-primary';
	}

	return $classes;
}

/**
 * Default Thumbnail
 */
function default_thumbnail($html, $post_id, $post_thumbnail_id, $size, $attr) {
	//copy from other WP function to output all atts
	$class = empty($attr['class']) ? "" : sprintf('class="%s"', $attr['class']);
	if (!$post_thumbnail_id && !is_single()) {
		$images = array(
			"/dist/img/default-{$size}.png",
			"/dist/img/default.png",
		);
		foreach ($images as $image) {
			if (is_file(HEX_CHILD_DIR . $image)) {
				$src  = HEX_CHILD_URL . $image;
				$html = "<img src=\"{$src}\" alt=\"\" {$class}>";
				break;
			}
		}
	}
	return $html;
}

/**
 * Default image cropping
 */
add_filter('pre_option_medium_crop', '__return_true');

/**
 *  Gallery Settings
 */

add_filter('use_default_gallery_style', '__return_false');

add_filter('media_view_settings', function ($settings) {
	$settings['galleryDefaults']['link']    = 'file';
	$settings['galleryDefaults']['columns'] = '4';
	return $settings;
});

/**
 * Excerpt Settings
 */
add_filter('excerpt_length', function () {
	return 33;
});

add_filter('excerpt_more', function () {
	return '&hellip;';
});

/**
 * More link
 */
add_filter('the_content_more_link', function ($html, $more_link_text) {
	$html = '<a class="more-link btn" href="' . get_permalink() . '">' . $more_link_text . '</a>';
	return $html;
}, 10, 2);

/**
 * WP Pagenavi bootstrap formatting
 */
function wp_pagenavi_markup($html) {
	$out = '';
	$out = str_replace("<div", "", $html);
	$out = str_replace("class='wp-pagenavi'>", "", $out);
	$out = str_replace("<a", "<li><a", $out);
	$out = str_replace("</a>", "</a></li>", $out);
	$out = str_replace("<span class='current'>", "<li class='active'><a href='#'>", $out);
	$out = str_replace("</span></a>", "</a></li>", $out);
	$out = str_replace("</div>", "", $out);
	$out = str_replace("<span", "<li><span", $out);
	$out = str_replace("</span>", "</span></li>", $out);
	return "<ul class=\"pagination\">{$out}</ul>";
}

/**
 * Modify Widget Menu args
 */
function social_menu_args($nav_menu_args, $nav_menu, $args) {
	if ($args['id'] == 'sidebar-header' && $nav_menu->slug == 'social') {
		$nav_menu_args['link_before'] = '<span class="screen-reader-text">';
		$nav_menu_args['link_after']  = '</span>';
	}
	return $nav_menu_args;
}
