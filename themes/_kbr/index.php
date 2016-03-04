<?php
/**
Template Name: Top
 */

get_header(); 

//if(isLocal()) echo __FILE__; 
?>

	<div id="primary" class="content-area">
        <main id="main" class="site-main wrap" role="main">
            <div>
                <?php
                if ( have_posts() ) :

                    while ( have_posts() ) : the_post(); ?>
                    
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                            	<?php 
                                	$title = get_the_title();
                                	$elem = mb_strpos($title, 'ー');
                                    $str[0] = mb_substr($title, 0, $elem);
                                    $str[1] = mb_substr($title, $elem);
                                    $title = $str[0] . '<br><span>' . $str[1] . '</span>';
                                ?>
                            
                            	<h1 class="entry-title"><?php echo $title; ?></h1>
								<?php //the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                                
                            </header>

                            <div class="entry-content">
                            	
                                <?php
                                    the_content(); ?>
                                
                                    
                                 <?php wp_link_pages( array(
                                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
                                        'after'  => '</div>',
                                    ) );
                                ?>
                                
                            </div>

                            <footer class="entry-footer">
                                <?php //_s_entry_footer(); ?>
                            </footer>
                        </article>

                    <?php 
                    	endwhile;
	                    the_posts_navigation();

                endif;
                
                wp_reset_postdata();
                
                ?>
                
            </div>
        </main>
            
        <div class="map-wrap">
            <h2>STORY<i class="fa fa-caret-down"></i></h2>
            <div class="map">
                <?php 
                //$query = get_page_by_path('honon',OBJECT,'member'); 
                //<div class="map-caption"><a href="echo $query->guid;">A</a></div>
            
                $isFront = is_front_page(); //クエリ取得後だと無効になるのでクエリ前に
                
                $wp_query = new WP_Query(array('post_type'=>'shop', 'posts_per_page' => -1));            
                
                while($wp_query->have_posts()) {
                    $wp_query->the_post();
                    //global $post;
                    //echo get_the_id() ."<br>custom:";
                    //echo get_post_meta(get_the_id(), 'x', true);
                    
                    //$slug = get_post_meta(get_the_id(), 'shop_name', true);
                    //$attachment = get_posts(array('post_title'=>$slug, 'post_type'=>'attachment', 'posts_per_page'=>1 ));
                    //$obj = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE post_title='{$slug}' AND post_excerpt='{$slug}' AND post_type='attachment' LIMIT 1");

    //                foreach($attachment as $p) {
    //                	$aid = $p->ID;
    //                }
                    //echo urldecode(get_permalink());
                    
                    illustOutputDivAndImg('div', 'id', $isFront); 
                    
                } 
                
                wp_reset_query();
                //WP_Queryを消す時はreset_query、元々のglobal $post (have_posts)を消す時はreset_postdata か
                ?>
                
            </div>
        </div>
            
        <div class="wrap">
            <div class="clear">
                <?php
                $query = new WP_Query( //array('tag_id'=>$tagid[0], 'orderby'=>'date', 'order'=>'ASC')                 
                                array(
                                    'post_type' => array('shop', 'post', 'news'),
                                    'post_status' => 'publish',
                                    //'post_type' => 'post',
                                    'posts_per_page' => 10,
                                    'orderby'=>'date',
                                    'order'=>'DESC',
                                    //'paged'=> get_query_var('paged') ? get_query_var('paged') : 1,
                                )
                            );
    //            wp_reset_query();
    //            
    //            $b_query = new WP_Query( //array('tag_id'=>$tagid[0], 'orderby'=>'date', 'order'=>'ASC')                 
    //                        	array(
    //                                'post_type' => 'post',
    //                                //'posts_per_page' => 9,
    //                                'orderby'=>'date',
    //                                'order'=>'ASC',
    //                                //'paged'=> get_query_var('paged') ? get_query_var('paged') : 1,
    //                            )
    //                        );
    //            wp_reset_query();
                
                //$ar = array_merge(array('aaa', 'bbb'), array('aaa', 'bbb'));
                //print_r($query);
                
                ?>
                
                <section class="news">
                    <h2>NEWS</h2>
                    <?php while ( $query->have_posts() ) : 
                        $query->the_post(); 
                        global $post; ?>
                        
                    <article>
                        <div class="entry-meta"><?php the_time('Y年n月j日'); ?></div>

                        <?php if($post->post_type == 'news') { ?>
                    
                            <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                            <p><a href="<?php the_permalink(); ?>"><?php sz_content(50); ?></a></p>
                    
                    	<?php } 
                        	else if($post->post_type == 'post') { 
                            	$shopid = get_post_meta($post->ID, 'shop_id', true); 
                            	if($shopid) { ?>
                        
                                	<h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title($shopid); ?> 店のブログが更新されました。</a></h3>
                                <?php } else { ?>
                                	<h3><a href="<?php the_permalink(); ?>">ブログが更新されました。</a></h3>
                    			<?php } ?>
                                <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?> <i class="fa fa-angle-double-right"></i></a></p>
		
                        <?php } 
                            else if($post->post_type == 'shop') { ?>
                        
                            <h3><a href="<?php the_permalink(); ?>">新しい店舗が追加されました。</a></h3>
                            <p><a href="<?php the_permalink(); ?>">店舗名：<?php the_title(); ?> <i class="fa fa-angle-double-right"></i></a></p>                        
                    <?php } ?>
                    
                    </article>
                    <?php
                        endwhile;
                        wp_reset_query();
                    ?>
                    
                </section>
                
            <section>
                <div>
                    <a href="<?php outputUrl('inspect'); ?>"><img src="<?php asset('images/toInspect.png'); ?>"></a>
                </div>
                <div>
                    <a href="<?php outputUrl('newshop'); ?>"><img src="<?php asset('images/toNewshop.png'); ?>"></a>
                </div>
            </section>
            
            </div>
        </div>
            
            
        <div class="gmap">
            <h2>OUR TOWN -kaibara-<i class="fa fa-caret-down"></i></h2>
            <div>
            <?php if(! isLocal()) { ?>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1631.5632527146809!2d135.07788415357618!3d35.12851648466227!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sja!2sjp!4v1452397024308" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
            <?php } ?>
            </div>
        </div>
        
	</div><!-- #primary -->

<?php
get_footer();

