<?php
require_once 'ConnectDb.php';
$year = $_POST['year'];
$day = $_POST['day'];
$month = $_POST['month'];
$hour = $_POST['hour'];
$min = $_POST['min'];

try{
    $db = ConnectDb();
    if(checkdate($month,$day,$year)){//checkdate関数で年、月、日が妥当かをチェックし、当てはまらない場合には処理を終了

        if($hour > 0 && $hour < 25){//1時以上25時未満の場合のみ処理を続行
        }else{
            exit('存在しない日付です。');
        }
    
        if($min > -1 && $min <60){//0分以上60分未満の場合にのみ処理を続行
        }else{
            exit('存在しない日付です。');
        }

        echo '受け付けました';
    } else {
        exit('存在しない日付です。');
    }

    //priceテーブルへのINSERT命令を準備
    //price_metaテーブルへのINSERT命令を準備

}catch(PDOException $e){
    echo $e->getMessage;
}