<div class="site-header-nav">
	<div class="wrapper">
		<div class="site-header-brand"><?php Hex\brand(); ?></div>
		<div class="site-header-mobile-nav"><button class="nav-mobile btn btn-outline-white sitepanel-toggle" data-toggle="menu"><i class="icon-menu"></i></button></div>
		<?php if (has_nav_menu('primary')): ?>
			<nav class="nav-primary"><?php wp_nav_menu(['theme_location' => 'primary', 'menu_class' => 'menu menu-dropdown']); ?></nav>
		<?php endif ?>
	</div>
</div>