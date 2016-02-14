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
            $error[] = '『' . $titleName['nick_name'] . '』の文字数は全角20文字以内で入力して下さい。';
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
    
    //日付　過去と形式をチェックする
    private function checkDatePastAndCorrect($date_time, $strArg) {
    	$array = array();
    	
        //setlocale(LC_TIME, 'ja_JP.UTF-8');
        date_default_timezone_set('Asia/Tokyo');
        
        //書式:2016年1月1日 8時をstrtotime用のフォーマットに変換
        $date_time = str_replace(array('年','月'), '/', $date_time);
        $date_time = str_replace('日', '', $date_time);
        $date_time = str_replace('時', ':00:00', $date_time);
        
        //$time = mktime(); 年月各数値からtimestampを取得する
        
        //dateからパースする関数 おかしい書式にはwarningが返されるのでそれを利用
        $dp = date_parse_from_format('Y-m-d H:i:s', $date_time);
        
        if( strtotime($date_time) < time()) {
            $array[] = '『'.$this->mf->arTitleName[$strArg]. '』は過去の日時は指定できません。';
        }
        if($dp['warning_count'] != 0) {
            $array[] = '『'.$this->mf->arTitleName[$strArg]. '』は正しい日時を入力して下さい。';
        }
        
        return $array;
    }
    
    
    //名前とメールアドレス以外のエラー処理
    private function checkOtherError() {
    	$error = array();
        
    	$tel_num = $this->session['tel_num'][1];
        
        $date_key = 'first_date_time';
        ${$date_key} = $this->session[$date_key][1]; //書式:2016年1月1日 8時が入っている
        //$first_date_time = $this->session['first_date_time'][1]; //書式:2016年1月1日 8時が入っている
        
        //TEL番号チェック
        if (trim($tel_num) =='') {
           $error[] = $this->returnRequireEmpty('tel_num'); 
        }
        
        //First Dateチェック
        if(strpos($first_date_time, '--') !== FALSE) {
            $error[] = $this->returnRequireEmpty($date_key);
        }
        else { //過去日付と形式チェック
        	$error = array_merge($error, $this->checkDatePastAndCorrect($first_date_time, $date_key));
        }
        
        if($this->mf->isType('inspect')) { //視察フォーム時のエラーチェック
        	
            //Second Date
            $date_key = 'second_date_time';
        	${$date_key} = $this->session[$date_key][1];
        	//$second_date_time = $this->session['second_date_time'][1];
        	
            if(strpos($second_date_time, '--') !== FALSE) {
            	$error[] = $this->returnRequireEmpty($date_key);
        	}
            else {
            	$error = array_merge($error, $this->checkDatePastAndCorrect($second_date_time, $date_key));
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
    public function checkAllError($checkOrNot) { //$checkOrNot : エラー省略時にfalseを渡す
        //global $ar;
        //$ar = $this->getTitleAndName();
        
//        if($this->type == 'inspect')
//	        $array =  $this->arInspect;
//    	elseif($this->type == 'newshop')
//        	$array = $this->arNewshop;

		//$this->mf->setDataToSession();

        //エラーチェック＆出力
        $eAr = array();
        
        if($checkOrNot) { //$checkOrNot : エラー省略時にfalseを渡す
            $eAr = $this->checkNameAndMail();
            
            //他エラー
            if(! $this->mf->isType('contact') ) { //コンタクト以外
                $eAr = array_merge($eAr, $this->checkOtherError());
            }
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





