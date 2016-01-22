<?php
require_once('mail_form-functions.php');

/* ***************************************************** */
session_start();

    c_sendingMail();
   
    echo '<p><a href="' .$_SERVER['HTTP_REFERER'] . '">◁ CUSTOM へ戻る</a>'."\n</p>";




