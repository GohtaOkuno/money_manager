<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>収支の編集</title>
</head>
<body>

<?php
require_once 'ConnectDb.php';
//現在年月日を取得し、現在時刻をcur_yer,cur_mon,cur_day,cur_hou,cur_minの5つに分けてセット（年以外はそのうち使います）
$cur_yer = date ("Y"); 
$cur_mon = date ("m");
$cur_day = date ("d");
$cur_hou = date ("H");
$cur_min = date ("i");
session_start();
$get_price_id = $_GET['price_id'];
var_dump($get_price_id);

try {
    $db = ConnectDb();

        //price_idの値をSQL文にあてはめる
        $search_getTable = $db->prepare("SELECT date,price,category,method,comment from price INNER JOIN price_meta ON price.ID = price_meta.price_id WHERE price_id = $get_price_id ORDER BY date DESC");
                    
        //SELECT命令を実行
        $search_getTable->execute();
        
        //結果セットの内容を順に出力
        while($row = $search_getTable->fetch(PDO::FETCH_ASSOC)){
            $full_date = $row['date'];
            $price = $row['price'];
            $category = $row['category'];
            $method = $row['method'];
            $comment = $row['comment'];
        }

        var_dump($date);var_dump($price);var_dump($category);var_dump($category);var_dump($method);var_dump($comment);

}catch(PDOException $e) {
    $e->getMessage();
}

?>

<!--年月日の入力フォームを作成-->
<form method="POST" action="add_process.php">
<?$dt_option="";?>

    登録日時：<select name="year"><!--年を生成(1900~現在まで)-->
    <?php   
    for($i = 1900; $i <= $cur_yer; $i++) {
        if($i == $cur_yer) {
             $dt_option .='<option value="'.$i.'"selected>'.$i.'</option>';
        } else {
            $dt_option .='<option value="'.$i.'">'.$i.'</option>';
        }
    }
    echo $dt_option;
    unset($dt_option);
    ?>
    </select>

    年

    <select name="month"><!--月を生成(1~12月)-->
    <?php   
    for($i = 1; $i <= 12; $i++) {
        if($i == $cur_mon) {
            $dt_option .='<option value="'.$i.'"selected>'.$i.'</option>';
        } else {
            $dt_option .='<option value="'.$i.'">'.$i.'</option>';
        }
    }
        echo $dt_option;
        unset($dt_option);
        ?>
    </select>
    月

    <select name="day"><!--日を生成(1~31日)-->
    <?php   
    for($i = 1; $i <= 31; $i++) {
        if($i == $cur_day) {
            $dt_option .='<option value="'.$i.'"selected>'.$i.'</option>';
        } else {
            $dt_option .='<option value="'.$i.'">'.$i.'</option>';
        }
    }
        echo $dt_option;
        unset($dt_option);
        ?>
    </select>

    日

    <select name="hour"><!--時を生成(0~23時)-->
    <?php   
    for($i = 0; $i <= 23; $i++) {
        if($i == $cur_hou) {
            $dt_option .='<option value="'.$i.'"selected>'.$i.'</option>';
        } else {
            $dt_option .='<option value="'.$i.'">'.$i.'</option>';
        }
    }
        echo $dt_option;
        unset($dt_option);
        ?>
    </select>

    時

    <select name="min"><!--分を生成(0~59分)-->
    <?php   
    for($i = 1; $i <= 59; $i++) {
        if($i == $cur_min) {
            $dt_option .='<option value="'.$i.'"selected>'.$i.'</option>';
        } else {
            $dt_option .='<option value="'.$i.'">'.$i.'</option>';
        }
    }
        echo $dt_option;
        unset($dt_option);
        ?>
    </select>

    分

    <br/>

    金額：<input type="text" name="price" size="10" maxlength="10"> <br/>
    カテゴリ：<select name="category">
                <option value="0">食費</option>
                <option value="1">交際費</option>
                <option value="2">ゲーム</option>
                <option value="3">収入</option>
            </select><br/>

    支出：<input type="radio" name="exp_inc" value="1"> 
    収入：<input type="radio" name="exp_inc" value="2"><br/>

    備考：<input type="text" name="remarks" size="10" maxlength="20"><br/>
    <input type="submit" name="登録する">
</form>
</body>
</html>