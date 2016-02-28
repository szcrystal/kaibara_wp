<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
    	<div class="footnavi">
        	<div>
    			<?php wp_nav_menu( array( /*'theme_location' => 'primary',*/ 'menu_id' => 'foot-menu' ) ); ?>
            </div>
        </div>
		<div class="site-info">
			<?php //bloginfo('name'); ?>
            <i class="fa fa-copyright"></i> 株式会社まちづくり柏原 All Rights Reserved
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<?php session_clear_onpage(); ?>

<span class="top_btn"><i class="fa fa-angle-up"></i></span>
</body>
</html>

<?php if(!isLocal()) getLog(); ?>
