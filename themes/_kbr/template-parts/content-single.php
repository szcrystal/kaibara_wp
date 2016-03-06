<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <div class="entry-meta">
            <?php the_date(); ?>
        </div>
        <?php if(is_singular('news')) { ?>
            <span><a href="<?php echo home_url().'/'.get_post_type().'/'; ?>"><?php bloginfo('name'); ?>&nbsp;NEWS</a></span>
        <?php } 
        	elseif($shid = get_post_meta(get_the_ID(), 'shop_id', true)) { 
        	
        ?>
        	<span>店舗名：<a href="<?php echo get_permalink($shid); ?>"><?php echo get_the_title($shid); ?></a></span>
        <?php } ?>
        
        <h2><?php the_title(); ?></h2>
    </header>
    
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
        <?php _s_entry_footer(); ?>
    </footer>
</article>
