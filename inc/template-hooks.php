<?php
/**
 * Hex hooks
 *
 * @package hex
 */

namespace Hex;

/**
 * Header
 */

add_action('hex_before_header', __NAMESPACE__ . '\\outdated_browser_alert', 1);
add_action('hex_header', __NAMESPACE__ . '\\primary_navigation');

/**
 * Content
 */

add_action('hex_content_top', __NAMESPACE__ . '\\container_wrapper_start',1);
add_action('hex_content_bottom', __NAMESPACE__ . '\\container_wrapper_end',99);

/**
 * Sidebar
 */

add_action('hex_content_bottom', __NAMESPACE__ . '\\get_sidebar');
add_action('hex_sidebar', __NAMESPACE__ . '\\dynamic_sidebar');

/**
 * Footer
 */


add_action('hex_footer', __NAMESPACE__ . '\\footer_widgets');
add_action('hex_footer', __NAMESPACE__ . '\\footer_menu');

/**
 * Posts
 */

add_action('hex_single_post_after', __NAMESPACE__ . '\\post_nav');
add_action('hex_single_post_after', __NAMESPACE__ . '\\display_comments');

/**
 * Pages
 */

add_action('hex_single_page_after', __NAMESPACE__ . '\\display_comments');