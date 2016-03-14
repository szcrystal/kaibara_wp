<?php 

/* THEME NAME HERE  ***** */
$themeName = 'punkt_jp';
/* ********************** */


function isLocal() {
    return ($_SERVER['SERVER_NAME'] == 'localhost');
}

function imgUp() {
    //画像アップロード ---------------
//if(!isset($_FILES)) {

    global $themeName;
    
    $filePath = realpath(dirname(__FILE__)). '/images'; //絶対パス
    
    //$filePath = get_template_directory_uri(). '/images/first'; //urlはダメぽい
    //echo @$_FILES['uploadfile']['name'][0]."<br />";

    $_SESSION['imgArray'][0] = '添付ファイル';

for($i=0; $i < count(@$_FILES['upFile']['name']); $i++) {
    $error ='';
    
    if(strlen($_FILES['upFile']['name'][$i]) > 0) { //or OK $_FILES['uploadfile']['name'][$i] is exist or not
        $imgType = $_FILES['upFile']['type'][$i];
        $extension = '';
        //echo "png success<br />";
        if($imgType == 'image/gif') {
            $extension = 'gif';
        }
        elseif($imgType == 'image/png' || $imgType == 'image/x-png') {
            $extension = 'png';
            
        }
        elseif($imgType == 'image/jpeg' || $imgType=='image/pjpeg') {
            $extension = 'jpg';
        }
        else {
            $error .='Not Allowed Extension'."<br />";
        }
        
        $checkImage = getimagesize($_FILES['upFile']['tmp_name'][$i]);
        if($checkImage == FALSE) {
            $error .= 'ファイルをアップロードして下さい';
        }
        else if($imgType != $checkImage['mime']) {
            $error .= '拡張子が違います';
        }
        else if($_FILES['upFile']['size'][$i] > 33554432) { //100KB > 102400バイト 32MB > 33554432 Byte
            /* Googleで 100KB 何バイト で表示される 単位は大文字で */
            $error .='ファイルサイズが大きすぎます 32MB以下にして下さい';
        }
        else if($_FILES['upFile']['size'][$i] == 0) {
            $error .='空ファイル';
        }
        else if ($extension != 'gif' && $extension != 'jpg' && $extension != 'png') {
            $error .= '可能ファイルはgif, jpg, png';
        }
        else {
            $imgName = '/upfile_'. time(). $i. '.'. $extension;
            $moveTo = $filePath. $imgName;
            if(!move_uploaded_file($_FILES['upFile']['tmp_name'][$i], $moveTo)) { //画像アップロード関数
                $error .= 'Upload失敗';
            }
            
        }
        
        if($error == '') {
            //echo $moveTo. '<< Upped Place<br />'."\n";
            //if(isset($_FILES)) {
                
                //$_SESSION['imgArray'][0]にラベル名を入れている　↑で
                $_SESSION['imgArray'][1][] = '<img class="upimg" src="/wp-content/themes/'. $themeName. '/inc/mail_form/images/'.$imgName.'" alt="UploadedImage" />'."\n";
                
                $_SESSION['addImgName'][] = $moveTo; //select >optionで使用
        }
        else {
            echo $error . '<br />';
        }
        
    }//if strlen
  
}// for

}


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
                die('PostError: 101');
            }
            if (! mb_check_encoding($var, 'UTF-8')) {
                die('PostError: 102');
            }
        return $var;
        }
}

//ticket確認
function checkTicket() {
    if (isset($_POST['sz_ticket']) && isset($_SESSION['sz_ticket'])) {
        $value = $_POST['sz_ticket'];
        
            if ( ! in_array($_POST['sz_ticket'], $_SESSION['sz_ticket'])) {
                echo 'TicketError: 1001';
            }
            else {
                return $value;  
            }
    }
    else {
        echo 'TicketError: 1002';
    }
}

//stringHTML
function h_esc($string) {
        return htmlspecialchars($string, ENT_QUOTES);
}



//session
function beforeSession($labelName, $arg) {
    
    if($arg == 'sampleSite' || $arg == 'ckSystem') {
        $_SESSION[$arg][0] = $labelName;
        
        $_POST[$arg] = array_filter($_POST[$arg]); //空値を削除
        $_POST[$arg] = array_values($_POST[$arg]); //添字打ち直し
        
        $_SESSION[$arg][1] = isset($_POST[$arg]) ? $_POST[$arg] : NULL;
    }
    else {
        $_SESSION[$arg][0] = $labelName;
        $_SESSION[$arg][1] = isset($_POST[$arg]) ? $_POST[$arg] : NULL;
    }
    
}


function inputSession() {
    beforeSession('お名前', 'newName');
    beforeSession('メールアドレス', 'eMail');
    beforeSession('サイトの種類', 'siteType'); //check
    beforeSession('対応端末', 'term');
    beforeSession('納品希望日', 'finishDay');
    beforeSession('ご予算', 'budget');
    if(isset($_POST['isCd'])) {
        beforeSession('現在のサイト', 'currentSite');
    }
    beforeSession('参考サイト', 'sampleSite');
    beforeSession('メインの色', 'color');
    beforeSession('ロゴ', 'logos');
    beforeSession('レスポンシブ', 'responsive');
    beforeSession('システム', 'ckSystem');  //check & other
    //beforeSession('他システム', 'systemType');
    beforeSession('素材', 'material');
    beforeSession('その他ご要望', 'comment');
    
}


//mail format
function format_func($value) {

        $all_format = array();
        $out_format = "<p><em>%s</em><br />　%s</p>";
        $out_format_check = "<p><em>%s</em>{$value}　%s</p>";
        
       /* if ( ! $_SESSION['check'][0] == '') {
            $check_value = implode("{$value}　　・", $_SESSION['check'][0]);
        }*/
        
        //サイト上で改行して表示させるなら
        //$_SESSION['comment'][0] = str_replace("\n", "<br />", $_SESSION['comment'][0]);
        
            foreach ($_SESSION as $val => $key) {
                
                if ($val == 'ckSystem' || $val == 'sampleSite' ) { 
                    if($_SESSION[$val][1] != '') {
                        
                        $check_value = implode("{$value}　", $_SESSION[$val][1]); //★
                        $all_format[] = sprintf($out_format_check, $_SESSION[$val][0], $check_value);
                    }
                }

                else if ($val =='imgArray') {
                    if($_SESSION[$val][1] != '') {
                        $check_value = implode("\n", $_SESSION[$val][1]);
                        $all_format[] = sprintf($out_format_check, $_SESSION[$val][0], $check_value);
                    }
                }
                else if (escapeSession($val)) { //書き出し不要のSessionの除外関数 下にあり
                    $all_format[] = sprintf($out_format, $_SESSION[$val][0], $_SESSION[$val][1]);
                }
            }
        
        return implode("$value", $all_format);
        
}

/* メール送信用フォーマット */
function format_mail_func($value) {
    
    $all_format = array();
    $out_format = "● %s{$value}　%s";
    $out_format_check = "● %s\t{$value}%s";
    
    //サイト上で改行表示した場合に、改行コードを戻す
    //$_SESSION['comment'][0] = str_replace("<br />", "\n", $_SESSION['comment'][0]);
        
        foreach ($_SESSION as $val => $key) {
             
            if ($val == 'ckSystem' || $val == 'sampleSite') { 
                    if($_SESSION[$val][1] != '') {
                        $check_value = implode("\t{$value}", $_SESSION[$val][1]);
                        $all_format[] = sprintf($out_format_check, $_SESSION[$val][0], $check_value);
                    }
            }
            /*else if ($val =='imgArray') {
                    if($_SESSION[$val][1] != '') {
                        $check_value = implode("\n", $_SESSION[$val][1]);
                        $all_format[] = sprintf($out_format_check, $_SESSION[$val][0], $check_value);
                    }
            }*/
            else if ( escapeSession($val)) { //書き出し不要のSessionの除外関数 下にあり
                    $all_format[] = sprintf($out_format, $_SESSION[$val][0], $_SESSION[$val][1]);
                }
            }
        
        return implode("$value"."$value", $all_format)."$value"."$value";
    
}

function escapeSession($arg) {   
     return ( $arg != 'sz_ticket' && $arg != 'error' && $arg != 'addImgName' && $arg != 'imgArray' && $arg != 'temp_code');
    
}

/* 確認メール用フォーマット */
function format_return($arg) {
    $context = "{$arg} 様\n\nPunktです。\nデザインのお申し込みを頂き誠にありがとうございます。\n\n早速内容を確認次第ご返信致しますのでそれまでしばらくお待ち下さい。\n\n尚、お問い合わせ頂きました内容は以下となりますのでご確認下さい。\n訂正などありましたら改めて送信をお待ちしておりますので、どうぞよろしくお願い致します。\n\n\n";
    //$context .= format_mail_func($value="\n");
    //$context .= "\n\n\n-----------------------------------------------------------------------------------\n\n";
    
    
    return $context;

}


function c_sendingMail() {
    $mailTo = 'szk.create@gmail.com'; //正式→'contact@kazue.net,gracias@szcreate.jp'
    $mainMail = 'scr.bamboo@gmail.com'; //正式→'barittohanachan@olive.plala.or.jp' 確認メール内に記載される返信先（ヘッダーアドレス）
    $subject = '新規デザインのお申し込みがありました';
    $returnMail = 'scr.bamboo@gmail.com'; //Undelivered Mailの送信先 postfix(smtpなし状態)で確認可能
    
    $return_subject = 'お問い合わせありがとうございます。';
    
    $_POST = checkInput($_POST); //入力データの確認
    
    //if(isLocal()) {
        checkTicket(); //チケット確認
    //}
    
    $name = $_SESSION['newName'][1];
    $mail_add = $_SESSION['eMail'][1];
    
//    $fileName = $_SESSION['addImgName'][0];
    $fname = $_SESSION['addImgName'][1];
//    print_r($_SESSION['upFile']);
    //echo  "Filename:" .$fname;
    
    $mailMessage = format_mail_func("\n");
    
    /* エンコード */
    mb_language('ja');
    mb_internal_encoding('UTF-8');



    /* mail header */
    //改行コードを末尾に入れないとqmail等でerrorになる 
    //CRLF(\r\n)が推奨らしい。LF(\n)のみにするのは最後の手段らしい(うまく送信されない時に試す)
    // php.net/mb_send_mailにqmailでは\nをCRLFに自動変換するので二重になるが、最後の手段で・・の記述あり
    $header = 'FROM: '. mb_encode_mimeheader($name) .' <'.$mail_add.'>'."\n"; //改行コードを末尾に入れないとqmail等でerrorになる
    $header .= 'MIME-Version: 1.0'."\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"__SZCMAIL__\"\n";
    $header .= "\n";
    
    $body = "--__SZCMAIL__\n";
    $body .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n";
    $body .= "\n";
    $body .= $mailMessage ."\n";
    
    if(isset($_SESSION['addImgName'])) {
        foreach($_SESSION['addImgName'] as $fileName) {
            $body .= "--__SZCMAIL__\n"; // < これを節目に挟む必要があり headerで指定されているboundary
                $handle = fopen($fileName, 'r');
                $attachFile = fread($handle, filesize($fileName));
                fclose($handle);
                
                $attachEncode = base64_encode($attachFile);
            
            $body .= "Content-Type: image/jpeg; name=\"$fileName\"\n"; //
            $body .= "Content-Transfer-Encoding: base64\n";
            $body .= "Content-Disposition: attachment; filename=\"$fileName\"\n";
            $body .= "\n";
            $body .= chunk_split($attachEncode) . "\n";
        }
    }
    $body .= "--__SZCMAIL__--\n";
    

    //$return_header = 'FROM: '. mb_encode_mimeheader('Punkt').' <'.$mainMail.'>'."\n"; //確認メールヘッダー
    
    /* send mail */
    //$result = mb_send_mail( $mailTo, $subject, format_mail_func($value="\n"), $header, '-f' . $returnMail );
    
    //send mail to Master
    $result = mb_send_mail( $mailTo, $subject, $body, $header, '-f' . $returnMail );
    
  
    if($result){
            //send mail to User
            $header = 'FROM: '. mb_encode_mimeheader('Punkt') .' <'.$mainMail.'>'."\n"; //改行コードを末尾に入れないとqmail等でerrorになる
            $header .= 'MIME-Version: 1.0'."\n";
            $header .= "Content-Type: multipart/mixed; boundary=\"__SZCMAIL__\"\n";
            $header .= "\n";
            
            $body = "--__SZCMAIL__\n";
            $body .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n";
            $body .= "\n";
            $body .= format_return($name) ."\n";
            $body .= $mailMessage ."\n";
            
            if(isset($_SESSION['addImgName'])) {
                foreach($_SESSION['addImgName'] as $fileName) {
                    $body .= "--__SZCMAIL__\n"; // < これを節目に挟む必要があり headerで指定されているboundary
                        $handle = fopen($fileName, 'r');
                        $attachFile = fread($handle, filesize($fileName));
                        fclose($handle);
                        
                        $attachEncode = base64_encode($attachFile);
                    
                    $body .= "Content-Type: image/jpeg; name=\"$fileName\"\n"; //
                    $body .= "Content-Transfer-Encoding: base64\n";
                    $body .= "Content-Disposition: attachment; filename=\"$fileName\"\n";
                    $body .= "\n";
                    $body .= chunk_split($attachEncode) . "\n";
                }
            }
            $body .= "--__SZCMAIL__--\n";
            
            mb_send_mail( $mail_add, $return_subject, $body, $header, '-f'.$returnMail ); //確認メールの送信
        
            echo "<div>\n<p><span>".'ありがとうございます。送信が完了しました。'."</span><br /><br />".'お問い合わせの内容を確認次第、ご返信を致します。'."<br /><br />".'尚、記載頂いたメールアドレス宛に確認メールをお送りしております。'."<br />".'もし確認メールが届いていない、また返信がなかなか到着しないなどありましたら、大変お手数をお掛け致しますがメール等にて直接ご連絡頂きます様お願い致します。'."</p>";
            $_SESSION = array();
            session_destroy();
    }
    else{
        echo '送信に失敗しました。'."<br />".'お手数をお掛け致しますが、再度送信し直すか直接メールにてお問い合わせ下さいますようお願い致します。'."<br />";
        $_SESSION = array();
        session_destroy();
        //mb_send_mail( $mail_add, $return_subject, format_return($name), $return_header, '-f'.$returnMail );
    }
}


