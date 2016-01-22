<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header(); ?>

<div class="blog-main clear">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
<?php if(isLocal()) echo __FILE__; ?>
		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
                	$obj = get_post_type_object(get_post_type()); //register_post_type、セットしたカスタム投稿の情報取得
                    echo '<h1 class="page-title"><i class="fa fa-square"></i>' . $obj->labels->name . '一覧' . '<h1>';
					//the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
            //echo get_post_format(); 

			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'archive' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

</div>

<?php get_footer();


