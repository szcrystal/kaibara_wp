<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header(); ?>

<div class="blog-main clear">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
<?php if(isLocal()) echo __FILE__; ?>
    <?php
        //$shid = get_post_meta(get_the_ID(), 'shop_id', true);
        
		while ( have_posts() ) : the_post(); 
        
        	get_template_part( 'template-parts/content', 'single' );
        
		endwhile; 
        
        //the_post_navigation();
        
		setSinglePagenation();

        if ( isComment()/* && (comments_open() || get_comments_number())*/ ) :
            comments_template();
        endif;
            
    ?>

		</main>
	</div>
    
    <?php get_sidebar(); ?>

</div>

    <?php
        wp_reset_query(); //get_the_ID()前に一旦リセットしないとID取得が出来ない sidebarがあるため
                    
        $shopID = get_post_meta(get_the_ID(), 'shop_id', true);
        
        //wp_reset_postdata();                
        
        //global $post;
        //$post = get_post($shopID);
        $shop = new WP_Query(
        	array(
               'page_id'=>$shopID,
               'post_type'=>'shop',
               'posts_per_page'=>-1
            )
        );
        

        while ( $shop->have_posts() ) :
            $shop->the_post();
            
            get_template_part( 'template-parts/content', 'shop' );
        endwhile;
    ?>

<?php

get_footer();

