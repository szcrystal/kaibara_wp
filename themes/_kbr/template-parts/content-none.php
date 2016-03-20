<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

?>

<section class="no-results not-found">
	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', '_s' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>
        
        	<header class="page-header">
                <h1 class="page-title"><i class="fa fa-stop"></i><?php esc_html_e( '記事が見つかりません', '_s' ); ?></h1>
            </header>

			<p><?php printf( esc_html__( '検索ワード「%s」に該当する記事がありませんでした。別のワードを指定して下さい。', '_s' ), '<span>' . get_search_query() . '</span>' ) ?></p>
			<?php
				get_search_form();

		else : ?>

			<p><?php esc_html_e( '記事がありません。', '_s' ); ?></p>
			<?php
				//get_search_form();

		endif; ?>
        
	</div>
</section>
