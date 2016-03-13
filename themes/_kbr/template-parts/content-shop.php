<?php
/**
 * Template part for single-shop.php / home.php ? single.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

?>

<div class="entry-member clear">
    <header class="entry-header">
        <div class="clear">
        	<?php if(is_singular('shop')) : ?>
            	
                <h2><?php the_title(); ?></h2>
            
            <?php else : ?>
            	
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            
            <?php endif; ?>
            
        </div>
    </header>

    <div>
        <?php the_post_thumbnail(); ?>
    </div>
    
    <?php the_content(); 
    	//echo $post->post_content;
    ?>
    
</div>
