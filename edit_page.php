<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>収支の編集</title>
</head>
<body>
<!--ここからメイン-->
<?php
require_once 'connect_db.php';
require_once 'function.php';
session_start();
//現在年月日を取得し、現在時刻をcur_yer,cur_mon,cur_day,cur_hou,cur_minの5つに分けてセット（年以外はそのうち使います）
$current_year = date ("Y"); 
$current_month = date ("m");
$current_day = date ("d");
$current_hour = date ("H");
$current_min = date ("i");
$get_price_id = $_GET['price_id'];

try {
    $db = connect_db();

        //price_idの値をSQL文にあてはめる
        $search_getTable = $db->prepare("SELECT date,price,category,method,comment 
                                        from price 
                                        INNER JOIN price_meta 
                                        ON price.ID = price_meta.price_id 
                                        WHERE price_id = $get_price_id 
                                        ORDER BY date DESC");
                    
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

        list($split_year, $split_month, $split_day, $split_hour, $split_min) = preg_split('/[-: ]/', $full_date);

}catch(PDOException $e) {
    $e->getMessage();
}

?>

<!--年月日の入力フォームを作成-->
<form method="POST" action="edit_process.php">

<!--各データ項目のxxxx_optionを作成し、その中にデータを代入し、echoで出力-->

<span>登録日時：</span><select name="year"><!--年を生成(1900~現在まで)-->
    <?php   
    $year_option = "";
    for($i = 1970; $i <= $current_year; $i++) {
        if($i == $split_year) {
             $year_option .='<option value="'.$i.'"selected>'.$i.'</option>';
        } else {
            $year_option .='<option value="'.$i.'">'.$i.'</option>';
        }
    }
    echo $year_option;
    ?>
    </select>

<span>年</span>

    <select name="month"><!--月を生成(1~12月)-->
    <?php 
    $month_option = "";
    for($i = 1; $i <= 12; $i++) {
        if($i == $split_month) {
            $month_option .='<option value="'.$i.'"selected>'.$i.'</option>';
        } else {
            $month_option .='<option value="'.$i.'">'.$i.'</option>';
        }
    }
        echo $month_option;
        ?>
    </select>
<span>月</span>

    <select name="day"><!--日を生成(1~31日)-->
    <?php   
    $day_option = "";
    for($i = 1; $i <= 31; $i++) {
        if($i == $split_day) {
            $day_option .='<option value="'.$i.'"selected>'.$i.'</option>';
        } else {
            $day_option .='<option value="'.$i.'">'.$i.'</option>';
        }
    }
        echo $day_option;
        ?>
    </select>

<span>日</span>

    <select name="hour"><!--時を生成(0~23時)-->
    <?php 
    $hour_option = "";  
    for($i = 0; $i <= 23; $i++) {
        if($i == $split_hour) {
            $hour_option .='<option value="'.$i.'"selected>'.$i.'</option>';
        } else {
            $hour_option .='<option value="'.$i.'">'.$i.'</option>';
        }
    }
        echo $hour_option;
        ?>
    </select>

<span>時</span>

    <select name="min"><!--分を生成(0~59分)-->
    <?php   
    $min_option = "";
    for($i = 0; $i <= 59; $i++) {
        if($i == $split_min) {
            $min_option .='<option value="'.$i.'"selected>'.$i.'</option>';
        } else {
            $min_option .='<option value="'.$i.'">'.$i.'</option>';
        }
    }
        echo $min_option;
        ?>
    </select>

<span>分</span>

    <br/>

<span>金額：</span><input type="text" value="<?=$price ?>" name="price" size="10" maxlength="10"> <br/>

<span>カテゴリ：</span><select name="category">
<?php
$category_option = "";
    for($i = 0; $i <= 3; $i++){
        if($i == $category){
            $category_option .='<option value="'.$i.'"selected>'. get_category($i).'</option>';
        } else {
            $category_option .='<option value="'.$i.'">'. get_category($i).'</option>';
        }
    }
    echo $category_option;
?>
    </select>
    </br>

<span>支出/収入</span>
<?php
$method_option = "";
for($i = 1; $i <= 2; $i++) {
        if($i == $method) {
        $method_option .='<input type="radio" name="method" checked="checked" value="'.$i.'">';
        } else {
            $method_option .='<input type="radio" name="method" value="'.$i.'">';
        }
}
echo $method_option;

?><br/>
<span>備考：</span><input type="text" value="<?=$comment?>" name="comment" size="10" maxlength="20"><br/>
    <input type="submit" name="登録する">

<?='<input type="hidden" name="price_id" value="'.$get_price_id.'">' ?>
</form>
</body>
</html>