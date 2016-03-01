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
    
    add_image_size( 'archive', 230, 180, TRUE );
    
    
    add_post_type_support( 'post', 'page-attributes' );
    add_post_type_support( 'attachment', 'page-attributes' );
    //pre_get_posts 
}
endif;
add_action( 'after_setup_theme', '_s_setup' );


function custom_editor_settings( $arr ){
	//https://www.tinymce.com/docs/configure/content-filtering/#valid_elements
    //optionは上記にて　しかしほとんどが効かない
    
    //http://yokotakenji.me/log/cms/wordpress/3139/

	//$$arr['body_id'] = 'primary';
	//$$arr['body_class'] = 'fa';
	// styleや、divの中のdiv,span、spanの中のspanを消させない
	//$arr['valid_children'] = 'p[strong|a|#text]';
    //$arr['paste_remove_spans'] = true;
    //$arr['element_format'] = 'HTML';
    //$arr['selector'] = 'textarea';
    //$arr['valid_elements'] = '*[*]';
    //$arr['content_css'] = get_template_directory_uri() . "/style.css";
	
    //$arr['remove_trailing_brs'] = false;
    //$arr['block_formats'] = "pタグ=p;h1タグ=h1;h2タグ=h2;h3タグ=h3;";
    //$arr['wpautop'] = false;
    //$arr['keep_styles'] = false;
    //$arr['object_resizing'] = false;
    // 空タグや、属性なしのタグとか消そうとしたりするのを停止。
	$arr['verify_html'] = false;

	//$initArray['entity_encoding'] = 'raw';
	//$initArray['entities'] = '91,93';
    //print_r($arr);
	return $arr;
}
add_filter( 'tiny_mce_before_init', 'custom_editor_settings' );



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
	if(isAgent('all'))
    	wp_enqueue_style( 'style-sp', get_template_directory_uri() . '/style-sp.css');
    else
		wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    //wp_enqueue_script( 'szjq', 'http://code.jquery.com/jquery-1.12.0.min.js', array(), '', true );
    //wp_enqueue_script( 'sz', get_template_directory_uri() . '/js/jq.script.js', array(), '20160206', true );
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
/* For Admin ********** */
include_once('functions-admin.php');
/* ******************** */

/*Adds Foo_Widget widget.*************** */
include_once('functions-widget.php');
/* ************************************* */


// URL出力
function tmpl_url() {
    echo esc_url( get_template_directory_uri() );
}

function asset($arg) {
	echo tmpl_url() . '/' .$arg;
}

function outputUrl($arg) {
	echo home_url() . '/' .$arg . '/';
}

//ショートコード short code for Include MailForm
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


/* body class 未使用 */
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
    elseif(is_page()) {
    	$class .= 'fixpage';
        
//        if(get_page_slug(get_the_ID()) != '') {
//            $class .= ' ' . get_page_slug(get_the_ID());
//        }
		
        $nameType = get_post_meta(get_the_ID(), 'name_type', true);
        
        if($nameType != '') 
            $class .= ' ' . $nameType;

    }
    elseif(is_singular('shop'))
    	$class .= 'shop';
    elseif(is_home() || is_archive() || is_search() || is_single()) //is_post_type_archive($post_type)
    	$class .= 'list';
    else
    	$class .= 'site';
    
    
    echo $class . '"';
}

/* auto p tag remove */
//remove_filter('the_content', 'wpautop');
//remove_filter('the_excerpt', 'wpautop');

function my_getarchives_where( $where, $r ) {
  if ( isset($r['post_type']) ) {
    $where = str_replace( '\'post\'', '\'' . $r['post_type'] . '\'', $where );
  }
  
  return $where;
}
//add_filter( 'getarchives_where', 'my_getarchives_where', 10, 2 );



/* Custom Post ********************************** */
//psot_type: shop
function create_post_type() {
	register_post_type( 'shop',
        array(
            'labels' => array(
            	'name' => '加盟店舗',
            	'singular_name' => '加盟店舗', //shop_member
                'all_items' => '加盟店舗一覧',
                'add_new_item' => '新規加盟店舗を追加',
                'edit_item' => '加盟店舗を編集',
        ),
        'public' => true,
        'exclude_from_search' => true,
        'hierarchical' => false,
        'menu_position' => 6, //6の位置に入る 4はメニュー線で効かない 3は効く
        'has_archive' => true, 
        //falseでも一覧自体は出力され、テンプレートが変わる(home.php->なければindex.php??ぽい)。
        //trueならarchive-news.php なければarchive.php。
        'publicly_queryable' => true,
    	'show_ui' => true,
    	'query_var' => true,
        'capability_type' => 'post',
    	//'taxonomies' => array('category', 'post_tag'),
        //'rewrite' => true,
        'rewrite' => array('slug' => 'shop', 'with_front' => false, 'pages'=>true),
        'supports' => array('title','editor','custom-fields', 'thumbnail', 'page-attributes', 'post-formats')
    )
  );
  
//タクソノミーを指定する場合（カテゴリー、タグとは別にメニューリストに表示される。単独のカテゴリーの親になるようなもの）  
//カスタムタクソノミー、カテゴリタイプ
//  register_taxonomy(
//    'shop-cat', 
//    'shop', 
//    array(
//      'hierarchical' => true, 
//      'update_count_callback' => '_update_post_term_count',
//      'label' => '製品のカテゴリー',
//      'singular_label' => '製品のカテゴリー',
//      'public' => true,
//      'show_ui' => true
//    )
//  );
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
//post_type: news
function create_news() {
	register_post_type( 'news',
        array(
            'labels' => array(
            	'name' => 'NEWS',
            	'singular_name' => 'NEWS', //news_project
                'all_items' => 'ニュース一覧',
                'add_new_item' => '新規ニュースを追加',
                'edit_item' => 'ニュースを編集',
          	),
            'public' => true,
            'hierarchical' => false,
            'menu_position' => 9,
            'has_archive' => true, 
            //falseでも一覧自体は出力され、テンプレートが変わる(home.php->なければindex.php??ぽい)。
            //trueならarchive-news.php なければarchive.php。
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            //'taxonomies' => array('category', 'post_tag'),
            //'rewrite' => false,
            'rewrite' => array('slug' => 'news', 'with_front' => false),
            'supports' => array('title','editor','custom-fields', 'thumbnail', 'page-attributes', 'post-formats', 'comments')
    )
  );
  
}
add_action( 'init', 'create_news' );


/* Custom Post ブログ作成->通常のpostにした */
//function create_blog() {
//	register_post_type( 'blog',
//        array(
//            'labels' => array(
//            	'name' => __( '店舗ブログ' ),
//            	'singular_name' => __( 'shop_blog' ),
//                'add_new_item' => '新規店舗ブログを追加',
//                'edit_item' => '店舗ブログを編集',
//          ),
//        'public' => true,
//        'hierarchical' => false,
//        'menu_position' => 3,
//        'has_archive' => true, //現在はリストページのテンプレは固定ページではなくarchiveページにしている。これがtrueだとリストページは強制的にarchive(-azuma_news).phpになる
//        'publicly_queryable' => true,
//    	'show_ui' => true,
//    	'query_var' => true,
//        'capability_type' => 'post',
//    	'taxonomies' => array('category', 'post_tag'),
//        //'rewrite' => false,
//        'rewrite' => array('slug' => 'blog', 'with_front' => false, 'pages'=>true),
//        'supports' => array('title','editor','custom-fields', 'thumbnail',/* 'page-attributes',*/ 'post-formats', 'comments')
//    )
//  );
//  
//}
//add_action( 'init', 'create_blog' );




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
 


/* 空文字の検索結果をサーチページのテンプレにする  テーマsearch.php内も修正が必要 */
function search_empty($search, $wp_query) {

    if(! is_admin()) {

        if(isset($_GET['s']) && $_GET['s'] == '') {
            $wp_query-> is_search = true; //元仕様はis_homeにフラグが立つので、それを解除する
            $wp_query-> is_home = false;
        }
            
        return $search;
    }    
}
add_action('posts_search','search_empty', 10, 2);

//検索対象のpost_typeを増やす
function filter_search($query) {
    if ($query->is_search) {
		$query->set('post_type', array('post', 'page', 'shop', 'news'));
    }
    return $query;
}
add_filter('pre_get_posts', 'filter_search');


//slugからIDを取る
function id_by_slug($arg) {
    $page = get_page_by_path($arg);
    
    if($page)
        return $page->ID;
    else
        NULL;
}
//IDからスラッグをとる
function get_page_slug($page_id) {
    $page = get_page($page_id);
    return $page->post_name;
}

//コメント comment 管理画面「新しい投稿へのコメントを許可する」の値を取る 
function isComment() {
	return get_option('default_comment_status') == 'open';
}

/* Custom Excerpt */
function sz_content($char_count) {

    $more_class = '';
    $texts = get_the_content('');
    
    $continue_format = '<a %shref="%s" title="%sのページへ"> …</a>';
    $continue_format = sprintf($continue_format, $more_class, esc_url(get_permalink()), get_the_title());
    
    $texts = strip_tags($texts); //htmlタグを消す
    $texts = str_replace("\n", '', $texts); //改行コード消し
    
    if(mb_strlen($texts) > $char_count+1) {
    	$texts = mb_substr($texts, 0, $char_count);
	    $texts = $texts . $continue_format;
	}
    
    echo "<p>" . $texts . "</p>";
}


/* custom fieldのメタ topイラスト*/
function illustOutputDivAndImg($tagname='div', $IdOrMeta='id', $isFront) {
    
    if($IdOrMeta == 'id') { //加盟店舗にセットしているillust_idからイラストのIDを取る方法
	    $i_id = get_post_meta(get_the_id(), 'illust_id', true);
    }
    else { //イラストにセットする加盟店舗のIDを取る方法
    	$obj = new WP_Query(
        	array(
            	'meta_key' => 'shop_id',
                'meta_value' => get_the_id(),
                'post_type' => 'attachment',
                'post_status' => 'any',
                'posts_per_page' => 1,
            )
        );

        $i_id = isset($obj->post->ID) ? $obj->post->ID : '';
    }
    
    //if($i_id) {
    
    //attachmentのmetadataを取る。失敗（$i_idがない）ならFalseが返る
    if($attach_meta = wp_get_attachment_metadata($i_id)) {
        
        if($tagname == 'div') {
            $x = get_post_meta(get_the_id(), 'x', true);
            $y = get_post_meta(get_the_id(), 'y', true);
                    
            $x = ($x/100) * 1000 - ($attach_meta['width']/2); //1000 ->画像のサイズ横 
            $y = ($y/100) * 640 - ($attach_meta['height']/2); //650 ->画像のサイズ縦
            
            $ret = '<div style="';
            $ret .= 'top:'.$y.'px; ';
            $ret .= 'left:'.$x.'px;" ';
            $ret .= 'class="map-caption" ';
            $ret .= 'data-top="'.$y.'" ';
            $ret .= 'data-left="'.$x.'">'."\n";
            
            
            //リンク出力
        	if($isFront) {
            	$ret .= '<a href="'. get_the_permalink() . '" title="'. get_the_title() . 'のページへ">';
            }
            //画像出力
            //$ret = 'src="' . wp_get_attachment_url($i_id) .'" ';
            //$ret .= 'alt="' . get_the_title() .'"';
            
            // さくらサーバーにて、array()にてサイズを指定するとうまくいかない。なぜか不明。$attach_meta['width']はfullサイズを取れている
            //なので 'full'を指定する
            //$ret .= wp_get_attachment_image($i_id, array($attach_meta['width'], $attach_meta['height']), false, array('alt'=>get_the_title()) );
            $ret .= wp_get_attachment_image($i_id, 'full', false, array('alt'=>get_the_title()) );
            
            if($isFront) {
            	$ret .= "</a>\n";
            }
            
            $ret .= "</div>\n";
            
		}
        else { //<a>にバックグラウンドとして画像をはめるなら以下で可能
            $ret = 'style="';
            $ret .= 'width:'.$attach_meta['width'].'px; ';
            $ret .= 'height:'.$attach_meta['height'].'px; ';
            $ret .= 'background-image:url('. wp_get_attachment_url($i_id) .');"';
        }
        
        echo $ret;
    }
    //}

}


/* custom fieldのメタ topイラスト*/
function AsetStyleAttribute($tag_name, $IdOrMeta) {
    
    if($IdOrMeta == 'id') { //加盟店舗にセットしているillust_idからイラストのIDを取る方法
	    $i_id = get_post_meta(get_the_id(), 'illust_id', true);
    }
    else { //イラストにセットする加盟店舗のIDを取る方法
    	$obj = new WP_Query(
        	array(
            	'meta_key' => 'shop_id',
                'meta_value' => get_the_id(),
                'post_type' => 'attachment',
                'post_status' => 'any',
                'posts_per_page' => 1,
            )
        );

        $i_id = isset($obj->post->ID) ? $obj->post->ID : '';
    }
    
    //if($i_id) {
        if($attach_meta = wp_get_attachment_metadata($i_id)) {
            
            if($tag_name == 'div') {
                $x = get_post_meta(get_the_id(), 'x', true);
                $y = get_post_meta(get_the_id(), 'y', true);
                        
                $x = ($x/100) * 1000 - ($attach_meta['width']/2); //1000 ->画像のサイズ横 
                $y = ($y/100) * 575 - ($attach_meta['height']/2); //650 ->画像のサイズ縦
                
                $ret = 'style="';
                $ret .= 'top:'.$y.'px; ';
                $ret .= 'left:'.$x.'px;"';
            }
            else if($tag_name == 'img') {
                //$ret = 'src="' . wp_get_attachment_url($i_id) .'" ';
                //$ret .= 'alt="' . get_the_title() .'"';
                $ret = wp_get_attachment_image($i_id, array($attach_meta['width'], $attach_meta['height']), false, array('alt'=>get_the_title()) );
            }
            else { //<a>にはめる時
                $ret = 'style="';
                $ret .= 'width:'.$attach_meta['width'].'px; ';
                $ret .= 'height:'.$attach_meta['height'].'px; ';
                $ret .= 'background-image:url('. wp_get_attachment_url($i_id) .');"';
            }
            
            echo $ret;
        }
    //}

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


/* Single Pagenation */
function setSinglePagenation() {
	
    $queryAr = array(
    	'post_type' => get_post_type(),
        'posts_per_page' => -1, //-1指定で全てを取得。指定なしだと管理画面オプションのposts_per_page指定が優先されるので注意
        'orderby'=>'date ID',
        'order'=>'ASC',
    );
    
    if(is_singular('post')) {
    	$shid = get_post_meta(get_the_ID(), 'shop_id', true);
        $queryAr = array_merge($queryAr, array('meta_key' => 'shop_id', 'meta_value' => $shid,));
    }
    
    $objs = new WP_Query($queryAr);

    //global $wpdb;
    //$s = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID > $thisID AND post_type='blog' order by 'ID' ASC LIMIT 1"); 
        
	$array = $objs->posts; //wp_query取得後の全postデータが入っているオブジェクト（配列として入っていて、そのval値がまたオブジェクト）
    //print_r($array);
    //next_post_link();
    
    if(count($array) > 1) : 
        
        $navFormat = '<nav class="navigation post-navigation" role="navigation">'."\n"
                	.'<h2 class="screen-reader-text">投稿ナビゲーション</h2>'."\n"
					.'<div class="nav-links">'."\n";
        
        foreach($array as $key => $val) : 
            if($val->ID == get_the_ID()) {
                if(isset($array[$key-1]))
                    $navFormat .= '<div class="nav-previous"><a href="' . get_the_permalink($array[$key-1]->ID).'" rel="prev"><i class="fa fa-angle-double-left"></i>PREV</a></div>';
                        
                if(isset($array[$key+1]))
                    $navFormat .= '<div class="nav-next"><a href="' . get_the_permalink($array[$key+1]->ID).'" rel="next">NEXT<i class="fa fa-angle-double-right"></i></a></div>';
                }
        endforeach;
        	
        $navFormat .= "</div>\n"
    				. "</nav>\n";
        
        echo $navFormat;
        
    endif;
    wp_reset_query();
}




//Admin Login
function isNameAdmin() {
	global $current_user;
	return ($current_user->user_login == 'admin');
}

//localServer judge
function isLocal() {
    return ($_SERVER['SERVER_NAME'] == '192.168.10.17' || $_SERVER['SERVER_NAME'] == 'localhost');
}

function session_clear_onpage() {
	//global $post;
    $metaName = get_post_meta(get_the_ID(), 'name_type', true);
    
    //if($metaName != 'inspect' && $metaName != 'newshop' && $metaName != 'contact') {
    if($metaName == '') {
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


function getLog() {
	//print_r($_SERVER);
    
	setlocale(LC_TIME, 'ja_JP.UTF-8');
    date_default_timezone_set('Asia/Tokyo');
    
    $date = strftime('%Y%m%d');
    $logPath = realpath(dirname(__FILE__)) . '/logs';
    $fileName = "$logPath/kbr.log";
    
    $accessTime = strftime('%c');
    //$accessTime = date('Y年m月d日 H時i分s秒', time());
    //$accessFile = $_SERVER['SCRIPT_FILENAME'];
    
    $accessPage = urldecode($_SERVER['REQUEST_URI']);
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $referer = urldecode($referer);
    $agent = $_SERVER['HTTP_USER_AGENT'];
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $hostname = gethostbyaddr($ip);
    
    $log = "+ $accessTime $accessPage | $agent | $referer | $ip | $hostname\n";
    
    $fp = fopen($fileName, 'ab');
    flock($fp, LOCK_SH);
    fwrite($fp, $log);
    fclose($fp);
    
}

function tt() {
	setlocale(LC_TIME, 'ja_JP.UTF-8');
	date_default_timezone_set('Asia/Tokyo');
    echo date('Y年m月d日 H時i分s秒', time());
}






