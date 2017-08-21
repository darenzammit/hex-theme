<?php
/**
 * Hex functions and definitions.
 *
 * @package hex
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

namespace Hex;

/**
 * Hex Constants
 */

//wp_get_theme()->Version
define('HEX_VERSION', time());
define('HEX_PARENT_DIR', get_template_directory());
define('HEX_CHILD_DIR', get_stylesheet_directory());
define('HEX_PARENT_URL', get_template_directory_uri());
define('HEX_CHILD_URL', get_stylesheet_directory_uri());

/**
 * Hex Includes
 */
require_once __DIR__ . '/inc/setup.php';
require_once __DIR__ . '/inc/helpers.php';
require_once __DIR__ . '/inc/template-hooks.php';
require_once __DIR__ . '/inc/shortcodes.php';
require_once __DIR__ . '/inc/filters.php';
require_once __DIR__ . '/inc/search.php';
require_once __DIR__ . '/inc/admin.php';
require_once __DIR__ . '/inc/customizer.php';

