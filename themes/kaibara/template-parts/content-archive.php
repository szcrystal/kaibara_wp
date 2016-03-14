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
            <?php the_time('Y年n月j日'); ?>
        </div>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        
        <?php if($shopid = get_post_meta(get_the_ID(), 'shop_id', true)) { ?>
            <h4><a href="<?php the_permalink($shopid); ?>"><?php echo get_the_title($shopid); ?></a></h4>
        <?php } ?>
        
    </header>

    <div class="entry-content clear">
        <?php the_post_thumbnail(); ?>
        <?php
            sz_content(150);

            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
                'after'  => '</div>',
            ) );
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php //_s_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article>
