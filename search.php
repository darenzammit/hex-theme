<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package hex
 */

namespace Hex;

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<header class="page-header">
				<h1 class="page-title"><?php
					printf(
						have_posts() 
						? esc_html(__( 'Search Results for: %s', 'hex' ), '<span>' . get_search_query() . '</span>')
						: __('Nothing Found', 'hex' )
					);
				?></h1>
			</header><!-- .page-header -->

		<?php
		if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include thefile
				 * component/global/content-search.php and that will be used instead.
				 */
				get_template_part( 'components/post/content', 'entry' );
			endwhile;
			the_posts_navigation();

		else :
			get_template_part( 'components/post/content', 'none' );
		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();