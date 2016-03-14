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
シングル
		<?php if(!have_posts()) echo 'error'; ?>
        
		<?php
		while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php

                    if ( 'post' === get_post_type() ) : ?>
                    <div class="entry-meta">
                        <?php the_date(); ?>
                    </div><!-- .entry-meta -->
                    <?php
                    endif; ?>
                    
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

    <?php the_post_navigation();
    
    	$thisID = get_the_id();

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
    
    <?php get_sidebar(); ?>

</div>
	<?php
    
    $posttags = get_the_tags();
    //print_r($posttags);
        $tagid = array();
        if ($posttags) {
          foreach($posttags as $tag) {
            $tagid[] = $tag->term_id; 
          }
        }
        
        ?>
        
        
    	<div class="entry-member clear">
        <header class="entry-header">
            <?php
            	$metaValue = get_post_meta($thisID, 'shop_name', true);
				
                $member_query = new WP_Query(
                	array(
                    	'meta_key' => 'shop_name',
                        'meta_value' => $metaValue, 
                        'post_type' => 'member', 
                        'posts_per_page'=>1
                        )
                    );
                
                while($member_query-> have_posts()) {
                	$member_query->the_post();
            ?>

            <?php
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
        
        <?php } ?>
    </div>

<?php

get_footer();
