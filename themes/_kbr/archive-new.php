<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>


<div class="blog-main clear">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
<?php if(isLocal()) echo __FILE__; ?>
		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
            	<h1 class="page-title"><i class="fa fa-square"></i>
                <?php 
                	$obj = get_post_type_object('news');
                    
                ?>
            	<?php bloginfo('name'); ?><?php echo $obj->label; ?>一覧</a></h1>
                </h1>
				<?php //the_archive_title( '<h1 class="page-title">', '</h1>' );
                the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
                
			</header>
            
            <?php 
                set_pagenation();
            	
                while (have_posts()) : the_post();
					get_template_part( 'template-parts/content', 'archive' );
            	endwhile;
                
                set_pagenation();
                

			//the_posts_navigation();

		else : //ポストがない時
			get_template_part( 'template-parts/content', 'none' );
		endif; 
        
        wp_reset_query();
        ?>

		</main>
	</div>
    
<?php get_sidebar(); ?>

</div>
      
<?php

get_footer();

