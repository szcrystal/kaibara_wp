<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s
 */

get_header(); ?>

<div class="blog-main clear">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

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
        
    <div class="entry-member clear">
        <header class="entry-header">
            <?php
            	$shopID = get_post_meta(get_the_id(), 'shop_id', true);
				//echo $shopID;
                wp_reset_query();
                //wp_reset_postdata();
                global $post;
                $post = get_post($shopID);
                //$shop = new WP_Query(array('page_id'=>$shopID, 'post_type'=>'shop'));
                
            ?>

            <?php
//            	 while ( $shop->have_posts() ) : 
//            		$shop->the_post(); 
            ?>
            <div class="clear">
            	<img class="head-icon" src="<?php asset('images/icon-title.png'); ?>">
            	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
        </header>
    
        <div>
            <?php the_post_thumbnail(); ?>
        </div>
        <div>
            <?php echo $post->post_content; ?>
        </div>
        
        <?php //endwhile; ?>
    </div>

<?php

get_footer();
