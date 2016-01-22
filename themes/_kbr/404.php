<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _s
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'ページが見つかりませんでした 404', '_s' ); ?></h1>
				</header>

				<div class="page-content">
					<p>お探しのページが見つかりませんでした。<br>TOPページに戻るか、各リンクよりお入り直し下さい。</p>
                    
                    <div>
                    	<a href="<?php echo home_url(); ?>" class="btn"><i class="fa fa-home"></i>HOME</a>
                    </div>

					
					<?php
						//get_search_form();
						//the_widget( 'WP_Widget_Recent_Posts' );
					?>

				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
