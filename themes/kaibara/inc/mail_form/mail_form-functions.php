<?php 
/* gloval function >> 別ファイルにしてrequireする***** */

//require_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php'); 

//Global variable *****
$dirname = getDirName();
$ar = getTitleAndName(); //form項目のタイトルとname

$thisUrl = home_url() . $_SERVER['REQUEST_URI']; //ページのURL action=""で使用

//$dirname = ($dirname == DIRECTORY_SEPARATOR) ? '' : $dirname;
    
//print_r($ar);

//*****

//データチェック
function checkInput($var) {
    
        if(is_array($var)) {
            return array_map('checkInput', $var);
        }
        else {
            if (get_magic_quotes_gpc()) {
                $var = stripslashes($var);
            }
            if (preg_match('/¥0/', $var)) {
                die('Invalid Input: NOTICE(201)');
            }
            if (! mb_check_encoding($var, 'UTF-8')) {
                die('Invalid Input: NOTICE(202)');
            }
        return $var;
        }
}

//ticket確認
function checkTicket() {
    if (isset($_POST['sz_ticket']) && isset($_SESSION['sz_ticket'])) {
        $value = $_POST['sz_ticket'];
        
            if ( ! in_array($_POST['sz_ticket'], $_SESSION['sz_ticket'])) {
                die('Invalid Access: NOTICE(102)');
            }
      return $value;  
    }
    else {
        die('Invalid Access: NOTICE(103)');
    }
}

//stringHTML
function h_esc($string) {
    return htmlspecialchars($string, ENT_QUOTES);
}

function e_($array, $key, $num) { //num=1 : name/id 出力
	$str = h_esc($array[$key][$num]);

	if($num == 1) {
		$str = 'name="' . $str . '" id="' . $str . '"';
	}

    echo $str;
}

function getDirName() {
	$dir = dirname($_SERVER['SCRIPT_NAME']);
	$dir = str_replace('mail_form', '', $dir);
	$dir = 'http://' . $_SERVER['HTTP_HOST'] . $dir;
    
    return $dir;
}

/* Title and Name ************************************* */
function getTitleAndName() {
	$all_array = array(
            'nick_name' => array('お名前', 'nick_name'),
            'mail_add' => array('メールアドレス', 'mail_add'),
            'belong' => array('所属・団体名','detail'),
            'postcode' => array('郵便番号','comp_name'),
            'address' => array('住所','post_name'),
            'tel_num' => array('電話番号', 'tel_num'),
            'people_num' => array('希望人数', 'people_num'),
            'park_num' => array('駐車場ご利用数', 'park_num'),
            'bus' => array('バスの有無', 'bus'),
            'lunch' => array('昼食の有無', 'lunch'),
            'purpose' => array('視察の目的', 'purpose'),
            'comment' => array('コメント', 'comment'),
    );
    
    return $all_array;
}


//不要sessionのチェック
function checkSessionKey($keyArg) {
	return (
            $keyArg != 'sz_ticket' && 
            $keyArg != 'error' && 
            $keyArg != 'auth' && 
            $keyArg != 'username'
        );
}


function p_sendingMail() {
	//ini_setのopen_basedirがlv9サーバーで効かない　htaccessで指定しても拒否されcPanael内のphp情報がリセットされる
    //ini_set('open_basedir', '/php_sessions:/tmp:/var/www/errors:/home/vol11_4/lv9.org/lv9_15013132/szc.cu.cc/htdocs:/home/vol11_4/lv9.org/lv9_15013132/htdocs');
    
    /*LV9 >> 独自ドメインごとにopen_basedirが書き換えられる
        /php_sessions:/tmp:/var/www/errors:/home/vol11_4/lv9.org/lv9_15013132/szc.cu.cc/htdocs となる
        なのでPEARを/szc.cu.cc/htdocs下にインストールしなければ行けない
    */
    
    //LV9用のiniset ローカル確認の場合は外す
    //ini_set('include_path', '.:/home/vol11_4/lv9.org/lv9_15013132/szc.cu.cc/htdocs/PEAR');
    
    error_reporting(E_ALL & ~E_STRICT);
    
    //Mampローカル／自サーバー用
    //require_once("Cache/Lite.php"); 
    
    //★sakura用
    //require_once("/home/test-sz/Cache/Lite.php");
    
    //DomainKing用のiniset ローカル確認の場合は外す
    if($_SERVER['SERVER_NAME'] != 'localhost')
    	ini_set('include_path', '.:/var/www/vhosts/emerald.cu.cc/inc_legato/pear');
    
    //require_once("Cache/Lite.php");
    require_once("Mail.php");

    /* エンコード */
    mb_language('ja');
    mb_internal_encoding('UTF-8');
    
//    $params = array( //for Zoho
//                    'host' => 'tls://smtp.zoho.com', //tls: > SSL接続
//                    'port' => 465,
//                    'auth' => true,
//                    //'protocol' => 'SMTP_AUTH',
//                    'debug' => false,
//                    'username' => 'info@szc.cu.cc',
//                    'password' => 'ccorenge33',
//                    );
    
//    $params = array( //for MS
//                    'host' => 'smtp.live.com',
//                    'port' => 587,
//                    'auth' => true,
//                    //'protocol' => 'SMTP_AUTH',
//                    'debug' => false,
//                    'username' => 'szc@outlook.jp',
//                    'password' => 'ccorenge33',
//                    );
                    
    $params = array( //googleアカウントから一度弾かれるとブロック旨のメールが来る。そこのリンクからアクセス許可の設定をする
    				'host' => 'tls://smtp.gmail.com',
                    'port' => 465, //587
                    'auth' => true,
                    //'protocol' => 'SMTP_AUTH',
                    'debug' => false,
                    'username' => 'szk.create@gmail.com',
                    'password' => 'ccpeach11',
    				);
    
    
    //$mailTo = 'sumi_yo@outlook.com, szk.create@gmail.com'; //メインアドレス問い合わせの届け先（カンマ区切りで複数指定可）sumi_yo@outlook.com
    $mailTo = 'szk.create@gmail.com, scr.bamboo@gmail.com';
    $mainMail = 'szk.create@gmail.com'; //確認メール内に記載される返信先（ヘッダーアドレス）
    $subject = 'Here is Hearing Sheet Answer : Legato';
    $return_subject = 'ヒアリングシート回答の受信が完了しました。 〜 Legato';
    
    $returnMail = 'szk.create@gmail.com'; //Undelivered Mailの送信先 postfix(smtpなし状態)で確認可能

    $username = $_SESSION['names'][1];
    $usermail = $_SESSION['email'][1];
    
    //サーバーが原因か zohoのメールが原因か　mimeheader_encodeを2022-JPに一旦しないと文字化けする mb_encode_mimeheader($username, 'ISO-2022-JP')
    $headers['From']    = mb_encode_mimeheader($username) .'<'. $usermail .'>';
    $headers['To']      = $mailTo;
    $headers['Subject'] = mb_encode_mimeheader($subject);
    
    $headers_2['From']    = mb_encode_mimeheader('Legato') .'<'. $mainMail . '>';
    $headers_2['To']      = $usermail;
    $headers_2['Subject'] = mb_encode_mimeheader($return_subject);
    
    
    $bodyToMaster = "{$username}さんより、ヒアリングシートの回答が届きました。\n\n\n" . format_mail_func($value="\n") . addInfo(FALSE) ."\n";
    $bodyToUser = format_return($username)."\n";

    
    //mimeheader_encodeで2022-jpにしているのでutf-8に戻す　そうしないと本文が文字化けする mb_convert_encoding($bodyToMaster, 'ISO-2022-JP', 'UTF-8')
    //現在はencodeしていない
    $body = mb_convert_encoding($bodyToMaster, 'ISO-2022-JP', 'UTF-8');
    $body_2 = mb_convert_encoding($bodyToUser, 'ISO-2022-JP', 'UTF-8');
    
    
    //PEAR Mail specify
    $params['sendmail_path'] = '/usr/sbin/sendmail';
    $params['sendmail_args'] = '-t -i';
    
    //mailの方法のセット
    $objMail =& Mail::factory('smtp', $params); //mail or sendmail or smtp
    
    //メインメール送信
    $result = $objMail->send($mailTo, $headers, $body);
    
    if ($ret['master'] = PEAR::isError($result)) {
        die($result->getMessage());
    }
    //クライアント側への送信
    else { 
        $result2 = $objMail->send($usermail, $headers_2, $body_2);
    
        if($ret['user'] = PEAR::isError($result2)) {
        	$headers['subject'] = mb_encode_mimeheader('ユーザー宛のメール送信に失敗しています'); 
            $objMail->send($returnMail, $headers, $body);
        }
    }
	
    $ret['master'] = $ret['master'] ? FALSE : TRUE; //errorだとtrueなので、falseに入れ替える
    $ret['user'] = $ret['user'] ? FALSE : TRUE;

	return $ret;    
}

// Main Mail Sending function *****
function mailSendingFunc() {
	
    $mailTo = 'szk.create@gmail.com, scr.bamboo@gmail.com'; //メインアドレス問い合わせの届け先（カンマ区切りで複数指定可）sumi_yo@outlook.com
    $mainMail = 'szk.create@gmail.com'; //確認メール内に記載される返信先（ヘッダーアドレス）
    $subject = 'Here is Hearing Sheet Answer Legato';
    $return_subject = 'ヒアリングシート回答の受信が完了しました。 〜 Legato';
    
    $returnMail = 'szk.create@gmail.com'; //Undelivered Mailの送信先 postfix(smtpなし状態)で確認可能

    $name = $_SESSION['names'][1];
    $mail_add = $_SESSION['email'][1];

    /* エンコード */
    mb_language('ja');
    mb_internal_encoding('UTF-8');

    /* mail header */
    //改行コードを末尾に入れないとqmail等でerrorになる
    //master
    $headerToMaster = 'From: '. mb_encode_mimeheader($name) .'<'.$mail_add.'>' . "\n";
    $subject = mb_encode_mimeheader($subject, 'ISO-2022-JP', 'UTF-8');
    $bodyToMaster = "{$name}さんより、ヒアリングシートの回答が届きました。\n\n\n" . format_mail_func($value="\n") . addInfo(FALSE) ."\n";
    
    //user
    $headerToUser = 'From: '. mb_encode_mimeheader('Legato').'<'.$mainMail.'>' . "\n"; //確認メールヘッダー
    $return_subject = mb_encode_mimeheader($return_subject, 'ISO-2022-JP', 'UTF-8');
    $bodyToUser = format_return($name)."\n";
    
    $arr = array();
    $ret = array();
    
    // send mail to master
    $arr = mailHeaderAndBody($headerToMaster, $bodyToMaster); //Header and Body Output
    $ret['master'] = mb_send_mail( $mailTo, $subject, $arr['body'], $arr['header'], '-f' . $returnMail ); //main sendmail
    
    
    // return mail to user 
    if($ret['master']){ 
    	$arr = mailHeaderAndBody($headerToUser, $bodyToUser);
        $ret['user'] = mb_send_mail( $mail_add, $return_subject, $arr['body'], $arr['header'], '-f'. $returnMail ); //確認メールの送信
        //if(!$ret) echo "mailToUserがおかしい";
    }
    
    return $ret;

}

function mailHeaderAndBody($headerArg, $bodyArg) {

	$hb = array();
    
	$header = $headerArg;
	//$header .= 'MIME-Version: 1.0'."\n";
//    $header .= "Content-Type: multipart/mixed; boundary=\"__LEGATOMAIL__\"\n";
//    $header .= "\n";
    
    $hb['header'] = $header;
    
    
//    $body = "--__LEGATOMAIL__\n";
    //$body = "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n";
//    $body .= "\n";
    $body = $bodyArg;
//    $body .= "--__LEGATOMAIL__--\n";
    
    $hb['body'] = $body;
    
    return $hb;
}

function addInfo($boolArg) {
	$info = "\n\n\n______________________________________________________";

	if($boolArg) {
		$info .= "\n\n" . $_SERVER['HTTP_USER_AGENT'];
    	$info .= "\n\n" . $_SERVER['REMOTE_ADDR'];
    	$info .= "\n\n" . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "\n\n";
        $info .= "______________________________________________________";
    }
    
    return $info;
}

function format_func($turnArg) {

        $all_format = array();
        $out_format = "<p><span>■%s</span><br/>{$turnArg}%s</p>";
        $out_format_check = "<p><span>%s</span>{$turnArg}　・%s</p>";
        
       /* if ( ! $_SESSION['check'][0] == '') {
            $check_value = implode("{$value}　　・", $_SESSION['check'][0]);
        }*/
        
        //サイト上で改行して表示させるなら
        //$_SESSION['comment'][0] = str_replace("\n", "<br />", $_SESSION['comment'][0]);
        
            foreach ($_SESSION as $key => $val) {
                
                if ($key == 'check' && $_SESSION['check'][1] != '') {
                    $check_value = implode("{$turnArg}　　・", $_SESSION['check'][1]);
                    $all_format[] = sprintf($out_format_check, $val[0], $check_value);
                }

                else if ( checkSessionKey($key) ) {
                	$inputValue = h_esc($val[1]);
                	
                    if(strpos($inputValue, "\n")) { // 改行文字があればnl2br()をして返す
                    	$inputValue = nl2br($inputValue);
                    }
                    
                    $all_format[] = sprintf($out_format, h_esc($val[0]), $inputValue);
                }
            }
        
        return implode("$turnArg", $all_format);
}

/* メール送信用フォーマット */
function format_mail_func($turnArg) {
    
    $all_format = array();
    $out_format = "■ %s{$turnArg}%s";
    
    //サイト上で改行表示した場合に、改行コードを戻す
    //$_SESSION['comment'][0] = str_replace("<br />", "\n", $_SESSION['comment'][0]);
        
        foreach ($_SESSION as $key => $val) {
            if ( checkSessionKey($key) ) {
                    $all_format[] = sprintf($out_format, $val[0], $val[1]);
                }
        }
        
        return implode("$turnArg"."$turnArg", $all_format);
}

/* DBセット用フォーマット */
function format_db_func() {
	$db_format = array();
    
	foreach ($_SESSION as $key => $val) {
        if ( checkSessionKey($key) ) {
            $db_format[$key] = $val[1]; //nameと値の組みで配列に入れる
        }
    }
    $db_format['time'] = current_time( 'mysql' );
    
    return $db_format; //array
}

/* 確認メール用フォーマット */
function format_return($arg) {
	//global $wpdb;
    
    $adminRow = getAdminRow();

//to user mail sentence
$sentence = <<<EOL
{$arg} 様

$adminRow->admin_head


□□□□□□□　お問い合わせ内容　□□□□□□□

EOL;

    $context = $sentence;
    $context .= format_mail_func($value="\n");
    $context .= "\n\n\n\n\n";
    $context .= $adminRow->admin_foot;
    //$context .= "\n\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\t\n\t\n\t\n";
    
    return $context;
}

//Admin用メールフォーマット
function format_admin() {

	$adminRow = getAdminRow();

//to Admin mail sentence
$sentence = <<<EOL

視察募集についてサイトより応募がありました。
頂きました内容は下記となります。


□□□□□□□　内容　□□□□□□□

EOL;
    
    $context = $sentence;
    $context .= format_mail_func($value="\n");
    $context .= "\n\n\n\n" . getAdminRow()->admin_foot;
    return $context;
}

//adminRow（管理者設定値）をDBから取得
function getAdminRow() {
	global $wpdb;
    
	$table_name = $wpdb->prefix . 'form_admin';
    $row = $wpdb->get_row("SELECT * FROM $table_name LIMIT 1");
    
    return $row;
}

// checkbox / radio / select のchecked/selected属性を入れる
function checkValue($name, $value, $or='check') {
	
    $str = 'value="'. $value . '"';
    
	if(isset($_SESSION[$name][1]) && $_SESSION[$name][1] == $value) {
    	if($or == 's') {
        	$str = $str . ' selected="selected"';
        }
        else {
	    	$str = $str . ' checked="checked"';
        }
    }
    
    echo $str;
}


function setSessionAndCheckError() {
	
    //global $ar;

    $ar = getTitleAndName();
    
    foreach($ar as $key => $val) { //$ar : function.php global val
        $_SESSION[$key][0] = $val[0];
        $_SESSION[$key][1] = isset($_POST[$key]) ? $_POST[$key] : NULL;
    }

	//エラーチェック＆出力
    $error = array();
    $name = $_SESSION['nick_name'][1];
    $mail_add = $_SESSION['mail_add'][1];
 
    //$name = $_POST['nick_name'][1];
    //$mail_add = $_POST['mail_add'][1];

    
    if (trim($name) =='') {
       $error[] = '『お名前』は必須項目です'; 
    } elseif (mb_strlen($name) > 20) {
    	$error[] = mb_strlen($name);
        $error[] = '『お名前』の文字数は全角20文字以内でお願いします。';
    }

    if (trim($mail_add) =='') {
       $error[] = '『メールアドレス』は必須項目です'; 
    } else {
        $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD';
        if (! preg_match($pattern, $mail_add)) {
            $error[] = '『メールアドレス』形式が不正です。';
        }
    }
    
    
    //エラー数確認 jQueryの場合は不要
    if (count($error) > 0) {
    	$_SESSION['error'] = $error;
        //return $error;
		
        //header前にechoを入れるとエラーになる echoで出力となるのでエラーになる	
        //header('HTTP/1.1 303 See Other');
        //header('Location: ' . $dirname);
    }
    else {
	    $_SESSION['error'] = NULL;
        //return NULL;
	}
}

function setDB($wpdbArg) {
	
}


//session clear
function clear($boolAg = TRUE) {
	$_SESSION = array();
    session_destroy();
    
//    if($boolAg) {
//	    setcookie('compAuth', 1, time()+60);
//        //echo $_SESSION['compAuth'];
//    
//    }
}












