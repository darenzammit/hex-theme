<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package hex
 */

namespace Hex;

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		
		while ( have_posts() ) : the_post();
			
			get_template_part( 'components/post/content', get_post_format());
		
		endwhile;

		navigation();

		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();