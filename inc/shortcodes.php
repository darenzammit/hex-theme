<?php

/**
 * Theme Shortcodes
 * 
 * @link https://developer.wordpress.org/plugins/shortcodes/
 */

namespace Hex\Shortcodes;

add_shortcode('button', __NAMESPACE__ . '\\button');

function button($atts) {
	extract(shortcode_atts(array('href' => '#', 'class' => 'btn-primary', 'label' => 'Click here', 'target' => '_blank'), $atts));
	return wp_sprintf('<a href="%s" class="btn %s" target="%s">%s</a>', $href, $class, $target, $label);
}