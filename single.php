<?php
/**
 * The template for displaying all single posts
 *
 * @package hex
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

namespace Hex;

get_header();?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while (have_posts()): the_post();

			do_action('hex_single_' . get_post_type() . '_before');

			get_template_part('components/post/content', 'single');

			do_action('hex_single_' . get_post_type() . '_after');

		endwhile;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();