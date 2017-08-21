<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package hex
 */

namespace Hex;

?>		
			<?php do_action( 'hex_content_bottom' ); ?>
		</div><!-- #content -->
		<?php do_action('hex_after_content' ); ?>

		<?php do_action('hex_before_footer' ); ?>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php do_action('hex_footer' ); ?>
		</footer><!-- #colophon -->
		<?php do_action('hex_after_footer' ); ?>
	
	</div><!-- #page -->
	<?php do_action( 'hex_after_site' ); ?>

	<?php wp_footer(); ?>
</body>
</html>