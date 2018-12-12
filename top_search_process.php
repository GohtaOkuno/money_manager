<?php
require_once 'ConnectDb.php';
session_start();

var_dump($_POST['send_search']);

//送られてきた検索用データを変数に格納
$category = $_POST['send_search'];

var_dump($category);

try {
    $db = ConnectDb();//DBとの接続を確立

    //SELECT命令を準備
    $search_Db = $db->prepare("SELECT date,price,category,method,comment from price INNER JOIN price_meta ON price.ID =price_meta.price_id WHERE category = $category ORDER BY date DESC");

    //SELECT命令を実行
    $search_Db->execute();

    //取得してきた配列を変数に格納
    while($row = $search_Db->fetchAll(PDO::FETCH_ASSOC)){
      //  $storage_date = $row['date']
        //$storage_price = $row['price']
        //$storage_category =
        //$storage_method =
        //$storage_comment =
    }
    //var_dump($search_result);

    //exit;
    //配列を格納した変数$search_resultをセッション情報でtopページへ送り返す
    $_SESSION['result'] = $search_result;
    header('Location: top.php');
    
}catch(PDOException $e) {
    echo $e->getMessage;
}
?>