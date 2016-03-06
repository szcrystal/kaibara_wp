<?php 
require_once('mail_form-functions.php'); 

/* ****************************************************** */
// ☆jQueryでpostする場合form のaction属性は不要　↓ 
session_start();
ini_set('error_reporting', E_ALL);

    $sz_ticket = md5(uniqid(mt_rand(), TRUE));
    $_SESSION['sz_ticket'][] = $sz_ticket;

    //$_SESSION = array(); session_destroy();
    
?>

<?php
//    echo $_POST['des'];
//
//    if(@$_POST['des'] == "dd") {
//        $_SESSION = array();
//        session_destroy();
//        $_POST['des'] = '';
//    }
//    print_r($_SESSION);

?>

    
    <div id="cd-form">
        <p class="name-error"></p>
        <p class="mail-error"></p>


        <form id="first-cd-form" method="post" autocomplete="on" action="">
        
            <label for="newName">お名前<em>*</em></label>
            <input id="newName" type="text" name="newName" value="<?php echo h_esc(@$_SESSION['newName'][1]); ?>" />

            <label for="mail_add">メールアドレス<em>*</em></label>
            <input id="eMail" type="email" name="eMail" value="<?php echo h_esc(@$_SESSION['eMail'][1]); ?>" />
            
            <label for="siteType">サイトの種類</label>
            <input class="siteType" type="radio" name="siteType" value="EC" checked="checked" /><p>EC</p>
            <input class="siteType" type="radio" name="siteType" value="ブログ" /><p>ブログ</p>
            <input class="siteType" type="radio" name="siteType" value="ランディングページ" /><p>ランディングページ</p>
            <input class="siteType" type="radio" name="siteType" value="HTMLメール" /><p>HTMLメール</p>
            <input class="siteType" type="radio" name="siteType" value="ブログ" /><p>会社</p>
            <input class="siteType" type="radio" name="siteType" value="その他" /><p>その他</p>
        
            
            <label for="term">対応機種</label>
            <input class="term" type="radio" name="term" value="PCのみ" checked="checked" /><p>PCのみ</p>
            <input class="term" type="radio" name="term" value="スマートフォンのみ" /><p>スマートフォンのみ</p>
            <input class="term" type="radio" name="term" value="PC・スマートフォン" /><p>PC・スマートフォン</p>
        
        
            <label for="finishDay">納品希望日</label>
            <input id="finishDay" type="text" name="finishDay" value="<?php echo h_esc(@$_SESSION['finishDay'][1]); ?>" />
            
            <label for="budget">ご予算</label>
            <input id="budget" type="text" name="budget" value="<?php echo h_esc(@$_SESSION['budget'][1]); ?>" />
            
            <label for="currentSite">現在のサイト</label>
            <input id="currentSite" type="text" name="currentSite" value="<?php echo h_esc(@$_SESSION['currentSite'][1]); ?>" />
            
            <label for="sampleSite">参考サイト</label>
            <input class="sampleSite" type="text" name="sampleSite[]" value="<?php echo h_esc(@$_SESSION['sampleSite'][1][0]); ?>" /><br />
            <input class="sampleSite" type="text" name="sampleSite[]" value="<?php echo h_esc(@$_SESSION['sampleSite'][1][1]); ?>" /><br />
            <input class="sampleSite" type="text" name="sampleSite[]" value="<?php echo h_esc(@$_SESSION['sampleSite'][1][2]); ?>" />
            
            <label for="color">希望するメインの色</label>
            <input id="color" type="text" name="color" value="<?php echo h_esc(@$_SESSION['color'][1]); ?>" />
            
            <label for="logos">ロゴ制作</label>
            <input class="logos" type="radio" name="logos" value="必要" checked="checked"/><p>必要</p>
            <input class="logos" type="radio" name="logos" value="不要" /><p>不要</p>
            
            <label for="responsive">レスポンシブ</label>
            <input class="responsive" type="radio" name="responsive" value="必要" checked="checked" /><p>必要</p>
            <input class="responsive" type="radio" name="responsive" value="不要" /><p>不要</p>
            
            <label for="checkbox">システム</label>
            <input class="ckSystem" type="checkbox" name="ckSystem[]" value="html" /><p>HTML</p>
            <input class="ckSystem" type="checkbox" name="ckSystem[]" value="css" /><p>CSS</p>
            <input class="ckSystem" type="checkbox" name="ckSystem[]" value="javascript" /><p>JavaScript</p>
            <input class="ckSystem" type="checkbox" name="ckSystem[]" value="wordpress" /><p>WordPress</p>
            <input class="ckSystem" type="checkbox" name="ckSystem[]" value="php" /><p>PHP</p>
            <input class="ckSystem" type="checkbox" name="ckSystem[]" value="その他" /><p>その他</p>
            <input class="ckSystemVal" type="text" name="ckSystem[]" value="<?php /*echo h_esc($_SESSION['ckSystem']);*/ ?>" />
            
            <label for="material">素材（写真・装飾）</label>
            <input class="material" type="radio" name="material" value="持っている" checked="checked" /><p>持っている</p>
            <input class="material" type="radio" name="material" value="持っていない" /><p>持っていない</p>
               
            <label for="comment">その他ご要望</label>
            <textarea id="comment" rows="15" cols="60" name="comment"><?php echo h_esc(@$_SESSION['comment'][1]); ?></textarea><br />
            
            <label for="file">参考資料を添付</label>
            <input type="file" name="upFile[]" /><br />
            <input type="file" name="upFile[]" /><br />
            <input type="file" name="upFile[]" /><br />

            <input type="hidden" name="imgUpload" value="true" />
            
            <input id="sz_ticket" type="hidden" name="sz_ticket" value="<?php echo h_esc($sz_ticket); ?>" />
            <input id="chSubmit" type="submit" name="chSubmit" value="送信内容を確認" />
            <input id="isCd" type="hidden" name="isCd" value="cd" />
            
        </form>
        
        <?php //phpinfo(); ?>
        
        <!--
        <form method="post" action="" enctype="multipart/form-data"><?php /*画像UP enctype */ ?>
            <input type="file" name="uploadfile[]" /><br />
            <input type="submit" value="アップロード" /><br />
            <input type="hidden" name="imgUpload" value="true" />
        </form> -->
        <?php 
            //print_r(@$_FILES);
            //print_r(@$_POST['uploadfile']);
            
            //print_r($_SERVER);
            //print_r($_COOKIE);
            //print_r(@$_SESSION['imgArray']);
            //print_r(@$_SESSION['addImgName']);
                //echo );
                //echo @$imgType ."<br />" . @$extension ."これ"; 
        ?>
        

        <?php /*画像Resetフォーム */ ?>
        <!--
        <form method="post" action="">
            <input type="submit" value="Reset" />
            <input type="hidden" name="reset" value="true" />
        </form>
        -->
        
        
        <p class="all-error"></p>
    </div>

    <div id="report-form"></div>
    <div id="report-form-2"></div>
