<div class="footer-menu">
	<div class="wrapper">
		<?php
		if (has_nav_menu('footer')) {
			wp_nav_menu(['theme_location' => 'footer', 'menu_class' => 'menu']);
		}
		?>
	</div>
</div>