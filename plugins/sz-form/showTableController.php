<?php
//require_once('mail_form-functions.php');
//require_once(ABSPATH . 'wp-config.php'); //'../../../../../wp-config.php'でも可
//require_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/kaibara/functions.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/sue-blog/wp-load.php');

require_once get_template_directory() . "/inc/mail_form/MailFormClass.php";
require_once 'SzForm.php';


global $wpdb; //wp-config.phpを読めば$wpdbが使用できる
$slugname = $_GET['page'];

$mf = new MailForm($slugname);
$szform = new SzForm();

$thisUrl = home_url() . $_SERVER['REQUEST_URI'];

/*
    $wpdb->get_results 一般的なSELECT(object or array)
    $wpdb->get_col 列のSELECT
    $wpdb->get_row　１行取得
*/

//$idNum = 1; //wpのユーザーID
//$userRow = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE ID = $idNum");
//$user_info = get_userdata($idNum);

$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'form_' . $slugname; //kbr_form_inspect など..

if($slugname == 'inspect') {
    $h_title = '視察募集一覧';
}
elseif($slugname == 'newshop') {
    $h_title = '出店者募集一覧';
}
else {
    $h_title = 'お問い合わせ一覧';
}



//現在のユーザー
global $current_user;
get_currentuserinfo();

//現在のURL
$thisUrl = home_url() . $_SERVER['REQUEST_URI'];

?>

<link rel="stylesheet" href="<?php echo plugins_url('style.css', __FILE__); ?>" media="all">
<div class="sz-form">

<?php
	//シングルデータの表示 -------------
	if(isset($_GET['id'])) : 
		$singleObj = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $_GET[id]");
?>
<h2><?php echo $h_title . " 詳細"; ?></h2>
	<div>
    	<a href="<?php echo admin_url('admin.php?page='. $slugname); ?>" class="btn"><< 戻る</a>
    </div>
    
	<div>
    	<table class="table single-table">
        	<colgroup>
                <col class="cth">
                <col class="ctd">
            </colgroup>
        	<tbody>
            	<tr>
                	<th>ID</th>
                    <td><?php echo $singleObj->id; ?></td>
            	<tr>
            	<?php 
                	//Objectの値をarTitleNameのキーから取得し、arTitleNameの値もキーとして利用し、別の配列に入れてそれをループ表示させる
                	$array = array();
                    foreach($mf->arTitleName as $key => $val) {
                    	if($val != '') { //select_first_m やselect_second_d 項目の回避 DBに登録される値はないため
                            if($key == 'mail_add') {
                                $singleObj->$key = '<a href="mailto:'.$singleObj->$key.'">' .$singleObj->$key .'</a>';
                            }
                            $array[$val] = nl2br($singleObj->$key); 
                        }
                } ?>
                
                <?php
                	//ループ表示 
                	foreach($array as $key => $val) { ?>
                	<tr>
                    	<th><?php echo $key; ?></th>
                        <td><?php echo $val; ?></td>
                    </tr>
                <?php } ?>
                
                <tr>
                	<th>応募日</th>
                    <td><?php echo date('Y年n月j日', strtotime($singleObj->time)); ?></td>
                </tr>
                    
            </tbody>
        </table>
    </div>
    
    <div>
    	<a href="<?php echo admin_url('admin.php?page='. $slugname); ?>" class="btn"><< 戻る</a>
    </div>

<?php 
	//Allデータの表示 -----------
	else : 
    //$objs = $wpdb->get_results("SELECT * FROM $table_name", OBJECT);
    $objs = $szform ->getAllObject();
    //echo count($objs);
?>

<h2><?php echo $h_title; ?></h2>
<div>
	<div class="pagenation clear">
		<?php $szform->setPagenation(); ?>
    </div>
    
    <table class="table wp-list-table widefat fixed striped pages">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <?php foreach($mf->arTitleName as $key => $val) :
                	if($val != '') { //select_first_m やselect_second_d 項目の回避 DBに登録される値はないため
                    	echo '<th class="'.$key.'">' . $val .'</th>';
                	}
                endforeach; 
                ?>
                
                <th class="send_date">応募日</th>
                <th></th>
            </tr>
        </thead>
    	<tbody>

            <?php foreach($objs as $obj) : ?>
            <tr>
                <td>
                	<a href="<?php echo $thisUrl . '&id=' .$obj->id; ?>" class="btn">詳細</a>
                </td>

                <?php 
                	//さらにループさせて各項目を表示
                    foreach($obj as $key => $val) {
                        if($key == 'mail_add') {
                            $val = '<a href="mailto:'.$val.'">' .$val .'</a>';
                        }
                        elseif($key == 'time') {
                            $val = date('Y年n月j日', strtotime($val));
                        }
                        echo "<td>".nl2br($val)."</td>"; 
                    }
                ?>

                <td>
                    <a href="<?php echo $thisUrl . '&id=' .$obj->id; ?>" class="btn">詳細</a>
                </td>
            </tr>
            <?php endforeach; ?>
            
        </tbody>
	</table>
    
    <div class="pagenation clear">
		<?php $szform->setPagenation(); ?>
    </div>
</div>

<?php endif; ?>

</div>


