<?php
function ConnectDb(){
    $dsn = 'mysql:dbname=money_manager; host=127.0.0.1; charset=utf8';
    $usr = 'root';
    $passwd = '';
    //データベースへの接続を確立
    $db = new PDO($dsn, $usr, $passwd);
    return $db; 
}