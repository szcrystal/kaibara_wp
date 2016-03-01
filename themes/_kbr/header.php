<?php
/**
 * The header for our theme.
 *
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<?php wp_head(); ?>
<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jq.script.js"></script>
</head>

<body <?php body_class(); ?>>
<div id="page" <?php addMainClass(); ?>>

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', '_s' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
    	
		<div class="site-branding">
			<?php
			//if ( is_front_page() && is_home() ) : 
            ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="/wp-content/themes/_kbr/images/logo.png" alt="丹波の城下町で仕事をつくる"></a></h1>
                <h2><?php bloginfo('description'); ?></h2>
                <a href="https://www.facebook.com/まちづくり柏原-153037668187188/" class="fb" target="_brank"><i class="fa fa-facebook-square"></i></a>
                
                <span class="tgl"><i class="fa fa-bars"></i></span>                
		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<!--<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', '_s' ); ?></button> -->
            
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'head-menu' ) ); ?>

		</nav>
	</header>

	<div id="content" class="site-content">
