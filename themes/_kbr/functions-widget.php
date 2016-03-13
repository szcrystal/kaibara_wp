<?php

/**
 * Adds Foo_Widget widget.
 * カスタムウィジェット追加
 * https://wpdocs.osdn.jp/WordPress_ウィジェット_API
 */


//店舗別ブログ一覧ウィジェット追加
class AllBlogByShopWidget extends WP_Widget {

	/**
	 * WordPress でウィジェットを登録
	 */
	function __construct() {
		parent::__construct(
			'blog_by_shop', // Base ID
			'店舗別ブログ一覧', // Name
			array( // Args
            	'description' => '店舗別ブログ一覧を表示します。', 
            ) 
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
        $objs = new WP_Query(
        	array(
            	'post_type'=>'shop',
                'orderby'=>'date ID',
                'order'=>'ASC',
            )
        );
        
    	$objs = $objs->posts;
        
        $linkFormat = '<li><a href="%s">%sのブログ</a></li>';
        
        echo '<ul id="menu-side-menu" class="menu">'. "\n";
        printf($linkFormat, home_url('blog/'), '全て');
        
        foreach($objs as $obj) {
        	$link = 'blog/?shop_id=' . $obj->ID;
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

} // END class 


//最近の投稿
class RecentPostWidget extends WP_Widget {

	/* WordPress でウィジェットを登録 */
	function __construct() {
		parent::__construct(
			'custom_recent_posts', // Base ID
			'最近のブログ 柏原', // Name
			array( // Args
            	'description' => '最近のブログを店舗別に表示します。',
            )
		);
        
        $this->listCount = 5;
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
        $shopid = $getshop ? $getshop : get_post_meta(get_the_ID(), 'shop_id', true);
		
        if ( ! empty( $instance['title'] ) ) {
        	if((is_singular('post') || $getshop) && $shopid) { //店舗のブログ時 archive/single
            	//$sid = $getshop ? $getshop : get_post_meta(get_the_id(), 'shop_id', true);
				echo $args['before_title'] . apply_filters( 'widget_title', get_the_title($shopid)."の".$instance['title'] ). $args['after_title'];
            }
            elseif(is_post_type_archive('news') || is_singular('news')) { //ニュース時
            	echo $args['before_title'] . apply_filters( 'widget_title', '最近のニュース' ). $args['after_title'];
            }
            else {
            	echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
            }
		}
		
        //メイン部分 ----------
        $linkFormat = '<li><a href="%s">%s</a></li>';
        
        $queryArray = array(
            'post_type' => 'post',
            'posts_per_page' => $this->listCount,
            'orderby'=>'date ID',
            'order'=>'DESC',
        );
        
        echo '<ul id="menu-side-menu" class="menu">'. "\n";
        
        if((is_singular('post') || $getshop) && $shopid) { //店舗のブログ時 archive/single
            $queryArray['meta_key'] = 'shop_id';
            $queryArray['meta_value'] = $shopid;
        }
        elseif(is_post_type_archive('news') || is_singular('news')) { //ニュース時はそのまま
        	$queryArray['post_type'] = get_post_type();
        }
        else { //newsと店舗別アーカイブ以外の全て blogAll cate/tag/date
        	$queryArray['post_type'] = 'post';
        }
        
        $objs = new WP_Query($queryArray);
        
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
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '最近のブログ', 'text_domain' );
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

} // class END


//最近の投稿
class shopLinkAndArchive extends WP_Widget {

	/* WordPress でウィジェットを登録 */
	function __construct() {
		parent::__construct(
			'shop_link_archive', // Base ID
			'ニュース一覧と店舗リンク', // Name
			array( // Args
            	'description' => 'ニュース一覧と店舗ページのリンクを表示します。',
            )
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
		
        echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];

        //メイン部分 ----------
        $linkFormat = '<li><a href="%s">%s</a></li>'."\n";
        
        $queryArray = array(
            'post_type' => 'shop',
            //'posts_per_page' => $this->listCount,
            'orderby'=>'date ID',
            'order'=>'ASC',
        );
        
        echo '<ul id="menu-side-menu" class="menu">'. "\n";
        
        printf($linkFormat, home_url('news'), 'ニュース一覧');
        printf($linkFormat, home_url('shop'), '加盟店舗一覧');
        
        $objs = new WP_Query($queryArray);
        
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
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'ニュース一覧と店舗リンク', 'text_domain' );
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

} // class END


// Widget ウィジェットを登録
function register_custom_widget() {
    register_widget( 'AllBlogByShopWidget' );
    register_widget( 'RecentPostWidget' );
    register_widget( 'shopLinkAndArchive' );
    
    unregister_widget("WP_Widget_Recent_Posts"); //Parameters http://codex.wordpress.org/Function_Reference/unregister_widget
}
add_action( 'widgets_init', 'register_custom_widget' );



/*
管理画面のパーマリンク->カスタム構造に/blog/を指定すれば、ブログ時に/blogが付き、固定ページ時には自動で排除されて付かないのでそれでOKだが
手動で書き換える関数は以下
FilterAPIがあるのかないのか、だったりでかなりやっかい

//Postと年月のリライト
function custom_post_rewrite_rules( $post_rewrite ) {
	if ( $post_rewrite ) {
		$custom_rules = array();
		$prefix = 'blog/';
		foreach ( $post_rewrite as $key => $post_rule ) {
			$custom_rules[ $prefix . $key ] = $post_rule;
		}
		$post_rewrite = $custom_rules;
	}
	return $post_rewrite;
}
add_filter( 'post_rewrite_rules', 'custom_post_rewrite_rules' );
add_filter( 'date_rewrite_rules', 'custom_post_rewrite_rules' );

//Post permalink書き出しの書き換え
function custom_post_rewrite_structure( $permalink, $post, $leavename ) {
	if ( $permalink && $post->post_type == 'post') {
		$permalink = '/blog' . $permalink;
	}
    
	return $permalink;
}
add_filter( 'pre_post_link', 'custom_post_rewrite_structure', 10, 3 );

//年月アーカイブ permalink書き出しの書き換え
function custom_year_archive_rewrite( $yearlink, $year ) {
    if ($year) {
    	$yearlink = '/blog/' . $year.'/';
    }
    return $yearlink;
}
add_filter( 'year_link', 'custom_year_archive_rewrite', 10, 2 );

function custom_month_archive_rewrite( $monthlink, $year, $month ) {
	if ($year && $month) {
    	$monthlink = '/blog/' . $year .'/'. $month . '/';
    }
    return $monthlink;
}
add_filter( 'month_link', 'custom_month_archive_rewrite', 10, 3 );

function custom_day_archive_rewrite( $daylink, $year, $month, $day ) {
	if ($year && $month && $day) {
    	$daylink = '/blog/' . $year .'/'. $month . '/'.$day .'/';
    }
    return $daylink;
}
add_filter( 'day_link', 'custom_day_archive_rewrite', 10, 4 );

*/



/*
//URLリライトの関数が色々あったが、上手くいかない
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
add_filter( 'getarchives_where' , 'ucc_getarchives_where_filter' , 10 , 2 );


function my_callback_function( $events_array, $query ){
	//Change first value and return it
    $events_array['post_type'] = 'blog';

	return $events_array;
};
add_filter( 'eventorganiser_fullcalendar', 'my_callback_function', 10, 2 );
*/



