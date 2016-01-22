<?php 

require_once('MailFormClass.php');

class MailFormError extends MailForm {
	
    public $mf;

	public function __construct($classArg) {
    	$this->mf = $classArg; //MailFormClassのObject
        $this->session = $_SESSION[$this->mf->type]; 
    }
    
    //空入力に対しての返すテキスト
    private function returnRequireEmpty($strArg) {
    	$strArg = $this->mf->arTitleName[$strArg];
    	return '『' . $strArg . '』は必須です。'; 
    }

	//nameとmailのチェック関数（ここはどれも共通なので１つの関数にする）
	private function checkNameAndMail() {
    	
        //MailFormオブジェクト
        //$m = $this->mfObj;
        
        $titleName = $this->mf->arTitleName;
        

    	$name = $this->session['nick_name'][1];
        $mail_add = $this->session['mail_add'][1];
        
        $error = array();
        
        if (trim($name) =='') {
           $error[] = $this->returnRequireEmpty('nick_name'); 
        }
        elseif (mb_strlen($name) > 20) {
            //$error[] = mb_strlen($name);
            $error[] = '『' . $titleName['nick_name'] . '』の文字数は全角20文字以内でお願いします。';
        }

        if (trim($mail_add) =='') {
           $error[] = $this->returnRequireEmpty('mail_add'); 
        }
        else {
            $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD';
            if (! preg_match($pattern, $mail_add)) {
                $error[] = '『' .$titleName['mail_add'] . '』形式が不正です。';
            }
        }
        
        return $error;
    }
    
    private function checkOtherError() {
    	$error = array();
        
    	$tel_num = $this->session['tel_num'][1];
        $first_date_time = $this->session['first_date_time'][1];
        
        //TEL番号チェック
        if (trim($tel_num) =='') {
           $error[] = $this->returnRequireEmpty('tel_num'); 
        }
        
        //First Dateチェック
        if(strpos($first_date_time, '--') !== FALSE) {
            $error[] = $this->returnRequireEmpty('first_date_time');
        }
        
        if($this->mf->isType('inspect')) { //視察フォームのみのエラーチェック
        	
            //second Date
        	$second_date_time = $this->session['second_date_time'][1];
        	if(strpos($second_date_time, '--') !== FALSE) {
            	$error[] = $this->returnRequireEmpty('second_date_time');
        	}
            
            //視察目的
            $purpose = $this->session['purpose'][1];
            if (trim($purpose) =='') {
               $error[] = $this->returnRequireEmpty('purpose'); 
            }
        }
        
        return $error;
    }
    


	//最終実行の関数
    public function checkAllError() {
        //global $ar;
        //$ar = $this->getTitleAndName();
        
//        if($this->type == 'inspect')
//	        $array =  $this->arInspect;
//    	elseif($this->type == 'newshop')
//        	$array = $this->arNewshop;

		//$this->mf->setDataToSession();

        //エラーチェック＆出力
        $eAr = array();
        $eAr = $this->checkNameAndMail();
        
        //他エラー
        if(! $this->mf->isType('contact') ) {
        	$eAr = array_merge($eAr, $this->checkOtherError());
        }
        
        return $eAr; 
        
        //入力画面の先頭でエラーチェックをして、ページ遷移をさせないので、errorをSESSIONに入れる必要がない
        //エラー数確認 jQueryの場合は不要
//        if (count($error) > 0) {
//            $_SESSION['error'] = $error;
//            //return $error;
//            
//            //header前にechoを入れるとエラーになる echoで出力となるのでエラーになる	
//            //header('HTTP/1.1 303 See Other');
//            //header('Location: ' . $dirname);
//        }
//        else {
//            $_SESSION['error'] = NULL;
//            //return NULL;
//        }
        
        //$errors = isset($_SESSION['error']) ? $_SESSION['error'] : NULL;
        //return $_SESSION['error'];
    }



} //class End





