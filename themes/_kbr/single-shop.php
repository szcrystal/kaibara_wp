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
            	
                <?php get_template_part( 'template-parts/content', 'shop'); ?>

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
                        
                                                
                        //親データのカスタムメタと一致するものをpostから取得
                        $blog_query = new WP_Query( //array('tag_id'=>$tagid[0], 'orderby'=>'date', 'order'=>'ASC')                 
                        	array(
                                'meta_key' => 'shop_id',
                                'meta_value' => $thisID,
                                //'post_parent'=> $thisID,
                                //'post_type' => 'blog',
                                'post_type' => 'post',
                                'posts_per_page' => 6,
                                'orderby'=>'date ID',
                                'order'=>'ASC',
                                'paged'=> get_query_var('paged') ? get_query_var('paged') : 1,
                            )
                        );
                        
						set_pagenation($blog_query);
                        ?>
                        
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
                                
                                ?>
                                <div style="background-image:url(<?php echo $feat_image_url; ?>);" class="attach-wrap">
                                	<a href="<?php the_permalink(); ?>"></a>
                                </div>
                                
                                <?php } else { ?>
                                	<div style="background:#f7f7f7; text-align:center; line-height:16em" class="attach-wrap">
                                		<a href="<?php the_permalink(); ?>">No Image</a>
                                	</div>
                                <?php } ?>
                            	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            	<?php 
                                	//the_excerpt(); 
                                	sz_content(65);
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

						//echo get_the_ID();
                    ?>
                    
                    <div class="map-wrap">
            			<div class="map">
                        	<?php 
                            $wp_query = new WP_Query(array('post_type'=>'shop', 'posts_per_page' => -1));            
            
            				while($wp_query->have_posts()) {
            					$wp_query->the_post();
                            	illustOutputDivAndImg('div', 'id', TRUE); 
                            }
                            wp_reset_query();
                            ?>
                    	</div>
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

		</main>
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
