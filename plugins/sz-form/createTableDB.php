<?php
//echo plugins_url() . '/plg-functions.php';
//require_once('mail_form-functions.php');
//require_once(ABSPATH . 'wp-config.php'); //'../../../../../wp-config.php'でも可 >>wp-configを読まなくても$wpdbが使える
require_once('SzForm.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/kaibara/functions.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/sue-blog/wp-load.php');


//クラスインスタンス
$sf = new SzForm();

//現在のユーザー
global $current_user;
get_currentuserinfo();

//現在のURL
$thisUrl = home_url() . $_SERVER['REQUEST_URI'];


/* POST時にテーブルを作成する*/
if(isset($_POST['createtable']) && $_POST['createtable']) {
	$sf -> createAllTable();
}

$postResult = '';
if(isset($_POST['adminpost']) && $_POST['adminpost']) {
    $postResult = $sf ->updateAdminData() ? '<p class="green">管理者設定を更新しました</p>' : '<p class="red">管理者設定の更新に失敗しました</p>';
}


?>
<link rel="stylesheet" href="<?php echo plugins_url('style.css', __FILE__); ?>" media="all">
<div class="sz-form">
	<h2>管理者設定</h2>
    <div class="clear">
        <span>応募したユーザー宛に自動で返信されるメールの設定をここでします。</span>
        <ul>
        	<li>件名とヘッダーテキストのみ各種別で分かれていますのでそれぞれ指定して下さい。それ以外は全ての種類において共通です。
            <li>管理者用メールアドレスは、カンマ区切りで複数設定可能です。複数指定する場合、サーバーへの負荷影響がありますので２〜３個程度が推奨です。
            <li>管理者用メールアドレスを複数指定した場合、先頭に記載したアドレスがメインアドレスとなり、ユーザー側へ送信するメールの送信元となります。
            <li>設定変更後は、必ず自身で実際にフォームを送信してテストすることをお勧めします。
        </ul>

    </div>

<div class="form-area clear">
	<?php 
    	echo ($postResult != '') ? $postResult : '';
    ?>    
    
    <?php $obj = $sf->getAdminData(); ?>
    
	<form method="post" action="<?php echo $thisUrl; ?>">
    	<div>
    		<label>●管理者名・サイト名（共通）</label>
        	<input type="text" name="admin_name" value="<?php echo $obj->admin_name; ?>">
        </div>
        
        <div>
        	<label>●管理者メールアドレス（共通）＊複数指定の場合はカンマ区切りで入力</label>
        	<input type="text" name="admin_email" value="<?php echo $obj->admin_email; ?>">
        </div>
        <hr>
        <label>●件名</label>
        <div>
    		<label>視察募集用</label>
        	<input type="text" name="admin_subject_inspect" value="<?php echo $obj->admin_subject_inspect; ?>">
        </div>
        
        <div>
    		<label>出店者募集用</label>
        	<input type="text" name="admin_subject_newshop" value="<?php echo $obj->admin_subject_newshop; ?>">
        </div>
        
        <div>
    		<label>お問い合わせ用</label>
        	<input type="text" name="admin_subject_contact" value="<?php echo $obj->admin_subject_contact; ?>">
        </div>
        <hr>
        <label>●ヘッダーテキスト</label>
        <div>
        	<label>視察募集用</label>
        	<textarea rows="3" cols="15" name="admin_head_inspect"><?php echo $obj->admin_head_inspect; ?></textarea>
        </div>
        
        <div>
        	<label>出店者募集用</label>
        	<textarea rows="3" cols="15" name="admin_head_newshop"><?php echo $obj->admin_head_newshop; ?></textarea>
        </div>
        
        <div>
        	<label>お問い合わせ用</label>
        	<textarea rows="3" cols="15" name="admin_head_contact"><?php echo $obj->admin_head_contact; ?></textarea>
        </div>
        <hr>
        <div>
        	<label>●フッターテキスト（共通）</label>
        	<textarea rows="3" cols="15" name="admin_foot"><?php echo $obj->admin_foot; ?></textarea>
        </div>
        
        <input type="hidden" name="adminpost" value="1">
        <input type="submit" name="sbmt" value="送信">
    </form>
</div>

<div class="form-area createTable">
    <?php if($current_user->user_login == 'admin') { 
        echo 'Username: ' . $current_user->user_login . "\n";
    ?>

    <form method="post" action="<?php echo $thisUrl; ?>">
        <input type="hidden" name="createtable" value="1">
        <input type="submit" name="sbmt" value="CreateTable">
    </form>

    <?php } ?>
</div>

</div>




