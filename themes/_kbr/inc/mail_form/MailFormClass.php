<?php 

class MailForm {
	
    protected $dirName;
    public $arInspect, $arNewshop;
    public $adminRow;
    public $currentUrl;
    public $arTitleName;
    public $admin;
    
	public function __construct($typeArg) {
    	//渡されるtypeArgは必ずslugと同名であること
        $this -> type = $typeArg; 
    
    	$this->dirname = $this->getDirName();
        //$dirname = ($dirname == DIRECTORY_SEPARATOR) ? '' : $dirname;
		
        $this->arTitleName = $this->getTitleAndName();
        
        $this -> adminRow = $this-> getAdminRow();
        $this -> admin = $this->setAdminData();
        
        $this->szMail = 'scr.bamboo@gmail.com';

		$this->currentUrl = home_url() . $_SERVER['REQUEST_URI']; //ページのURL action=""で使用
    }


	/* Title and Name ************************************* */
    public function getTitleAndName() {
    	if($this->isType('inspect')) {
        	return array(
                    'nick_name' => 'お名前',
                    'mail_add' => 'メールアドレス',
                    'belong' => '所属・団体名',
                    'postcode' => '郵便番号',
                    'address' => '住所',
                    'tel_num' => 'TEL',
                    'first_date_time' => '第1次希望日／時間',
                    'select_first_y' => '',
                    'select_first_m' => '',
                    'select_first_d' => '',
                    'select_first_t' => '',
                    'second_date_time' => '第2次希望日／時間',
                    'select_second_y' => '',
                    'select_second_m' => '',
                    'select_second_d' => '',
                    'select_second_t' => '',
                    'people_num' => '希望人数',
                    'park_num' => '駐車場ご利用数',
                    'bus' => 'バスの有無',
                    'lunch' => '昼食の有無',
                    'purpose' => '視察の目的について',
                    'comment' => 'その他、要望',
                );
        }
        else if($this->isType('newshop')) {
        	return array(
                    'nick_name' => 'お名前',
                    'mail_add' => 'メールアドレス',
                    'postcode' => '郵便番号',
                    'address' => '住所',
                    'tel_num' => 'TEL',
                    'first_date_time' => '個別相談の希望日／時間',
                    'select_first_y' => '',
                    'select_first_m' => '',
                    'select_first_d' => '',
                    'select_first_t' => '',
                    'trade_name' => '屋号',
                    'work_type' => '業種',
                    'history' => '経歴',
                    'experience' => '事業の経営経験の有無',
                    'concept' => 'コンセプト',
                    'main_service' => '主要な取扱商品・サービス',
                    'sales_point' => 'セールスポイント',
                    'hope_size' => '希望面積',
                    'worker_num' => '予定従業員数',
                    'comment' => 'コメント',
                );
        }
        else {
        	return array(
                    'nick_name' => 'お名前',
                    'mail_add' => 'メールアドレス',
                    'comment' => 'コメント',
                );
        }
    }
    
    //DBのadminデータを配列に入れる
    public function setAdminData() {

        $this->admin = array();
        
        $this->admin['name'] = $this->adminRow->admin_name;
        $this->admin['email'] = $this->adminRow->admin_email;
        $this->admin['foot'] = $this->adminRow->admin_foot;
        
        if($this->isType('inspect')) {
        	$this->admin['subject'] = $this->adminRow->admin_subject_inspect;
            $this->admin['head'] = $this->adminRow->admin_head_inspect;
        }
        else if($this->isType('newshop')) {
        	$this->admin['subject'] = $this->adminRow->admin_subject_newshop;
            $this->admin['head'] = $this->adminRow->admin_head_newshop;
        }
        else {
        	$this->admin['subject'] = $this->adminRow->admin_subject_contact;
            $this->admin['head'] = $this->adminRow->admin_head_contact;
        }
        
        return $this->admin;
    }
    
    //adminRow（管理者設定値）をDBから取得
    public function getAdminRow() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'form_admin';
        $row = $wpdb->get_row("SELECT * FROM $table_name LIMIT 1");
        
        return $row;
    }
    
    //Type判別関数
    public function isType($arg) {
    	return ($this->type == $arg);
    }

    //データチェック
    public function checkInput($var) {
    	
        function checkInput($var) {
        	if(is_array($var)) {
            	return array_map('checkInput', $var);
        	}
            else {
                if (get_magic_quotes_gpc()) {
                    $var = stripslashes($var);
                }
                if (preg_match('/¥0/', $var)) {
                    die('Invalid Input: NOTICE(201) NUL is included');
                }
                if (! mb_check_encoding($var, 'UTF-8')) {
                    die('Invalid Input: NOTICE(202) Encoding Error');
                }
                return $var;
            }
        }
        
        if(is_array($var)) {
            return array_map('checkInput', $var);
        }
    }


    //Ticket確認
    public function checkTicket() {
        if (isset($_POST['sz_ticket']) && isset($_SESSION[$this->type]['sz_ticket'])) {
            $value = $_POST['sz_ticket'];
            
                if ( ! in_array($_POST['sz_ticket'], $_SESSION[$this->type]['sz_ticket'])) {
                    die('Invalid Access: NOTICE(102) Ticket is not match');
                }
        	return $value;  
        }
        else {
            die('Invalid Access: NOTICE(103) Wrong Ticket is published');
        }
    }
    
    //データチェックとTicketチェックの両方
    public function checkInputAndTicket() {
    	$_POST = $this->checkInput($_POST); //入力データの確認
    	$ticket = $this->checkTicket(); //チケット確認
        return $ticket;
    }
    

    //stringHTML return & echo
    public function h_esc($string) {
        return htmlspecialchars($string, ENT_QUOTES);
    }
    public function eh_esc($string) {
        echo htmlspecialchars($string, ENT_QUOTES);
    }

	public function e_($key, $num=1) { //num=0: タイトル出力、num=0:Label出力、num=1:input >name出力
    	if($num) {
        	$str = $this->h_esc($key);
            $str = 'name="' . $str . '" class="' . $str . '"';
        }
        else {
        	$str = $this->arTitleName[$key];
        }
        
        echo $str;
    }

    public function ee_($array, $key, $num) { //num=1 : name/id 出力
        $str = $this->h_esc($array[$key][$num]);

        if($num == 1) {
            $str = 'name="' . $str . '" class="' . $str . '"';
        }

        echo $str;
    }

    public function getDirName() {
        $dir = dirname($_SERVER['SCRIPT_NAME']);
        $dir = str_replace('mail_form', '', $dir);
        $dir = 'http://' . $_SERVER['HTTP_HOST'] . $dir;
        
        return $dir;
    }


    //radioチェックのsessionがある時にcheckedを入れる
    //$argVal:値（あり・なし）$argName:name値（bus） $argFirst:先頭(初期チェックOn)orNot
	public function checkRadioSession($argVal, $argName, $argFirst=0) { 
    	if($argFirst) {
            if(isset($_SESSION[$this->type][$argName])) {
            	if($_SESSION[$this->type][$argName][1] == $argVal) {
                	echo ' checked="checked"';
                }
            }
            else {
            	echo ' checked="checked"';
            }
        }
        else {
        	if(isset($_SESSION[$this->type][$argName]) && $_SESSION[$this->type][$argName][1] == $argVal) {
                echo ' checked="checked"';
            }
        }
        
    }
    
    // checkbox / radio / select のchecked/selected属性を入れる(初期checkが付かない版)
    public function checkValue($name, $value, $or='check') {
        
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
    
    
    //PostデータをSessionに入れる
    public function setDataToSession() {

		$array = $this->arTitleName;

        foreach($array as $key => $val) { //$ar : function.php global val
            $_SESSION[$this->type][$key][0] = $val;
            
            if($key == 'first_date_time') { //first_date_timeは視察・出店者で併用している
            	$this->setAndConnectSelectValue('first', $key);
            }
            
            if($key == 'second_date_time') {
            	$this->setAndConnectSelectValue('second', $key);
            }

            $_SESSION[$this->type][$key][1] = isset($_POST[$key]) ? $_POST[$key] : NULL;
            
        }

    }
    
	/* 希望日時等のSelectBoxを結合してそれ用のSessionに入れる */
    public function setAndConnectSelectValue($arg, $key) {
    	if(isset($_POST['select_'.$arg.'_y']) && isset($_POST['select_'.$arg.'_m']) && isset($_POST['select_'.$arg.'_d']) && isset($_POST['select_'.$arg.'_t'])) {
            $hope_date = $_POST['select_'.$arg.'_y'].'年'
            			.$_POST['select_'.$arg.'_m'].'月'
                        .$_POST['select_'.$arg.'_d'].'日 '
                        .$_POST['select_'.$arg.'_t'].'時';
            
            //$_SESSION[$this->type][$key][1] = $hope_date;
            $_POST[$key] = $hope_date;
        }
    }

    //不要sessionのチェック
    public function checkSessionKey($keyArg) {
        return (
                $keyArg != 'sz_ticket' && 
                $keyArg != 'error' && 
                $keyArg != 'auth' && 
                $keyArg != 'username' &&
                strpos($keyArg, 'select_') === FALSE
            );
    }
    
    //値に単位を付ける
    public function addUnitByKey($key, $inputValue) {
    	if($inputValue != '') {
            if($key == 'people_num' || $key == 'worker_num') {
                $inputValue = $inputValue . ' 人';
            }
            else if ($key == 'park_num') {
                $inputValue = $inputValue . ' 台';
            }
            else if($key == 'hope_size') {
            	if(isDK()) {
                	$inputValue = $inputValue . " m2";
                }
                else {
                	$inputValue = $inputValue . " m<sup>2</sup>";
                }
            }
        }
        return $inputValue;
    }
    
    
    //確認画面内のリスト書き出し用オブジェクトを取得
    public function getObjSendingData() {
    	
        $all_obj = array();
    	
        foreach ($_SESSION[$this->type] as $key => $val) {
                    
            if ($key == 'check' && $_SESSION[$this->type]['check'][1] != '') {
                $check_value = implode("{$turnArg}　　・", $_SESSION['check'][1]);
                $all_obj[$val[0]] = $check_value;
            }
            
            else if ( $this->checkSessionKey($key) ) {
            	$inputValue = $this->h_esc($val[1]); //エスケープする
                $inputValue = $this-> addUnitByKey($key, $inputValue); //必要なら単位を付ける エスケープの前にすると平方メートルのタグがエスケープ文字になる（通常出力）のでエスケープ後にする
                
                //$inputValue = $val[1];
                if(strpos($inputValue, "\n")) { // 改行文字があればnl2br()をして返す
                    $inputValue = nl2br($inputValue);
                }
                
                $all_obj[$val[0]] = $inputValue; //array[お名前]=あいうえお として配列にする
            }
        }
    
    	return $all_obj;
    }


    public function format_func($turnArg) {

            $all_format = array();
            $out_format = "<p><span>■%s</span><br/>{$turnArg}%s</p>";
            $out_format_check = "<p><span>%s</span>{$turnArg}　・%s</p>";
            
           /* if ( ! $_SESSION['check'][0] == '') {
                $check_value = implode("{$value}　　・", $_SESSION['check'][0]);
            }*/
            
            //サイト上で改行して表示させるなら
            //$_SESSION['comment'][0] = str_replace("\n", "<br />", $_SESSION['comment'][0]);
            
            foreach ($_SESSION[$this->type] as $key => $val) {
                
                if ($key == 'check' && $_SESSION[$this->type]['check'][1] != '') {
                    $check_value = implode("{$turnArg}　　・", $_SESSION['check'][1]);
                    $all_format[] = sprintf($out_format_check, $val[0], $check_value);
                }

                else if ( $this->checkSessionKey($key) ) {
                    $inputValue = $this->h_esc($val[1]);
                    
                    if(strpos($inputValue, "\n")) { // 改行文字があればnl2br()をして返す
                        $inputValue = nl2br($inputValue);
                    }
                    
                    $all_format[] = sprintf($out_format, $this->h_esc($val[0]), $inputValue);
                }
            }
            
            return implode("$turnArg", $all_format);
    }

    /* メール送信用フォーマット */
    public function format_mail_func($turnArg) {
        
        $all_format = array();
        $out_format = "■ %s{$turnArg}%s";
        
        //サイト上で改行表示した場合に、改行コードを戻す
        //$_SESSION['comment'][0] = str_replace("<br />", "\n", $_SESSION['comment'][0]);
            
        foreach ($_SESSION[$this->type] as $key => $val) {
            if ( $this->checkSessionKey($key) ) {
                    $val[1] = $this->h_esc($val[1]);
                    $val[1] = $this->addUnitByKey($key, $val[1]); //単位を付ける
                    $all_format[] = sprintf($out_format, $val[0], $val[1]);
                }
        }
        
        return implode("$turnArg"."$turnArg", $all_format);
    }

    /* DBセット用フォーマット */
    public function format_db_func() {
        $db_format = array();
        
        foreach ($_SESSION[$this->type] as $key => $val) {
            if ( $this->checkSessionKey($key) ) {
                $db_format[$key] = $val[1]; //nameと値の組みで配列に入れる
            }
        }
        $db_format['time'] = current_time( 'mysql' );
        
        return $db_format; //array
    }

    /* ユーザー宛メール用フォーマット ************************* */
    public function format_return($arg) {
        
        $adminHead = $this->admin['head']; //EOL内に入れるとエラーになる ObjectからのStringが良くないぽい

//to user mail sentence
$context = <<<EOL
{$arg} 様


$adminHead


□□□□□□□　お問い合わせ内容　□□□□□□□

EOL;
// END to user mail sentence

        $context .= $this->format_mail_func($value="\n");
        $context .= "\n\n\n\n\n";
        $context .= $this->admin['foot'];
        //$context .= "\n\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\t\n\t\n\t\n";
        
        return $context;
    }

    /* Admin用メールフォーマット **************************** */
    public function format_admin() {

        //$adminRow = getAdminRow();
        $title = get_the_title();

//to Admin mail sentence /* ★ */
$context = <<<EOL

サイトより{$title}の応募がありました。
頂きました内容は下記となります。


□□□□□□□　{$title} 内容　□□□□□□□


EOL;
// END to user mail sentence
    
        $context .= $this->format_mail_func($value="\n");
        $context .= "\n\n\n\n\n" . $this->admin['foot'];
        return $context;
    }

    
    /* Set DB */
    function setDataToDB() {
		
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'form_' . $this->type;
        
        $dbRet = $wpdb->insert( //return false or row-number
            $table_name,
            $this->format_db_func() //arrayが返される関数 $wpdbクラスのドキュメントを参照
        );
        
        //DBInsert失敗時でもadminとuserへのメールは送信させ、自分宛にのみメールを送る
        if(! $dbRet) {
        	mb_send_mail(
            	$this->szMail,
                'DB Insertに失敗しました', 
                $this->format_admin(),
                'FROM: '. mb_encode_mimeheader($this->admin['name']) .' <'.$this->szMail.'>',
                '-f' . $this->szMail
            );
        }
    }
    
    
    //Send MailとDBへのinsert
    public function sendMailAndSetDB() {
    	        
        //$_POSTとTicketの確認 エラーがあればdieになる
        $this->checkInputAndTicket();
    
    	$mailTo = $this->admin['email']; //メインアドレス問い合わせの届け先（カンマ区切りで複数指定可）
    	$mainMail = $this->admin['email']; //確認メール内に記載される返信先（ヘッダーアドレス）
    
    	/* 件名 */
        $subject = get_the_title() . 'がありました 〜'. $this->admin['name'] . '〜'; //Master用
        $return_subject = $this->admin['subject']; //User用
        
    	$returnMail = $this->szMail; //Undelivered Mailの送信先 postfix(smtpなし状態)で確認可能

		/* ユーザー名前とメールアドレス */
        $name = $_SESSION[$this->type]['nick_name'][1]; //User name
        $mail_add = $_SESSION[$this->type]['mail_add'][1]; //User mail address
        

        /* エンコード */
        mb_language('ja');
        mb_internal_encoding('UTF-8');

        /* mail header */
        $header = 'FROM: '. mb_encode_mimeheader($name) .' <'.$mail_add.'>'; //toMaster メールヘッダー
        $return_header = 'FROM: '. mb_encode_mimeheader($this->admin['name']).' <'.$mainMail.'>'; //確認メールヘッダー
        
        /* Send mail to master */
        if(isDK()) {
        	$result_master = mb_send_mail( $mailTo, $subject, $this->format_admin(), $header, '-f' . $returnMail );
        }
        else {
            $header .= 'MIME-Version: 1.0'."\r\n"; //qmailの時は改行コードを\n(LF)のみにする mail()関数は使えないがドメインキング->qmailなので注意
        	$header .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
            //Content-Transfer-Encoding: quoted-printable
            
            $return_header .= 'MIME-Version: 1.0'."\r\n";
            $return_header .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";

    		$body = nl2br($this->format_admin())."\r\n";
            
            $result_master = mail( $mailTo, $subject, $body, $header, '-f' . $returnMail );
        }
    
    
    	/* Set DB */
        $this->setDataToDB();
        

        if($result_master){
        	/* Send mail to user */
        	if(isDK()) {
            	$result_user = mb_send_mail( $mail_add, $return_subject, $this->format_return($name), $return_header, '-f'.$returnMail );
            }
            else {
                $result_user = mail( $mail_add, $return_subject, nl2br($this->format_return($name)), $return_header, '-f'.$returnMail );
        	}
            return $result_user ? $result_user : 1051; //to User Sending Error
        }
        else {
        	$result_master = 1050; //to Master Sending Error
        	return $result_master;
        }
    }



    //Session clear
    public function clear($boolAg = TRUE) {
    	if($boolAg) {
        	$_SESSION = array();
        	session_destroy();
        }
        
    //    if($boolAg) {
    //	    setcookie('compAuth', 1, time()+60);
    //        //echo $_SESSION['compAuth'];
    //    
    //    }
    }
    
    
    /* SelectBoxの配置とsession戻り時でのselected付け $objNumにsessionの値を渡す*/
    public function selectBox($first, $last, $objNum=null) {
	
    	//先頭Optionの設定
        if($objNum == null) { //初回表示時
            echo '<option value="--" selected>--</option>';
        }
        else { //sessionがsetされている時にも--のoptionを表示させるため
            $select = ($objNum == '--') ? ' selected' : '';
            echo '<option value="--"' . $select .'>--</option>';
        }
        
        //ジェネレータ利用の場合 domainkingでyieldが使えない
        /*
        $datas = $this->xrange($first, $last); //ジェネレータ
            
        foreach($datas as $data) {
            if(isset($objNum) && $data == $objNum)
                echo '<option value="'.$data .'" selected>'.$data.'</option>';
            else
                echo '<option value="'.$data .'">'.$data.'</option>';
        }
		*/
        
//		ORGコード ------------------        
        if($first > $last) { //逆順の時 Yearにて
            for($first; $first >= $last; $first--) {
                if(isset($objNum) && $first == $objNum)
                    echo '<option value="'.$first .'" selected>'.$first.'</option>';
                else
                    echo '<option value="'.$first .'">'.$first.'</option>';
            }
            
        }
        else { //正順
            for($first; $first <= $last; $first++) {
                if(isset($objNum) && $first == $objNum)
                    echo '<option value="'.$first .'" selected>'.$first.'</option>';
                else
                    echo '<option value="'.$first .'">'.$first.'</option>';
            }
        }
    
    }
    
    //selectBox($first, $last, $objNum=null)で使用するジェネレータ。 *** yield->配列を使用せず値をキープできる
    /*
    private function xrange($start, $end) {
    	if($start > $end) //逆順の時 Yearにて
        	for($i = $start; $i >= $end; $i--) yield $i;
        else //正順
            for($i = $start; $i <= $end; $i++) yield $i;

    }
    */


} //class End





