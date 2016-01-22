<?php

/**
 * For AdminPage.
 * 管理画面用の関数
 * 
 */


/* Admin ******** */
//投稿ページへ表示するカスタムボックスを定義する
function add_custom_inputbox() {
    add_meta_box( 'shopName','店名', 'shopNameCustomField', 'post', 'normal' ); //postの部分はpost_typeを指定 カスタム投稿でも可能 paka3id
    //add_meta_box( 'shopName','店名', 'shopNameCustomField', 'attachment', 'normal' );
}
add_action('admin_menu', 'add_custom_inputbox');


//add_filter('attachment_fields_to_edit', 'add_custom_inputbox');
 
//投稿ページに表示されるカスタムフィールド
function shopNameCustomField(){
    $id = get_the_ID();
    //カスタムフィールドの値を取得
    $shop_id = get_post_meta($id, 'shop_id', true);

    $objs = new WP_Query( array('post_type'=>'shop','orderby'=>'ID','order'=>'ASC',)); //or $wpdb->getrow()で
    $objs = $objs->posts; //WP_Queryのオブジェクトのpostsの中にデータがある
       
    $format = "<label>店舗名</label>\n"
            . '<select name="shop_id">'."\n"
            . '<option value="">選択して下さい</option>';

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
//add_action('edit_attachment', 'saveCustomFieldData'); //attachment用のsave_post listモードとgridモード両方に効く
//http://wordpress.stackexchange.com/questions/116877/save-post-not-working-with-attachments

//add_filter( 'attachment_fields_to_save', 'saveCustomFieldData', 10, 1 ); //listモードには無効ぽい Gridモードで効くはずだがうまくいかない



function my_add_attachment_location_field( $form_fields, $post ) {
	//print_r($_SERVER);
    //echo "aaa";
    //if(strpos($_SERVER['REQUEST_URI'], 'upload.php') !== FALSE) {
    
    $shop_id = get_post_meta( $post->ID, 'shop_id', true );
    
    $objs = new WP_Query( array('post_type'=>'shop','orderby'=>'ID','order'=>'ASC',)); //or $wpdb->getrow()で
    $objs = $objs->posts; //WP_Queryのオブジェクトのpostsの中にデータがある
       
    $format = //'<style>table td{background:#fff; width:90%;}</style>'
    		//.'<div id="shopName" class="postbox " >'
    		//.'<h2 class="hndle"><span>店名</span></h2><div class="inside"><label>店舗名</label>'
            '<select name="shop_id">'."\n"
            . "<option>選択して下さい</option>";

    foreach($objs as $obj) {
        $onSelect = ($obj->ID == $shop_id) ? "selected" : '';  
        $format .= '<option value="'.$obj->ID .'" '. "{$onSelect}>{$obj->post_title}</option>\n";
    }

    $format .= "</select>";
    		//."\n</div></div>";
    
    $form_fields['shop_id'] = array(
        'input' => 'html',
        //'value' => $shop_id ? $shop_id : '',
        'label' => '店舗名',
        'helps' => '',
        'html' => $format,
    );
    return $form_fields;
    //}
}
//if(strpos($_SERVER['REQUEST_URI'], 'item') !== FALSE) { if(isset($_GET['mode'])) {
//add_filter( 'attachment_fields_to_edit', 'my_add_attachment_location_field', 10, 2 );
//}

function my_attachment_field_location_save( $post, $attachment ) {
	//print_r($attachment); //$attachment['shop_id'] ??
    $shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : NULL;
    if( $shop_id )
        update_post_meta( $post['ID'], 'shop_id', $shop_id );
    else
    	delete_post_meta( $post['ID'], 'shop_id', $shop_id );
    return $post;
}
//Gridモード専用?? うまくいかない
//add_filter( 'attachment_fields_to_save', 'my_attachment_field_location_save', 10, 2 );

function my_save_attachment_location( $attachment_id ) {
    if ( isset( $_REQUEST['attachments'][$attachment_id]['shop_id'] ) ) {
        $location = $_REQUEST['attachments'][$attachment_id]['shop_id'];
        update_post_meta( $attachment_id, 'shop_id', $location );
    }
    else {
    	delete_post_meta( $attachment_id, 'shop_id', '' );
    }
}
//add_action( 'edit_attachment', 'my_save_attachment_location' );




function changeAdminMenu() {
    global $menu, $submenu, $title;
    //unset($menu[2]);  // ダッシュボード
    unset($menu[4]);  // メニューの線1
    
    $menu[5][0] = '店舗ブログ'; //名称変更
    $submenu['edit.php'][5][0] = 'ブログ一覧';
    $menu[10][0] = '画像';
    $menu[3] = $menu[20]; //固定ページをダッシュボードの下に移動
    $menu[7] = $menu[5]; //ブログを加盟店舗の下に移動
    //$menu[6] //加盟店舗
    unset($menu[5]);  // 移動後にブログ消す
    unset($menu[20]);  // 移動後に固定ページ消す
    print_r($title);
    
    global $current_user;
	//get_currentuserinfo();
    if($current_user->user_login != 'admin' )
		echo "<style>#toplevel_page_edit-post_type-acf{display:none;}</style>";
//    unset($menu[5]); // ブログ
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
add_action('admin_menu', 'changeAdminMenu');

/*
<li class="wp-has-submenu wp-not-current-submenu menu-top menu-icon-generic toplevel_page_edit?post_type=acf menu-top-last" id="toplevel_page_edit-post_type-acf">
	<a href='edit.php?post_type=acf' class="wp-has-submenu wp-not-current-submenu menu-top menu-icon-generic toplevel_page_edit?post_type=acf menu-top-last" aria-haspopup="true">
    <div class="wp-menu-arrow">
    	<div></div>
    </div>
    <div class='wp-menu-image dashicons-before dashicons-admin-generic'><br /></div>
    <div class='wp-menu-name'>カスタムフィールド</div></a>
	<ul class='wp-submenu wp-submenu-wrap'>
        <li class='wp-submenu-head' aria-hidden='true'>カスタムフィールド</li>
        <li class="wp-first-item"><a href='edit.php?post_type=acf' class="wp-first-item">カスタムフィールド</a></li>
        <li><a href='edit.php?post_type=acf&#038;page=acf-export'>Export</a></li>
        <li><a href='edit.php?post_type=acf&#038;page=acf-addons'>Add-ons</a></li>
    </ul>
    </li>
*/


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




/* 管理画面一覧パネルにカスタムフィールドを追加 */
// カスタムカラムのヘッダーテキスト
function custom_admin_field_head($columns) {

    $columns = array_merge($columns,
        array(
            'shop_name' => '店舗名',
            'id' => 'ID',
            )
        );
    return $columns;
    
}
add_filter('manage_post_posts_columns','custom_admin_field_head');
//add_filter('manage_shop_posts_columns','custom_admin_field_head');
//add_filter('manage_blog_posts_columns','custom_admin_field_head');
// https://codex.wordpress.org/Plugin_API/Filter_Reference/manage_pages_columns

// カスタムカラム 管理画面
function custom_admin_field($column, $post_id) {
    
    switch($column) {
        case 'shop_name' :
            $shop = get_post_meta($post_id, 'shop_id', true);
            if($shop > 0) echo get_the_title($shop);
            else echo '<span style="color:tomato;font-weight:bold;">店舗名をセットして下さい</span>';
            break;
        
        case 'id':
            echo $post_id;
            break;
            
        case 'description':
            echo get_post_meta($post_id, 'description', true);
            break;
    }
}
add_filter('manage_post_posts_custom_column', 'custom_admin_field', 10, 2);
//add_filter('manage_shop_posts_custom_column', 'custom_admin_field', 10, 2);
//add_filter('manage_blog_posts_custom_column','custom_admin_field', 10, 2);

//加盟店舗用カラム ----------------------------
function custom_shop_field_head($columns) {

    $columns = array_merge($columns, array('illust_id' => 'TOP用イラスト', 'blog_count' => 'ブログ数', 'id' => 'ID',));
    return $columns;    
}
add_filter('manage_shop_posts_columns', 'custom_shop_field_head');

function custom_shop_field($column, $post_id) {
    
    switch($column) {
        case 'illust_id' :
            $illust_id = get_post_meta($post_id, 'illust_id', true);
            //$obj = new WP_Query(array('meta_key'=>'shop_id', 'meta_value'=>$post_id, 'post_type'=>'attachment', 'post_status'=>'any', 'posts_per_page'=>1));
            //$illust_id = isset($obj->post->ID) ? $obj->post->ID : '';
            if($illust_id) 
            	echo wp_get_attachment_image($illust_id, array(85,85));
            else
            	echo '<span style="color:tomato;font-weight:bold;">イラストをセットして下さい</span>';
            break;
        
        case 'blog_count':
        	$obj = new WP_Query(array('meta_key'=>'shop_id', 'meta_value'=>$post_id, 'post_type'=>'post', 'posts_per_page'=>-1));
            //print_r($obj);
            echo $obj->post_count;
            break;
            
        case 'id':
            echo $post_id;
            break;
    }
}
add_filter('manage_shop_posts_custom_column', 'custom_shop_field', 10, 2);

// メディアカラムのヘッダーテキスト ----------------
function custom_media_field_head($columns) {

    $columns = array_merge($columns, array(
    						'shop_name' => 'TOPイラストの店名',
                            'attachment_url' => 'URL',
                            'id' => 'ID',
                            )
                        );
    return $columns;
    
}
add_filter('manage_media_columns','custom_media_field_head');

function custom_media_field($column, $post_id) {
    
    switch($column) {
    	case 'shop_name' :
        	$shop = get_post_meta($post_id, 'shop_id', true);
            if($shop) echo get_the_title($shop);
            break;
        case 'attachment_url' :
            echo wp_get_attachment_url($post_id) ;
            break;
        
        case 'id':
            echo $post_id;
            break;
    }
}
add_filter('manage_media_custom_column', 'custom_media_field', 10, 2);



