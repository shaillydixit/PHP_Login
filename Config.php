<?php
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','phplogin');

$mysql = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
if($mysql===false){
    die("ERROR:Can't connect with server".$mysql->connect_error);
}
?>