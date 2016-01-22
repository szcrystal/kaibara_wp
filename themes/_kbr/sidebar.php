<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
    
    
        
    <?php 
//    	if(isset($_GET['shop_id'])) {
//        	$link = home_url(get_post_type().'/');
//            $text = '全てのブログ一覧';
//        }
//        else {
//        	if(is_singular(get_post_type())) {
//            	$shopid = get_post_meta(get_the_ID(), 'shop_id', true);
//            	$link = get_post_type() . '?shop_id=' . $shopid;
//            	$link = home_url($link);
//                
//                $text = get_the_title($shopid).'の全てのブログ';
//            }
//            else {
//            	$text = 'aaa';
//            }
//
//        }
        
//        <section>
//    	<h2 class="widget-title">店舗別ブログ一覧</h2>
//        <div class="menu-side-menu-container">
//        <ul id="menu-side-menu" class="menu">
//        
//        $objs = new WP_Query( array('post_type'=>'shop','orderby'=>'data','order'=>'DESC',)); //or $wpdb->getrow()で
//    	$objs = $objs->posts;
//        
//        $linkFormat = '<li><a href="%s">%sのブログ</a></li>';
//        
//        printf($linkFormat, home_url('blog/'), '全て');
//        
//        foreach($objs as $obj) {
//        	$link = 'blog?shop_id=' . $obj->ID;
//            $link = home_url($link);
//        	//echo '<li><a href="'. $link .'">'. $obj->post_title .'のブログ</a></li>';
//            printf($linkFormat, $link, $obj->post_title);
//        }
//        
//        </ul>
//        </div>
//    	</section>
    ?>
      <?php //wp_get_archives('type=monthly&post_type=blog'); ?>
      <?php //wp_get_archives('type=calender&post_type=blog'); ?>  
</aside><!-- #secondary -->


