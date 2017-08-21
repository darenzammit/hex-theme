<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package hex
 */

namespace Hex;


get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();
			
			do_action('storefront_single_post_before' );

			get_template_part( 'components/post/content', 'single' );

			do_action('storefront_single_post_after');
		
		endwhile;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'hex_sidebar' );
get_footer();