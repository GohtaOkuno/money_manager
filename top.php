<?php 
require_once 'ConnectDb.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Money Manager</title>
</head>
<body>
<h1>Money Managerへようこそ！</h1>

フォーム設置予定<br/>

<h3><a href="http://localhost/money_manager/add_form.php"> 収支データの追加はこちら！！！！！</a></h3><br/>

現在の収支状況です<br/>
<table border="1">
    <tr>
        <th>日時</th><th>価格</th><th>カテゴリー</th><th>収支</th><th>備考</th>
    </tr>

<?php
    try {
            //データベースへの接続を確立
            $db = ConnectDb();
            //select命令を実行
            $getTable = $db->prepare('SELECT date,price,category,method,comment from price INNER JOIN price_meta ON price.ID =price_meta.price_id');
            $getTable->execute();
            //結果セットの内容を順に出力
            while($row = $getTable->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr>
                <td><?=($row['date'])?></td>
                <td><?=($row['price'])?></td>
                <td><?=($row['category'])?></td>
                <td><?=($row['method'])?></td>
                <td><?=($row['comment'])?></td><br/>
            </tr>
    <?php
        }
} catch(PDOException $e){
    $e->getMessage;
}
?>
</table>
</body>
</html>