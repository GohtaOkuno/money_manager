<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>エラー！</title><!--このページが表示されるのはエラーを吐いた時のみなので、タイトルはこれでよい-->
</head>
<body>
<?php
require_once 'connect_db.php';

//POST情報で取得したデータを対応する変数に格納
$year = $_POST['year'];
$day = $_POST['day'];
$month = $_POST['month'];
$hour = $_POST['hour'];
$min = $_POST['min'];
$price = $_POST['price'];
$price_id = $_POST['price_id'];
$comment = $_POST['comment'];
$method = $_POST['method'];
$category = $_POST['category'];

//date関数とmktime関数でPOST情報をDATETIME型で扱える形に整形
$shape_dt = date('Y-m-d H:i:s', mktime($hour, $min, 0, $month, $day, $year));

    if(checkdate($month,$day,$year)){//checkdate関数で年月日が妥当かをチェックし、妥当でない場合はtop.phpへ遷移

            if($hour >= 0 && $hour <= 23){//ifで分岐し、0時以上23時以下かチェック
            }else{//当てはまらない場合にはプログラムを終了
            ?>
                <a href="http://localhost/money_manager/top.php"> 不正な日時が入力されました。こちらのリンクから入力をもう一度入力を行ってください。</a>
            <?=exit;}

            if($min >= 0 && $min <=59){//ifで分岐し、0分以上59分以下かチェックし、妥当でない場合はtop.phpへ遷移
            }else{//当てはまらない場合にはプログラムを終了
            ?>
            <a href="http://localhost/money_manager/top.php"> 不正な日時が入力されました。こちらのリンクから入力をもう一度入力を行ってください。</a>
            <?=exit;}

    } else {//年月日が妥当でない場合にはプログラムを終了し、妥当でない場合はtop.phpへ遷移
    ?>
    <a href="http://localhost/money_manager/top.php"> 不正な日時が入力されました。こちらのリンクから入力をもう一度入力を行ってください。</a>
    <?=exit;}

try{
    $db = connect_db();

        //priceテーブルへ送信するデータをUPDATE命令にセットする
        $setdb_price = $db->prepare('UPDATE money_manager.price 
                                    SET date = "'.$shape_dt.'", price = '.$price.' 
                                    WHERE id = '.$price_id.'');
        //UPDATE文を実行
        $setdb_price->execute();

        //price_idの値が$price_maxidと一致する項目のみにUPDATE命令を実行
        $setdb_price_meta = $db->prepare('UPDATE money_manager.price_meta 
                                        SET category = '.$category.', method = '.$method.', comment = "'.$comment.'" 
                                        WHERE price_id = '.$price_id.'');
        //UPDATE文を実行
        $setdb_price_meta->execute();

            //すべての処理が無事に終了したらトップページにリダイレクト
            header('Location: http://localhost/money_manager/index.php');

}catch(PDOException $e){
    echo $e->getMessage;
}
?>
</body>
</html>