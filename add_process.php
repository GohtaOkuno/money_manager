<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>エラー！</title><!--このページが表示されるのはエラーを吐いた時のみなので、タイトルはこれでよい-->
</head>
<body>
<?php
require_once 'ConnectDb.php';

//POST情報で取得したデータを対応する変数に格納
$year = $_POST['year'];
$day = $_POST['day'];
$month = $_POST['month'];
$hour = $_POST['hour'];
$min = $_POST['min'];

//date関数とmktime関数でPOST情報をDATETIME型で扱える形に整形
$shape_dt = date('Y-m-d H:i:s', mktime($hour, $min, 0, $month, $day, $year));

    if(checkdate($month,$day,$year)){//checkdate関数で年月日が妥当かをチェック

            if($hour >= 0 && $hour <= 23){//ifで分岐し、0時以上23時以下かチェック
            }else{//当てはまらない場合にはプログラムを終了
            ?>
                <a href="http://localhost/money_manager/add_form.php"> 不正な日時が入力されました。こちらのリンクから入力をもう一度入力を行ってください。</a>
            <?=exit;}

            if($min >= 0 && $min <=59){//ifで分岐し、0分以上59分以下かチェック
            }else{//当てはまらない場合にはプログラムを終了
            ?>
            <a href="http://localhost/money_manager/add_form.php"> 不正な日時が入力されました。こちらのリンクから入力をもう一度入力を行ってください。</a>
            <?=exit;}

    } else {//年月日が妥当でない場合にはプログラムを終了
    ?>
    <a href="http://localhost/money_manager/add_form.php"> 不正な日時が入力されました。こちらのリンクから入力をもう一度入力を行ってください。</a>
    <?=exit;}



try{
    $db = ConnectDb();

        //priceテーブルへ送信するデータをINSERT命令にセットする
        $setdb_price = $db->prepare('INSERT INTO price(date, price) VALUES(:date, :price)');

        //INSERT命令にdateとpriceの内容をセット
        $setdb_price->bindValue(':date', $shape_dt);
        $setdb_price->bindValue(':price', $_POST['price']);

        //INSERT命令を実行
        $setdb_price->execute();



            //priceの最大IDを取得し、$max_idに代入
            $price_maxid = $db->query('SELECT id from price order by id desc limit 1');
            $max_id = $max_id = $price_maxid->fetchAll(PDO::FETCH_ASSOC);

            //price_metaテーブルへ送信するデータをINSERT命令にセットする
            $setdb_price_meta = $db->prepare('INSERT INTO price_meta(price_id, category, method, comment) VALUES(:price_id, :category, :method, :comment)');

            //INSERT命令にprice_id,category,method,commentの内容をセット
            $setdb_price_meta->bindValue(':price_id', $max_id[0]['id']);
            $setdb_price_meta->bindValue(':category', $_POST['category']);
            $setdb_price_meta->bindValue(':method', $_POST['exp_inc']);
            $setdb_price_meta->bindValue(':comment', $_POST['remarks']);

            //INSERT命令を実行
            $setdb_price_meta->execute();


            //すべての処理が無事に終了したら収支の登録ページにリダイレクト（仮）
            header('Location: http://localhost/money_manager/top.php');

}catch(PDOException $e){
    echo $e->getMessage;
}
?>
</body>
</html>