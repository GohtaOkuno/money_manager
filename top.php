<?php 
require_once 'ConnectDb.php';
require_once 'user_function.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Money Manager</title>
</head>
<body>
<h1>Money Managerへようこそ！</h1>

<b>収支検索</b><br/>
<form method="POST" action="top_search_process.php">
    検索カテゴリ：<select name="send_search">
                <option value="0">食費</option>
                <option value="1">交際費</option>
                <option value="2">ゲーム</option>
                <option value="3">収入</option>
            </select>
            <input type="submit" value="検索">
</form>



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
            $getTable = $db->prepare('SELECT date,price,category,method,comment from price INNER JOIN price_meta ON price.ID =price_meta.price_id ORDER BY date DESC');
            $getTable->execute();
            //結果セットの内容を順に出力
            while($row = $getTable->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr>
                <td align="center"><?=($row['date'])?></td>
                <td align="center"><?=($row['price'])?>円</td>
                <td align="center"><?=judgecategory(($row['category']))?></td>
                <td align="center"><?=judgemethod(($row['method']))?></td>
                <td align="center"><?=($row['comment'])?></td><br/>
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