<?php
/**
 * SZ-Form PlugIn
 * functions and definitions Class for Plugin
 *
 * 
 */

class SzForm {

	public function __construct() {
    	
        $this->pagedCount = 20;
        $this->arPaged = array();
    	$this->slug = $_GET['page'];
    }


    public function createAllTable() {
        $this->createInspectTable();
        $this->createNewshopTable();
        $this->createContactTable();
        $this->createAdminTable();
    }


	//視察募集用テーブル作成
    public function createInspectTable() {
        global $wpdb; //wp-config.phpを読めば$wpdbが使用できる
        /*
            $wpdb->get_results 一般的なSELECT(object or array)
            $wpdb->get_col 列のSELECT
            $wpdb->get_row　１行取得
        */
        
        //$idNum = 1; //wpのユーザーID
        //$userRow = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE ID = $idNum");
        //$user_info = get_userdata($idNum);

        $charset_collate = $wpdb->get_charset_collate();
        //echo DB_NAME; //定数も読める
        
        $table_name = $wpdb->prefix . 'form_inspect';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nick_name VARCHAR(50),
            mail_add VARCHAR(100),
            belong VARCHAR(255),
            postcode VARCHAR(20),
            address VARCHAR(255),
            tel_num VARCHAR(20),
            first_date_time VARCHAR(100),
            second_date_time VARCHAR(100),
            people_num VARCHAR(20),
            park_num VARCHAR(20),
            bus VARCHAR(10),
            lunch VARCHAR(10),
            purpose TEXT,
            comment TEXT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        
        echo $sql ? '視察テーブル成功' : '視察テーブル失敗';

    }

    //出店者募集用テーブル作成
    public function createNewshopTable() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        //echo DB_NAME; //定数も読める
        
        $table_name = $wpdb->prefix . 'form_newshop';

        //郵便番号は本来はCHAR(8)->8桁固定型
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nick_name VARCHAR(50),
            mail_add VARCHAR(100),
            postcode VARCHAR(20),
            address VARCHAR(255),
            tel_num VARCHAR(20),
            first_date_time VARCHAR(100),
            trade_name VARCHAR(255),
            work_type VARCHAR(255),
            history TEXT,
            experience VARCHAR(10),
            concept TEXT,
            main_service TEXT,
            sales_point TEXT,
            hope_size VARCHAR(20),
            worker_num VARCHAR(20),
            comment TEXT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        
        echo $sql ? '出店者テーブル成功' : '出店者テーブル失敗';
    }

    //お問い合わせ用テーブル作成
    public function createContactTable() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        
        $table_name = $wpdb->prefix . 'form_contact';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nick_name VARCHAR(50),
            mail_add VARCHAR(100),
            comment TEXT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        
        echo $sql ? 'コンタクトテーブル成功' : 'コンタクトテーブル失敗';
    }


    //管理者設定用テーブル作成
    public function createAdminTable() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        //echo DB_NAME; //定数も読める
        
        $table_name = $wpdb->prefix . 'form_admin';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            admin_name VARCHAR(100),
            admin_email VARCHAR(255),
            admin_subject_inspect VARCHAR(255),
            admin_subject_newshop VARCHAR(255),
            admin_subject_contact VARCHAR(255),
            admin_head_inspect TEXT,
            admin_head_newshop TEXT,
            admin_head_contact TEXT,
            admin_foot TEXT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        
        echo $sql ? 'Adminテーブル成功' : 'Adminテーブル失敗';
        
        $dbRet = $wpdb->insert( //return false or row-number
            $table_name,
            array(
                'admin_name' => '柏原まちづくりプロジェクト',
                'admin_email' => 'bonjour@frank.fam.cx',
                'admin_subject_inspect' => '件名サンプル　視察',
                'admin_subject_newshop' => '件名サンプル 出店者',
                'admin_subject_contact' => '件名サンプル お問い合わせ',
                'admin_head_inspect' => 'ヘッドサンプル 視察',
                'admin_head_newshop' => 'ヘッドサンプル 出店者',
                'admin_head_contact' => 'ヘッドサンプル お問い合わせ',
                'admin_foot' => 'フッダーサンプル 共通',
                'time' => current_time( 'mysql' ),
            )
        );
        
        echo $dbRet ? 'No'.$dbRet . ' インサート成功' : 'インサート失敗';
    }


    public function updateAdminData() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'form_admin';
        
        //admin_formの先頭行を取得してそのidを取る
        $obj = $wpdb->get_row("SELECT * FROM $table_name LIMIT 1");
        
        //print_r($obj);

        $ret = $wpdb->update(
            $table_name,
            array(
                'admin_name' => $_POST['admin_name'],
                'admin_email' => $_POST['admin_email'],
                'admin_subject_inspect' => $_POST['admin_subject_inspect'],
                'admin_subject_newshop' => $_POST['admin_subject_newshop'],
                'admin_subject_contact' => $_POST['admin_subject_contact'],
                'admin_head_inspect' => $_POST['admin_head_inspect'],
                'admin_head_newshop' => $_POST['admin_head_newshop'],
                'admin_head_contact' => $_POST['admin_head_contact'],
                'admin_foot' => $_POST['admin_foot'],
                'time' => current_time( 'mysql' ),
            ),
            array('id'=>$obj->id)  
        );
        
        return $ret;
        
    }

    public function getAdminData() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'form_admin';
        
        //admin_formの先頭行を取得
        $obj = $wpdb->get_row("SELECT * FROM $table_name LIMIT 1");
        
        return $obj ? $obj : '';
    }
    
    //DBから全てのデータを取得
    public function getAllObject() {
    	global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'form_' . $this->slug;
    	
        $allObjs = $wpdb->get_results("SELECT * FROM $table_name", OBJECT);
        
        //ページネーションの実装をここで DBから取得のデータオブジェクトのトータル個数がpagedCountを超えていればarray_chunkする
        if(count($allObjs) > $this->pagedCount) {
        	$this->arPaged = array_chunk($allObjs, $this->pagedCount);
            
            if(isset($_GET['paged']) && $_GET['paged'] > 1) {
            	return $this->arPaged[$_GET['paged']-1];
            }
            else {
            	return $this->arPaged[0];
            }
        }
        else {
        	return $allObjs;
        }
    }
    
    
    /* ページネーションのリンク書き出し */
    public function setPagenation() {
        
        /*getAllObject()で1ページ内に表示するカウント（pagedCount）を超えていれば$this->arPagedが取得されるので、
        取得されていればページネーションを表示する*/
        if(isset($this->arPaged)) { 
            
            $n = 0;
            $array = array();
            
            $selfFormat = '<li class="current">%d</li>';
            $linkFormat = '<li><a href="'. admin_url('admin.php?page=%1$s&paged=%2$d') .'">%2$d</a></li>';
            
            while($n < count($this->arPaged)) {
            	if(isset($_GET['paged']) && $_GET['paged'] > 1) { //2ページ目以降
                	if($_GET['paged'] == ($n+1))
                		$array[] = sprintf($selfFormat, ($n+1));
                    else 
                    	$array[] = sprintf($linkFormat, $this->slug, ($n+1));
                }
                else { //1ページ目の時
                	if($n == 0) 
                    	$array[] = sprintf($selfFormat, ($n+1));
                    else 
                    	$array[] = sprintf($linkFormat, $this->slug, ($n+1));
                }
                
                $n++;
            }
        	
            echo '<ul>'."\n" . implode("\n", $array) . "\n</ul>\n";
        }
    }
    
    

    public function aaa() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'form_admin';
        $obj = $wpdb->get_row("SELECT * FROM $table_name LIMIT 1");
        print_r($obj);
    }






}
/* Class END ******************************************************************** */









