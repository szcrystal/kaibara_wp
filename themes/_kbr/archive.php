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
                	$postType = get_post_type();
                	if($postType == 'shop' || $postType == 'news') {
                
                		$obj = get_post_type_object($postType); //register_post_type、セットしたカスタム投稿の情報取得
                    	echo '<h1 class="page-title"><i class="fa fa-square"></i>' . $obj->labels->name . '一覧' . '<h1>';
						//the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
                    }

                    else {
						the_archive_title( '<h1 class="page-title"><i class="fa fa-square"></i>', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
                    }
				?>
			</header>

			<?php
            set_pagenation();

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'archive' );

			endwhile;

			set_pagenation();
			//the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main>
	</div>

<?php get_sidebar(); ?>

</div>

<?php
get_footer();
