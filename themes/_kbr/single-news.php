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

 
    	//$thisID = get_the_id();
        //echo $thisID;
        
		endwhile; // End of the loop.
        
		//wp_reset_postdata();
        
        //the_post_navigation();
        //echo $shid;
        //global $wp_query;
        
        setSinglePagenation();
        
        /*
        $newsObj = new WP_Query(array(
                //'meta_key' => 'shop_id',
                //'meta_value' => $shid,
                'post_type' => 'news',
                'posts_per_page' => -1, //-1指定で全てを取得。指定なしだと管理画面オプションのposts_per_page指定が優先されるので注意
                'orderby'=>'date',
                'order'=>'ASC',
            ));

		//global $wpdb;
        //$s = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID > $thisID AND post_type='blog' order by 'ID' ASC LIMIT 1"); 
        // AND post_type='blog' order by 'ID' ASC
        

        $array = $newsObj->posts; //wp_query取得後の全postデータが入っているオブジェクト（配列として入っていて、そのval値がまたオブジェクト）
        //print_r($shop_blog);
        
        if(count($array) > 1) : 
        */
        ?>
        
        <!-- <nav class="navigation post-navigation" role="navigation">
			<h2 class="screen-reader-text">投稿ナビゲーション</h2>
			<div class="nav-links"> -->
        
            <?php
            /*
            foreach($array as $key => $val) : 
                
                if($val->ID == $thisID) {
                	//next_post_link();

                    if(isset($array[$key-1]))
                        echo '<div class="nav-previous"><a href="' . get_the_permalink($array[$key-1]->ID).'" rel="prev"><i class="fa fa-angle-double-left"></i>PREV</a></div>';
                        
                    if(isset($array[$key+1]))
                        echo '<div class="nav-next"><a href="' . get_the_permalink($array[$key+1]->ID).'" rel="next">NEXT<i class="fa fa-angle-double-right"></i></a></div>';
                }
                
            endforeach;
            */
        	?>
        	
           <!-- </div>
		</nav> -->
        
        <?php 
        	/*
            endif;
	        wp_reset_query();
            */
            //the_post_navigation();
        ?>

		</main>
	</div>
    
    <?php get_sidebar(); ?>

</div>
        
    

<?php

get_footer();
