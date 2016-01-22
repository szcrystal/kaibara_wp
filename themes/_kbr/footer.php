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
    	<?php wp_nav_menu( array( /*'theme_location' => 'primary',*/ 'menu_id' => 'foot-menu' ) ); ?>
        </div>
		<div class="site-info">
			制作・管理・株式会社まちづくり柏原
			<i class="fa fa-copyright"></i> 2016 All Rights Reserved
		</div>
	</footer>
</div><!-- #page -->

<?php session_clear_onpage(); ?>

<?php wp_footer(); ?>

</body>
</html>

<?php if(!isLocal()) getLog(); ?>
