<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package hex
 */
?><!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php wp_head() ?>
</head>
<body>
	
	<?php do_action( 'hex_before_site' ); ?>
	<div id="page" class="site">

		<!--[if IE]>
	      <div id="outdated-browser-alert">
	        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'hex');?>
	      </div>
	    <![endif]-->

	    <?php do_action( 'hex_before_header' ); ?>
		<header id="masthead" class="site-header" role="banner">
			<?php do_action( 'hex_header' ); ?>
		</header><!-- #masthead -->
		<?php do_action( 'hex_after_header' ); ?>
		
		<?php do_action('hex_before_content' ); ?>
		<div id="content" class="site-content" tabindex="-1">
			<?php do_action( 'hex_content_top' ); ?>