<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
 
if(isNameAdmin()) echo get_the_ID();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <div class="entry-meta">
            <?php the_time('Y年n月j日'); ?>
        </div>
        
        <?php if($shopid = get_post_meta(get_the_ID(), 'shop_id', true)) { ?>
        	
            <span>店舗名：<a href="<?php the_permalink($shopid); ?>"><?php echo get_the_title($shopid); ?></a></span>
        <?php } ?>
        
        <h3 class="clear"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    </header>

    <div class="entry-content clear">
    
    	<?php if (has_post_thumbnail()) { ?>
    	<div class="archive-attach-wrap">
        	<?php 
            	echo '<a href="' . get_the_permalink() . '">';
            	//if (has_post_thumbnail()) 
                	the_post_thumbnail('archive');
                    //echo '<div style="background-image:url('. wp_get_attachment_url(get_post_thumbnail_id() ).');" class="archive-attach-wrap"></div>';
                //else 
                //	echo 'No Image';
                
                echo '</a>';
            ?>
        </div>
        <?php } ?>
        
        <div class="archive-content-wrap">
        <?php
            sz_content(135);

            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
                'after'  => '</div>',
            ) );
        ?>
            
            <footer class="entry-footer">
                <?php 
                    if(get_post_type() == 'post') 
                        _s_entry_footer(); 
                ?>
            </footer>
    </div>

    
</article>
