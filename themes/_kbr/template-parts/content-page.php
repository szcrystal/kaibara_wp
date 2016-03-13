<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */


if(get_page_slug(get_the_ID()) == 'about') { //Aboutページ

    remove_filter('the_content', 'wpautop'); // !注意! Aboutページのみautopを消す
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<div class="yellow-back">
        <div class="clear">
        <header class="entry-header">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            <i class="fa fa-angle-down"></i>
        </header>
        
        <div class="entry-thumb">
            <?php the_post_thumbnail(); ?>

        </div>
        	<?php 
            	$content = get_the_content();
                $separator = "<!-- -->";
                
                $start = mb_strpos($content, $separator);
                $end = mb_strrpos($content, $separator); //strrpos 最後に現れる位置を返す
                
                $cont_one = mb_substr($content, $start, $end);
                $cont_two = mb_substr($content, $end);
                
                echo $cont_one;
            ?>
            
        </div>
        </div>
        <div class="entry-content">
        	<?php 
            	echo $cont_two;
            	//the_content();
            ?>
        
        </div>
	</article>

<?php  } 
else { //Aboutページ以外 
?> 

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

    <?php 
    if(get_post_meta(get_the_ID(), 'name_type', true) != '') { //inspect newshop contact
    ?>
    	<div class="entry-content">
        	<?php 
            	the_post_thumbnail(); 
            	the_content();
            ?>
        
        </div>
    <?php 
    } 
    else { //視察、出店、問い合わせ以外
    ?>
    
    <div class="entry-thumb">
    	<?php the_post_thumbnail(); ?>

    </div>
    
	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
				'after'  => '</div>',
			) );
		?>
	</div>
    
	<?php 
    } 
    
    } ?>
    
	<footer class="entry-footer">
		<?php
//			edit_post_link(
//				sprintf(
//					/* translators: %s: Name of current post */
//					esc_html__( 'Edit %s', '_s' ),
//					the_title( '<span class="screen-reader-text">"', '"</span>', false )
//				),
//				'<span class="edit-link">',
//				'</span>'
//			);
		?>
	</footer>
</article>
