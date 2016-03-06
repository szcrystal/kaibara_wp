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
        $shid = get_post_meta(get_the_ID(), 'shop_id', true);
        
		while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">

                    
                    <div class="entry-meta clear">
                        <?php the_date(); ?>
                        <span style="float:right;">店舗名：<?php echo get_the_title($shid); ?></span>
                    </div><!-- .entry-meta -->

                    
                    <h2><?php the_title(); ?></h2>
                    
                </header><!-- .entry-header -->
                
                <div>
                    <?php the_post_thumbnail(); ?>
                </div>

                <div class="entry-content">
                    <?php
                        the_content( sprintf(
                            /* translators: %s: Name of current post. */
                            wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', '_s' ), array( 'span' => array( 'class' => array() ) ) ),
                            the_title( '<span class="screen-reader-text">"', '"</span>', false )
                        ) );

                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
                            'after'  => '</div>',
                        ) );
                    ?>
                </div>
    

                <footer class="entry-footer">
                    <?php //_s_entry_footer(); ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-## -->

    <?php 
    	$thisID = get_the_id();
        //echo $thisID;
        
		endwhile; // End of the loop.
        
		wp_reset_postdata();
        
        //the_post_navigation();
        //echo $shid;
        //global $wp_query;
        
        $shop_blog = new WP_Query(array(
                'meta_key' => 'shop_id',
                'meta_value' => $shid,
                'post_type' => 'blog',
                'posts_per_page' => -1, //-1指定で全てを取得。指定なしだと管理画面オプションのposts_per_page指定が優先されるので注意
                'orderby'=>'date',
                'order'=>'ASC',
            ));

		//global $wpdb;
        //$s = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID > $thisID AND post_type='blog' order by 'ID' ASC LIMIT 1"); 
        // AND post_type='blog' order by 'ID' ASC
        

        $array = $shop_blog->posts; //wp_query取得後の全postデータが入っているオブジェクト（配列として入っていて、そのval値がまたオブジェクト）
        //print_r($shop_blog);
        
        if(count($array) > 1) : ?>
        
        <nav class="navigation post-navigation" role="navigation">
			<h2 class="screen-reader-text">投稿ナビゲーション</h2>
			<div class="nav-links">
        
            <?php
            foreach($array as $key => $val) : 
                
                if($val->ID == $thisID) {
                	//next_post_link();

                    if(isset($array[$key-1]))
                        echo '<div class="nav-previous"><a href="' . get_the_permalink($array[$key-1]->ID).'" rel="prev"><i class="fa fa-angle-double-left"></i>PREV</a></div>';
                        
                    if(isset($array[$key+1]))
                        echo '<div class="nav-next"><a href="' . get_the_permalink($array[$key+1]->ID).'" rel="next">NEXT<i class="fa fa-angle-double-right"></i></a></div>';
                }
                
            endforeach;
        	?>
        	
            </div>
		</nav>
        
        <?php 
        	endif;
	        wp_reset_query();
            
            //the_post_navigation();
        ?>

		</main><!-- #main -->
	</div><!-- #primary -->
    
    <?php get_sidebar(); ?>

</div>
        
    	<div class="entry-member clear">
        <header class="entry-header">
            <?php
            	$shopID = get_post_meta($thisID, 'shop_id', true);
				//echo $shopID;
                //global $post;
                //$post = get_post($shopID, 'OBJECT', 'display');
                $shop = new WP_Query(array('page_id'=>$shopID, 'post_type'=>'shop'));
                
            ?>

            <?php
            	 while ( $shop->have_posts() ) : 
            		$shop->the_post(); 
            ?>
            <div class="clear">
            	<img class="head-icon" src="<?php asset('images/icon-title.png'); ?>">
            	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
        </header><!-- .entry-header -->
    
        <div>
            <?php the_post_thumbnail(); ?>
        </div>
        <div>
            <?php the_content(); ?>
        </div>
        
        <?php endwhile; ?>
    </div>

<?php

get_footer();
