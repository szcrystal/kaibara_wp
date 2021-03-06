<?php
/**
 * The template for displaying all single posts.
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post(); ?>

			<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            	<div class="entry-member clear">
                    <header class="entry-header">
                        <?php

                        if ( 'post' === get_post_type() ) : ?>
                            <div class="entry-meta">
                                <?php _s_posted_on(); ?>
                            </div>
                        <?php
                        endif; ?>
                        <div class="clear">
                        	<img class="head-icon" src="<?php asset('images/icon-title.png'); ?>">
                        	<h2><?php the_title(); ?></h2>
                        </div>
                    </header><!-- .entry-header -->
                
                	<div>
                    	<?php the_post_thumbnail(); ?>
                    </div>
                    <div>
                    	<?php the_content(); ?>
					</div>
                </div>

				<?php 
                	$thisID = get_the_id();
                	wp_reset_postdata(); 
                ?>

                <div class="entry-blog clear">
                    <?php
//                        $posttags = get_the_tags();
//                        $tagid = array();
//                        if ($posttags) {
//                          foreach($posttags as $tag) {
//                            $tagid[] = $tag->term_id; 
//                          }
//                        }
                        
                        //global $query_string;
                        //タクソノミーを使用するのはどうか？
                        //query_posts(array('order'=>'DESC'));
                        
                        //親データのカスタムメタ
                        $metaValue = get_post_meta($thisID, 'shop_name', true);
                                                
                        //親データのカスタムメタと一致するものをpostから取得
                        $blog_query = new WP_Query( //array('tag_id'=>$tagid[0], 'orderby'=>'date', 'order'=>'ASC')                 
                        	array(
                                'meta_key' => 'shop_name',
                                'meta_value' => $metaValue,
                                'post_type' => 'post',
                                'posts_per_page' => 9,
                                'orderby'=>'date',
                                'order'=>'ASC',
                                'paged'=> get_query_var('paged') ? get_query_var('paged') : 1,
                            )
                        );
                        
                        ?>
                        
                        <div class="pagenation">
                        	<span style="color:tomato;">１ページ内に表示するブログの個数を６つにするか、９にするか or 12など？<br>ページネーションのデザインも必要</span>
                       		<?php set_pagenation($blog_query);?>
                        </div>
                        
                        <div class="clear">
                        
                        <?php
                        while ($blog_query->have_posts()) {
                        	$blog_query->the_post(); ?>
                            <article>
                            	<!--<div><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></div>-->
                                <?php 
                                if ( has_post_thumbnail() ) {
                                    $feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() );
                                    //echo $feat_image_url;
                                    //echo '<div style="background-image:url('.$feat_image_url.');" class="wrap-attach"></div>';
                                }
                                ?>
                                <div style="background-image:url(<?php echo $feat_image_url; ?>);" class="wrap-attach">
                                	<a href="<?php the_permalink(); ?>"></a>
                                </div>
                            	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            	<?php 
                                	//the_excerpt(); 
                                	sz_content(50);
                                ?>
                                <div>
                                	<?php the_time('Y年n月j日'); ?>
                                </div>
                            
                            </article>
                       
                       <?php } //endwhile ?>
                       
                       </div>
                       
                       <div class="pagenation">
                       		<?php
                        		set_pagenation($blog_query);
	                        	wp_reset_query();
                            ?>
                    	</div>
                    </div>
                    <?php 
//                        wp_link_pages( array(
//                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
//                            'after'  => '</div>',
//                        ) );
                    ?>
                    
                    <div class="map-back">
                    	<div style="top:<?php the_cf('y'); ?> left:<?php the_cf('x'); ?>" class="map-caption">
                			<a href="<?php __(the_permalink()); ?>"><?php echo mb_substr(get_the_title(), 0, 1); ?></a>
                		</div>
                    	<img src="<?php asset('images/map.png'); ?>">
                    </div>
                    
                

                <footer class="entry-footer">
                    <?php //_s_entry_footer(); ?>
                </footer><!-- .entry-footer -->
            </section><!-- #post-## -->

			<?php 
            	//the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
//			if ( comments_open() || get_comments_number() ) :
//				comments_template();
//			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
