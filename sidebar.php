<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package hex
 */

namespace Hex;

?>

<div id="secondary" class="widget-area" role="complementary">
	<?php
	do_action( 'hex_before_sidebar_widget_area' );
	do_action( 'hex_sidebar' );
	do_action( 'hex_after_sidebar_widget_area' );
	?>
</div><!-- #secondary -->