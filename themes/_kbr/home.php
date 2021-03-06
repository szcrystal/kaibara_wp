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
        
        $shop_id = isset($_GET['shop_id']) ? $_GET['shop_id'] : NULL;
        //echo $shop_id;
        //$count = get_option( 'posts_per_page', 10 );
    ?>

			<header class="page-header">
            	<h1 class="page-title"><i class="fa fa-stop"></i><?php if($shop_id) {
                	echo get_the_title($shop_id) . 'のブログ';
                } 
                else {
                    $obj = get_post_type_object('post'); //register_post_type、セットしたカスタム投稿の情報取得
                    echo '全てのブログ'/* . $obj->labels->name*/;
                } ?></h1>
				<?php //the_archive_title( '<h1 class="page-title">', '</h1>' );
                the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
                
			</header>
            
            <?php 
            if($shop_id) : 
            	$s_blog = new WP_Query(array(
        						'meta_key' => 'shop_id',
                                'meta_value' => $shop_id,
                                'post_type' => 'post',
                                //'posts_per_page' => 5,//Archiveページ内なので、post_per_pageを入れなくてもセットされる
                                'orderby'=>'date ID',
                                'order'=>'DESC',
                                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                                
                                ));
                if($s_blog->post_count == 0) {
                	$shopTitle = get_the_title($shop_id);
                	echo $shopTitle . "店のブログはまだありません。<br>";
                    echo $shopTitle . 'の店舗情報は<a href="'.get_the_permalink($shop_id).'" style="color:#06c;">こちら</a>';
                }
                else {
                    set_pagenation($s_blog);
                    
                    while ($s_blog->have_posts()) : $s_blog->the_post();
                        get_template_part( 'template-parts/content', 'archive' );
                    endwhile;
                    
                    set_pagenation($s_blog);
                }
                
            else :
            	if ( have_posts()) {
                    set_pagenation(); 
                    
                    while (have_posts()) : the_post();
                        get_template_part( 'template-parts/content', 'archive' );
                    endwhile;
                    
                    set_pagenation();
                }
                else {
                	echo "まだブログはありません。";
                }
			endif; 

			//the_posts_navigation();

		//else : //ポストがない時
		//	get_template_part( 'template-parts/content', 'none' );
		//endif; 
        
        wp_reset_query();
        ?>

		</main>
	</div>
    
<?php get_sidebar(); ?>

</div>
      <?php if($shop_id) { 
            //$shopID = get_post_meta($shop_id, 'shop_id', true);
            wp_reset_query();
            
            //global $post;
            //$post = get_post($shopID, 'OBJECT', 'display');
            $shop = new WP_Query(
            	array(
                   'page_id'=>$shop_id,
                   'post_type'=>'shop',
                   'posts_per_page'=>-1
                )
            );
            
            //global $post;
            //$post = get_post($shop_id);

             while ( $shop->have_posts() ) : 
                $shop->the_post();
                
                get_template_part( 'template-parts/content', 'shop' );
            endwhile;
    	} ?>

<?php
get_footer();

