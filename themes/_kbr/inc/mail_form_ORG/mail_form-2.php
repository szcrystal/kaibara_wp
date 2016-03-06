<?php 
require_once('mail_form-functions.php'); 


/* *************************************************** */
   
   session_start();

    
    
    
    if(isLocal()) {
        $_POST = checkInput($_POST); //データチェック
        $sz_ticket = checkTicket(); //チケットの確認＆(POSTの)チケット代入 hiddenで再度渡す
    }
    
    inputSession();
    //$_SESSION['tmpFile'] = file_get_contents($_FILES['upFile']['tmp_name'][0]);
    
    imgUp();
    
    
    //echo $_FILES['upFile']['tmp_name'][0];
    
    //エラーチェック＆出力 jQueryで判別しているので不要
    /*$error = array();
    
    if (trim($name) =='') {
       $error[] = '！『お名前』は必須項目です'; 
    } elseif (mb_strlen($name) > 5) {
        $error[] = '！『お名前』の文字数がオーバーしています';
    }*/

    /*if (trim($mail_add) =='') {
       $error[] = '！『メールアドレス』は必須項目です'; 
    } else {
        $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD';
        if (! preg_match($pattern, $mail_add)) {
            $error[] = '！『メールアドレス』形式が不正です。';
        }
    }*/
    
    //複数選択について
    /*$_SESSION['check'][0] = $check;
    $_SESSION['check'][1] = '今までのサイト所持について？';*/
    //print_r($_SESSION['check']); $_SESSION['check'][0][]に値が入っていることを確認する用

    //$_SESSION['error'] = $error;
    
    //エラー数確認 jQueryなので不要
    /*if (count($error) > 0) {
        ask_form('submit','disabled');
    } else {
    //画面表示
    ask_form('disabled','disabled');
    */
    //echo "abcde" .$_SESSION['logos'][1];
    ?>
    
    <?php $text = '以下の内容で送信します。'."<br />".'よろしければ送信ボタンを押して下さい。';
          $text .= "\n\t<div>";
          $text .= format_func($value="<br />"). "</div>";
          echo $text;
    ?>
   
        <form id="second-form" method="post" name="second-form">
            <input type="hidden" name="sz_ticket" value="<?php echo h_esc($sz_ticket); ?>" />
            <input id="submit-2" type="submit" name="submit" value=" 送　 信 " />
        </form>
        
        <span>◁ 入力画面に戻る</span>
    
