<?php
require_once 'ConnectDb.php';
$year = $_POST['year'];
$day = $_POST['day'];
$month = $_POST['month'];
$hour = $_POST['hour'];
$min = $_POST['min'];

if(checkdate($month,$day,$year)){//checkdate関数で年月日が妥当かをチェック

    if($hour > 0 && $hour < 25){//ifで分岐し、1時以上25時かチェック
    }else{//当てはまらない場合にはプログラムを終了}
        exit('存在しない日付です。');
    }

    if($min > -1 && $min <60){//ifで分岐し、0分以上60分未満かチェック
    }else{//当てはまらない場合にはプログラムを終了
        exit('存在しない日付です。');
    }
    
    //日付と時刻の妥当性をチェック後、分割した日時を結合し、変数$comb_timeに代入
    $comb_time = $_POST['year'].$_POST['month'].$_POST['day'].$_POST['hour'].$_POST['min'];

    //結合した日付と時刻をformatメソッドでYYYY-MM-DD-HH-MM-SSの形に整形
    $dt = new DateTime();
    $shape_dt = DateTime::createFromFormat('Y-m-d-H-i-s', $comb_time);
    $shape_dt = $dt->format('Y-m-d-H-i-s');


} else {
    exit('存在しない日付です。');//年月日が妥当でない場合にはプログラムを終了
}

try{
    $db = ConnectDb();

        //priceテーブルへ送信するデータをINSERT命令にセットする
        $setdb_price = $db->prepare('INSERT INTO price(date, price) VALUES(:date, :price)');
        //INSERT命令にdateとpriceの内容をセット
        $setdb_price->bindValue(':date', $shape_dt);
        $setdb_price->bindValue(':price', $_POST['price']);
        //INSERT命令を実行
        $setdb_price->execute();

        //priceテーブルから一番大きい（新しい)id情報を抜き取る(現状上手に抜き取れません（オブジェクト形式になっている？）)
        $price_maxid = $db->query('SELECT id from price order by id desc limit 1');
        $price_maxid->fetchAll(PDO::FETCH_ASSOC);
        
        //price_metaテーブルへ送信するデータをINSERT命令にセットする（できません）
        $setdb_price_meta = $db->prepare('INSERT INTO price_meta(price_id, category, method, comment) VALUES(:price_id, :category, :method, :comment)');
        //INSERT命令にprice_id,category,method,commentの内容をセット
        $setdb_price_meta->bindValue(':price_id', $price_maxid->id);
        $setdb_price_meta->bindValue(':category', $_POST['category']);
        $setdb_price_meta->bindValue('method', $_POST['method']);
        $setdb_price_meta->bindValue('comment', $_POST['comment']);
        //INSERT命令を実行
        $setdb_price_meta->execute();

}catch(PDOException $e){
    echo $e->getMessage;
}