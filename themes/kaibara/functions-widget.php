<?php

/**
 * Adds Foo_Widget widget.
 */
class AllBlogByShopWidget extends WP_Widget {

	/**
	 * WordPress でウィジェットを登録
	 */
	function __construct() {
		parent::__construct(
			'blog_by_shop', // Base ID
			__( '店舗別ブログ一覧', 'text_domain' ), // Name
			array( 'description' => __( '店舗別ブログ一覧を表示します。', 'text_domain' ), ) // Args
		);
	}

	/**
	 * ウィジェットのフロントエンド表示
	 * @see WP_Widget::widget()
	 * @param array $args     ウィジェットの引数
	 * @param array $instance データベースの保存値
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget']; //<section>
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
        //メイン部分 ----------
        $objs = new WP_Query( array('post_type'=>'shop','orderby'=>'date','order'=>'DESC',));
    	$objs = $objs->posts;
        
        $linkFormat = '<li><a href="%s">%sのブログ</a></li>';
        
        echo '<ul id="menu-side-menu" class="menu">'. "\n";
        printf($linkFormat, home_url('blog/'), '全て');
        
        foreach($objs as $obj) {
        	$link = 'blog?shop_id=' . $obj->ID;
            $link = home_url($link);
        	//echo '<li><a href="'. $link .'">'. $obj->post_title .'のブログ</a></li>';
            printf($linkFormat, $link, $obj->post_title);
        }
        echo "</ul>\n";
        //メインEND ---------
        
		echo $args['after_widget'];
	}

	/**
	 * バックエンドのウィジェットフォーム
	 * @see WP_Widget::form()
	 * @param array $instance データベースからの前回保存された値
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '店舗別ブログ一覧', 'text_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'タイトル:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * ウィジェットフォームの値を保存用にサニタイズ
	 * @see WP_Widget::update()
	 * @param array $new_instance 保存用に送信された値
	 * @param array $old_instance データベースからの以前保存された値
	 * @return array 保存される更新された安全な値
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Foo_Widget



class RecentPostWidget extends WP_Widget {

	/**
	 * WordPress でウィジェットを登録
	 */
	function __construct() {
		parent::__construct(
			'custom_recent_posts', // Base ID
			__( '最近の投稿 For Kaibara', 'text_domain' ), // Name
			array( 'description' => __( '最近の投稿を表示します。', 'text_domain' ), ) // Args
		);
	}

	/**
	 * ウィジェットのフロントエンド表示
	 * @see WP_Widget::widget()
	 * @param array $args     ウィジェットの引数
	 * @param array $instance データベースの保存値
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget']; //<section>
        
        $getshop = isset($_GET['shop_id']) ? $_GET['shop_id'] : NULL;
		
        if ( ! empty( $instance['title'] ) ) {
        	if($getshop)
				echo $args['before_title'] . apply_filters( 'widget_title', get_the_title($getshop).'の'.$instance['title'] ). $args['after_title'];
            else
            	echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
        //メイン部分 ----------
        $linkFormat = '<li><a href="%s">%s</a></li>';
        echo '<ul id="menu-side-menu" class="menu">'. "\n";
        
        if(is_singular('blog') || $getshop) {
        	
        	$shopid = $getshop ? $getshop : get_post_meta(get_the_ID(), 'shop_id', true);
            //echo get_post_type();
            
            $objs = new WP_Query(
            	array(
                	'meta_key' => 'shop_id',
                    'meta_value' => $shopid,
                	'post_type' => get_post_type(),
                    'posts_per_page' => 5,
                    'orderby'=>'date',
                    'order'=>'DESC',
                )
            );
            //print_r($objs);
        }
        else {
        	$objs = new WP_Query(
            	array(
                	'post_type' => 'blog',
                    'posts_per_page' => 5,
                    'orderby'=>'date',
                    'order'=>'DESC',
                )
            );
        }  
            while($objs->have_posts()) {
            	$objs->the_post();
            	printf($linkFormat, get_permalink(), get_the_title()); 
            }
         
        
        echo "</ul>\n";
        //メインEND ---------
        
		echo $args['after_widget'];
	}

	/**
	 * バックエンドのウィジェットフォーム
	 * @see WP_Widget::form()
	 * @param array $instance データベースからの前回保存された値
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '最近の投稿', 'text_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'タイトル:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * ウィジェットフォームの値を保存用にサニタイズ
	 * @see WP_Widget::update()
	 * @param array $new_instance 保存用に送信された値
	 * @param array $old_instance データベースからの以前保存された値
	 * @return array 保存される更新された安全な値
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Foo_Widget



// Foo_Widget ウィジェットを登録
function register_custom_widget() {
    register_widget( 'AllBlogByShopWidget' );
    register_widget( 'RecentPostWidget' );
    
    unregister_widget("WP_Widget_Recent_Posts");
}
add_action( 'widgets_init', 'register_custom_widget' );


add_filter( 'getarchives_where' , 'ucc_getarchives_where_filter' , 10 , 2 );
function ucc_getarchives_where_filter( $where , $r ) {
    $args = array(
    'public' => true ,
    '_builtin' => false
    );
    $output = 'names';
    $operator = 'and';

    $post_types = get_post_types( $args , $output , $operator );
    $post_types = array_merge( $post_types , array( 'post' ) );
    $post_types = "'" . implode( "' , '" , $post_types ) . "'";
    return str_replace( "post_type = 'post'" , "post_type IN ( $post_types )" , $where );
}

add_filter( 'eventorganiser_fullcalendar', 'my_callback_function', 10, 2 );
function my_callback_function( $events_array, $query ){
	//Change first value and return it
    $events_array['post_type'] = 'blog';

	return $events_array;
};


function custom_post_rewrite_rules( $post_rewrite ) {
	if ( $post_rewrite ) {
		$custom_rules = array();
		$prefix = 'blogb/';
		foreach ( $post_rewrite as $key => $post_rule ) {
			$custom_rules[ $prefix . $key ] = $post_rule;
		}
		$post_rewrite = $custom_rules;
	}
	return $post_rewrite;
}
add_filter( 'post_rewrite_rules', 'custom_post_rewrite_rules' );

function custom_post_rewrite_structure( $permalink, $post ) {
	if ( $permalink && $post->post_type == 'post' ) {
		$permalink = '/blogb' . $permalink;
	}
	return $permalink;
}
add_filter( 'pre_post_link', 'custom_post_rewrite_structure', 10, 2 );





