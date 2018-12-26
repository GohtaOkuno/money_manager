<?php 
require_once 'ConnectDb.php';
require_once 'judge_function.php';
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
<form method="GET" action="top.php">
    検索カテゴリ：<select name="search_result">
                <option value="NONE">絞り込みをしない</option><!--『絞り込みをしない』の値を"NONE"とする-->
                <option value="0">食費</option>
                <option value="1">交際費</option>
                <option value="2">ゲーム</option>
                <option value="3">収入</option>
            </select>
            <input type="submit" value="検索">
</form>

<?php 
    if(isset($_GET['search_result'])){//GET情報search_resultがNULLであるかをチェック

        //NULLではない場合には、検索したカテゴリの値を変数search_resultに代入しておく 
        $search_result = $_GET['search_result'];

    } else {

        //NULLだった場合はNONEを代入
        $search_result = 'NONE';
    }
?>

<h3><a href="http://localhost/money_manager/add_form.php"> 収支データの追加はこちら！！！！！</a></h3><br/>

現在の収支状況です<br/>
<table border="1">
    <tr>
        <th>日時</th><th>価格</th><th>カテゴリー</th><th>収支</th><th>備考</th><th>編集</th><th>削除</th>
    </tr>

<?php

    try {
        
        $db = ConnectDb();
        
            if("NONE" === $search_result){//セレクトボックスに'絞り込みをしない'が入力されているかを確認し、入力されていればtrue

            //一覧表を取得
            $getTable = $db->prepare("SELECT date,price,category,method,comment,price_id from price INNER JOIN price_meta ON price.ID = price_meta.price_id ORDER BY date DESC");

            //SELECT命令を実行
            $getTable->execute();

            //結果セットの内容を順に出力
            while($row = $getTable->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form method="GET" action="edit.php">
            <tr>
                <td align="center"><?=($row['date'])?></td>
                <td align="center"><?=($row['price'])?>円</td>
                <td align="center"><?=judge_category(($row['category']))?></td>
                <td align="center"><?=judge_method(($row['method']))?></td>
                <td align="center"><?=($row['comment'])?></td>
                <td><button type="submit" value="<?php echo ($row['price_id']);?>" name="price_id">編集</button></td>
                </form>
                
                <form method="GET" action="top.php">
                <td><button type="submit" value="<?php echo ($row['delete_price_id']);?>" onClick="disp()">削除</td>
                </form>
                <br/>
                
            </tr>
            <?php
            }
            
        } else {//検索用のセレクトボックスに検索用の値が入力されていた場合

            //検索カテゴリの値をSQL文にあてはめる
            $search_getTable = $db->prepare("SELECT date,price,category,method,comment,price_id from price INNER JOIN price_meta ON price.ID =price_meta.price_id WHERE category = $search_result ORDER BY date DESC");
            
            //SELECT命令を実行
            $search_getTable->execute();
            
            //結果セットの内容を順に出力
            while($row = $search_getTable->fetch(PDO::FETCH_ASSOC)){
        ?>
            <form method="GET" action="edit.php">
                <tr>
                    <td align="center"><?=($row['date'])?></td>
                    <td align="center"><?=($row['price'])?>円</td>
                    <td align="center"><?=judge_category(($row['category']))?></td>
                    <td align="center"><?=judge_method(($row['method']))?></td>
                    <td align="center"><?=($row['comment'])?></td>
                    <td><button type="submit" value="<?php echo ($row['price_id']);?>" name="price_id">編集</button></td>
                    </form>
                    
                    <form method="GET" action="top.php">
                    <td><button type="submit" value="<?php echo ($row['delete_price_id']);?>" onClick="disp()">削除</td>
                    </form>
                    <br/>
                </tr>
                </form>
        <?php
        }
        }
} catch(PDOException $e){
    $e->getMessage;
}

?>
</table>
</body>
</html>