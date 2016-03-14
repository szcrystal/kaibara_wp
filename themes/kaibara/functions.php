<?php
/**
 * _s functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

if ( ! function_exists( '_s_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _s_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( '_s', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
    

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', '_s' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    
    
    
    add_post_type_support( 'post', 'page-attributes' );
    add_post_type_support( 'attachment', 'page-attributes' );
    //pre_get_posts 
}
endif;
add_action( 'after_setup_theme', '_s_setup' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_s_content_width', 640 );
}
add_action( 'after_setup_theme', '_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _s_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_s' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {
	wp_enqueue_style( '_s-style', get_stylesheet_uri() );

	wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';



/* ******************************************************************** */

// URL出力
function tmpl_url() {
    echo esc_url( get_template_directory_uri() );
}

function asset($arg) {
	echo tmpl_url() . '/' .$arg;
}

//ショートコード short code
function include_func( $atts ) {
	
	extract(shortcode_atts(array(
	    'file' => 'default',
        'type' => '',
	), $atts));
    
	ob_start(); //大量の(html)出力となる場合はこれを付けて、return ob_get_clean()にする
	
    $slug = $type;
    if($slug == 'inspect' || $slug == 'newshop' || $slug == 'contact')
		include_once('inc/mail_form/MailFormMain.php');
    else
    	echo "Specify the TYPE at ShortCode";
        
    return ob_get_clean();
}
add_shortcode( 'inclmf', 'include_func' );


/* body class */
function szc_body_class( $class = '' ) {
    global $wp_query;
    $classes = array();

    if ( is_front_page() )
		$classes[] = 'home';
    if ( is_page() &! is_front_page() ) {
		$classes[] = 'page';
        /*$page_id = $wp_query->get_queried_object_id();
		//$post = get_post($page_id);
		$classes[] = 'page-id-' . $page_id;*/
    } //page
//    if(is_childpage()) {
//        $classes[] = 'child';
//    }
	if ( is_home() )
		$classes[] = 'blog';
    if ( is_paged() )
		$classes[] = 'paged';
	if ( is_attachment() )
		$classes[] = 'attachment';
	if ( is_404() )
		$classes[] = 'error404';
    if ( is_single() )
        $classes[] = 'single';
    /*if (is_singular('azuma_news'))
        $classes[] = 'single-news';*/

	if ( is_archive() && ! is_post_type_archive())
		$classes[] = 'archive';
    if ( is_post_type_archive() )
		$classes[] = 'archive-news';
        // or is_post_type_archive('azuma_news')

	if ( is_date() )
		$classes[] = 'date';
	if ( is_search() ) {
		$classes[] = 'search';
		$classes[] = $wp_query->posts && ($_GET['s']!='') ? 'search-results' : 'no-search';
	} //search
    
    if ( is_category() )
		$classes[] = 'category';
    if ( is_tag() )
		$classes[] = 'tag';
    if ( is_tax() )
		$classes[] = 'tax';

    echo ' class="' . join( ' ', $classes ) . '"';
}


/* add class */
function addMainClass() {
	$class = 'class="';
    
	if(is_front_page()) 
    	$class .= 'top';
    elseif(is_singular('shop'))
    	$class .= 'shop';
    elseif(is_single() || is_archive()) //is_post_type_archive($post_type)
    	$class .= 'blog';
    else
    	$class .= 'site';
    
    echo $class . '"';
}


function my_getarchives_where( $where, $r ) {
  if ( isset($r['post_type']) ) {
    $where = str_replace( '\'post\'', '\'' . $r['post_type'] . '\'', $where );
  }
  
  return $where;
}
//add_filter( 'getarchives_where', 'my_getarchives_where', 10, 2 );

/* Custom Post */
function create_post_type() {
	register_post_type( 'shop',
        array(
            'labels' => array(
            	'name' => __( '加盟店舗' ),
            	'singular_name' => __( 'shop_member' ),
                'add_new_item' => '新規加盟店舗を追加',
                'edit_item' => '加盟店舗を編集',
          ),
        'public' => true,
        'exclude_from_search' => true,
        'hierarchical' => false,
        'menu_position' => 3,
        'has_archive' => true, //現在はリストページのテンプレは固定ページではなくarchiveページにしている。これがtrueだとリストページは強制的にarchive(-azuma_news).phpになる
        'publicly_queryable' => true,
    	'show_ui' => true,
    	'query_var' => true,
        'capability_type' => 'post',
    	'taxonomies' => array('category', 'post_tag'),
        //'rewrite' => true,
        'rewrite' => array('slug' => 'shop', 'with_front' => false, 'pages'=>true),
        'supports' => array('title','editor','custom-fields', 'thumbnail', 'page-attributes', 'post-formats')
    )
  );
  
  
  //カスタムタクソノミー、カテゴリタイプ
  register_taxonomy(
    'shop-cat', 
    'shop', 
    array(
      'hierarchical' => true, 
      'update_count_callback' => '_update_post_term_count',
      'label' => '製品のカテゴリー',
      'singular_label' => '製品のカテゴリー',
      'public' => true,
      'show_ui' => true
    )
  );
   /*
//カスタムタクソノミー、タグタイプ
  register_taxonomy(
    'member-tag', 
    'member', 
    array(
      'hierarchical' => false, 
      'update_count_callback' => '_update_post_term_count',
      'label' => '製品のタグ',
      'singular_label' => '製品のタグ',
      'public' => true,
      'show_ui' => true
    )
  );
  */
  
}
add_action( 'init', 'create_post_type' );


/* Custom Post */
function create_blog() {
	register_post_type( 'blog',
        array(
            'labels' => array(
            	'name' => __( '店舗ブログ' ),
            	'singular_name' => __( 'shop_blog' ),
                'add_new_item' => '新規店舗ブログを追加',
                'edit_item' => '店舗ブログを編集',
          ),
        'public' => true,
        'hierarchical' => false,
        'menu_position' => 3,
        'has_archive' => true, //現在はリストページのテンプレは固定ページではなくarchiveページにしている。これがtrueだとリストページは強制的にarchive(-azuma_news).phpになる
        'publicly_queryable' => true,
    	'show_ui' => true,
    	'query_var' => true,
        'capability_type' => 'post',
    	'taxonomies' => array('category', 'post_tag'),
        //'rewrite' => false,
        'rewrite' => array('slug' => 'blog', 'with_front' => false, 'pages'=>true),
        'supports' => array('title','editor','custom-fields', 'thumbnail',/* 'page-attributes',*/ 'post-formats', 'comments')
    )
  );
  
}
add_action( 'init', 'create_blog' );


//ペジネーションのURLをリダイレクトさせない（パーマリンク設定がpostnameの時リダイレクトされるので）
function my_disable_redirect_canonical( $redirect_url ) {

	if ( is_single('shop') ){ //shopのシングルページのみに適用
//		$subject = $redirect_url;
//		$pattern = '/\/page\//'; // URLに「/page/」があるかチェック
//		preg_match($pattern, $subject, $matches);
        
        $matches = strpos($redirect_url, '/page/');

		if ($matches !== FALSE){ //リクエストURLに「/page/」があれば、リダイレクトしない。
			$redirect_url = false;
			return $redirect_url;
		}
	}
    
    if(is_post_type_archive('blog') || isset($_GET['shop_id'])) {
    	$redirect_url = false;
        return $redirect_url;
    }

}
add_filter('redirect_canonical','my_disable_redirect_canonical');
 
/* Admin ******** */
//投稿ページへ表示するカスタムボックスを定義する
function add_custom_inputbox() {
    add_meta_box( 'paka3id','店名', 'shopNameCustomField', 'blog', 'normal' );
}
add_action('admin_menu', 'add_custom_inputbox');
 
//投稿ページに表示されるカスタムフィールド
function shopNameCustomField(){
    $id = get_the_ID();
    //カスタムフィールドの値を取得
    $shop_id = get_post_meta($id, 'shop_id', true);

    $objs = new WP_Query( array('post_type'=>'shop','orderby'=>'ID','order'=>'ASC',)); //or $wpdb->getrow()で
    $objs = $objs->posts; //WP_Queryのオブジェクトのpostsの中にデータがある
       
    $format = "<label>店舗名</label>\n"
            . '<select name="shop_id">'."\n"
            . "<option>選択して下さい</option>";

    foreach($objs as $obj) {
        $onSelect = ($obj->ID == $shop_id) ? "selected" : '';  
        $format .= '<option value="'.$obj->ID .'" '. "{$onSelect}>{$obj->post_title}</option>\n";
    }

    $format .= "</select>\n";
    
    echo $format;
}

//更新処理
/*投稿ボタンを押した際のデータ更新と保存*/
function saveCustomFieldData($post_id){
    //入力した値(postされた値)
    $shop_name = isset($_POST['shop_id']) ? $_POST['shop_id']: null;
    
    //DBに登録してあるデータ
    //$shop_name_org = get_post_meta($post_id, 'shop_id', true);
    
    if($shop_name){
      update_post_meta($post_id, 'shop_id', $shop_name);
    }
    else {
      delete_post_meta($post_id, 'shop_id', $shop_name);
    }
}
//入力したデータの更新処理
add_action('save_post', 'saveCustomFieldData');

function remove_menus () {
    global $menu;
    //unset($menu[2]);  // ダッシュボード
    unset($menu[4]);  // メニューの線1
    unset($menu[5]);  // 投稿
//    unset($menu[10]); // メディア
//    unset($menu[15]); // リンク
//    unset($menu[20]); // ページ
//    unset($menu[25]); // コメント
//    unset($menu[59]); // メニューの線2
//    unset($menu[60]); // テーマ
//    unset($menu[65]); // プラグイン
//    unset($menu[70]); // プロフィール
//    unset($menu[75]); // ツール
//    unset($menu[80]); // 設定
//    unset($menu[90]); // メニューの線3
}
//add_action('admin_menu', 'remove_menus');

//function my_rewrite_flush() {
//    flush_rewrite_rules();
//}
//add_action( 'after_switch_theme', 'my_rewrite_flush' );

// 'post', 'page' および 'movie' 投稿タイプの投稿をホームページに表示する
//function add_my_post_types_to_query( $query ) {
//  if ( $query->is_main_query() )
//    $query->set( 'post_type', array( 'page', 'post', 'blog') );
//  return $query;
//}
//add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

/* 親ページリストの変更 *****/
//function online_dropdown_pages_args( $dropdown_args, $post ) {
//    if ( $dropdown_args['post_type'] == 'blog' ) {
//        $dropdown_args['post_type'] = 'shop';
//    }
//    return $dropdown_args;
//}
//add_filter( 'page_attributes_dropdown_pages_args', 'online_dropdown_pages_args', 10, 2 );

/* Admin END ********** */


//slugからIDを取る
function id_by_slug($arg) {
    $page = get_page_by_path($arg);
    
    if($page)
        return $page->ID;
    else
        NULL;
}


/* Custom Excerpt */
function sz_content($char_count) {

    if(is_search()) {
        global $post;
        $texts = $post->post_content; //DBからpost_contentを取得
        $more_class = 'class="more-link" ';
    }
    else {
        $texts = get_the_content(''); //ページ>the_post()からcontentを取得
        $more_class = '';
    }
    
    $continue_format = '<a %shref="%s" title="%sのページへ">続きを読む ▷</a>';
    $continue_format = sprintf($continue_format, $more_class, esc_url(get_permalink()), get_the_title());
    
    $texts = strip_tags($texts); //htmlタグを消す
    $texts = str_replace("\n", '', $texts); //改行コード消し
    $texts = mb_substr($texts, 0, $char_count);
    
    /*$texts .= '<a '. $more_class . 'href="'. esc_url(get_permalink()) .'" title="'. get_the_title().'のページへ">続きを読む ▷</a>';*/
    
    //echo $texts . "…" . $continue_format;
    echo "<p>" . $texts . "…</p>";
        
        /* サーチページやアーカイブページで使うか
        global $post;
        $texts = strip_tags( $post->post_content ); //DBからpost_contentを取得してhtmlタグを消す
        $texts = str_replace("\n", '', $texts); //改行コードを消す
        echo mb_substr($texts, 0, 120); //120文字抜粋
        */
}

/* custom fieldのメタ topイラスト*/
function setStyleAttribute($tag_name) {
    
    $i_id = get_post_meta(get_the_id(), 'illust_id', true);
    
    if($i_id) {
        if($attach_meta = wp_get_attachment_metadata($i_id)) {
            
            if($tag_name == 'div') {
                $x = get_post_meta(get_the_id(), 'x', true);
                $y = get_post_meta(get_the_id(), 'y', true);
                        
                $x = ($x/100) * 1000 - ($attach_meta['width']/2); //1000 ->画像のサイズ横 
                $y = ($y/100) * 650 - ($attach_meta['height']/2); //650 ->画像のサイズ縦
                
                $ret = 'style="';
                $ret .= 'top:'.$y.'px; ';
                $ret .= 'left:'.$x.'px;"';
            }
            else if($tag_name == 'img') {
                $ret = 'src="' . wp_get_attachment_url($i_id) .'" ';
                $ret .= 'alt="' . get_the_title() .'"';
            }
            else { //<a>にはめる時
            	$ret = 'style="';
                $ret .= 'width:'.$attach_meta['width'].'px; ';
                $ret .= 'height:'.$attach_meta['height'].'px; ';
                $ret .= 'background-image:url('. wp_get_attachment_url($i_id) .');"';
            }
            
            echo $ret;
        }
    }
}


/* Pagenation */
function set_pagenation($queryArg = '') {
	
    if($queryArg != '') {
		global $wp_query;
		$wp_query->max_num_pages = $queryArg->max_num_pages; //$GLOBALS['wp_query']
    }
                   		
    the_posts_pagination(
    	array(
           'mid_size' => 1,
           'prev_text' => '<i class="fa fa-angle-double-left"></i>Prev',
           'next_text' => 'Next <i class="fa fa-angle-double-right"></i>',
           'screen_reader_text' => __( 'Posts navigation' ),
           'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'cm' ) . ' </span>',
    	)
    );
}


/**
 * Adds Foo_Widget widget.
 */
include_once('functions-widget.php');


/* 管理画面一覧パネルにカスタムフィールドを追加 */
// カスタムカラムのヘッダーテキスト
function custom_admin_field_head($columns) {

    $columns = array_merge($columns,
                        array(
                            'shop_name' => '店名',
                            'id' => 'ID',
                            //'description' => 'ディスクリプション'
                            )
                        );
    return $columns;
    
}
add_filter('manage_posts_columns','custom_admin_field_head');
add_filter('manage_shop_posts_columns','custom_admin_field_head');
add_filter('manage_blog_posts_columns','custom_admin_field_head');
// https://codex.wordpress.org/Plugin_API/Filter_Reference/manage_pages_columns

// カスタムカラム 管理画面
function custom_admin_field($column, $post_id) {
    
    switch($column) {
        case 'shop_name' :
            $shop = get_post_meta($post_id, 'shop_id', true);
            if($shop) echo get_the_title($shop);
            break;
        
        case 'id':
            echo $post_id;
            break;
            
        case 'description':
            echo get_post_meta($post_id, 'description', true);
            break;
    }
}
//add_filter('manage_posts_custom_column', 'custom_admin_field', 10, 2);
add_filter('manage_shop_posts_custom_column', 'custom_admin_field', 10, 2);
add_filter('manage_blog_posts_custom_column','custom_admin_field', 10, 2);

// メディアカラムのヘッダーテキスト
function custom_media_field_head($columns) {

    $columns = array_merge($columns, array(
                            'attachment_url' => 'URL',
                            'id' => 'ID',
                            )
                        );
    return $columns;
    
}
add_filter('manage_media_columns','custom_media_field_head');

function custom_media_field($column, $post_id) {
    
    switch($column) {
        case 'attachment_url' :
            echo wp_get_attachment_url($post_id) ;
            break;
        
        case 'id':
            echo $post_id;
            break;
    }
}
add_filter('manage_media_custom_column', 'custom_media_field', 10, 2);


//localServer judge
function isLocal() {
    return ($_SERVER['SERVER_NAME'] == '192.168.10.17');
}

function session_clear_onpage() {
	global $post;
    
    if($post->post_name != 'inspect' && $post->post_name != 'newshop' && $post->post_name != 'contact') {
        $_SESSION = array();
        session_destroy();        
    }
//    else {
//    	echo "Not Cleard";
//    }
}

//DomainKing or Not
function isDK() {
	return ($_SERVER['SERVER_NAME'] == 'sato.emerald.cu.cc');
}


//User Agent Check
function isAgent($agent) {

    $ua_sp = array('iPhone','iPod','Mobile ','Mobile;','Windows Phone','IEMobile');
    $ua_tab = array('iPad','Kindle','Sony Tablet','Nexus 7','Android Tablet');
    $all_agent = array_merge($ua_sp, $ua_tab);
    
    switch($agent) {
        case 'sp':
            $agent = $ua_sp;
            break;
    
        case 'tab':
            $agent = $ua_tab;
            break;
        
        case 'all':
            $agent = $all_agent;
            break;
            
        default:
            //$agent = '';
            break;
    }
       
    if(is_array($agent)) {
        $agent = implode('|', $agent);
    }
    
    return preg_match('/'. $agent .'/', $_SERVER['HTTP_USER_AGENT']);    
}


/* $_SESSIONの使用を可能にする */
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}
function myEndSession() {
    session_destroy();
}
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');









