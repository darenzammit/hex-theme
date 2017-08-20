<?php

namespace Hex\Search;

add_action('pre_get_posts', __NAMESPACE__ . '\\add_search_type_filter');

/**
 * Add search type filter
 */
function add_search_type_filter($query) {
	if (!is_admin() && $query->is_main_query()) {
		if ($query->is_search && isset($_GET['type'])) {
			if ('posts' == $_GET['type']) {
				$query->set('post_type', array('post', 'page'));
			}
			if ('products' == $_GET['type']) {
				$query->set('posts_per_page', apply_filters('loop_shop_per_page', get_option('posts_per_page')));
				$query->set('post_type', array('product'));
			}
		}
	}
}