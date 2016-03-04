<?php
require_once('mail_form-functions.php');
require_once(ABSPATH . 'wp-config.php'); //'../../../../../wp-config.php'でも可
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/kaibara/functions.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/sue-blog/wp-load.php');


global $wpdb; //wp-config.phpを読めば$wpdbが使用できる
    /*
    	$wpdb->get_results 一般的なSELECT(object or array)
    	$wpdb->get_col 列のSELECT
        $wpdb->get_row　１行取得
    */
    
    //$idNum = 1; //wpのユーザーID
    //$userRow = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE ID = $idNum");
    //$user_info = get_userdata($idNum);

echo "aaa";    
    $charset_collate = $wpdb->get_charset_collate();
    //echo $charset_collate . "<br>";
    //echo DB_NAME . "<br>";
    
    $table_name = $wpdb->prefix . 'form_inspect';

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
        nick_name VARCHAR(100),
        mail_add VARCHAR(100),
        belong VARCHAR(100),
        postcode VARCHAR(20),
        address TEXT,
        tel_num int(12),
        people_num int(10),
        park_num int(10),
        bus VARCHAR(10),
        lunch VARCHAR(10),
        purpose TEXT,
        comment TEXT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
    
    
    
