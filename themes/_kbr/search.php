<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package _s
 */

get_header(); ?>
<?php if(isLocal()) echo __FILE__; ?>

<div class="blog-main clear">
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
        set_pagenation();
        
		if ( have_posts() && (get_search_query() != '')  ) : 
        ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( '検索ワード「%s」: %d件', '_s' ), '<span>' . get_search_query() . '</span>', $wp_query->post_count ); ?></h1>
			</header>

			<?php

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'archive' );

			endwhile;

			//the_posts_navigation();
            set_pagenation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main>
	</section>

<?php get_sidebar(); ?>

</div>

<?php get_footer();



