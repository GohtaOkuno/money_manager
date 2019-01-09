<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>収支の登録</title>
</head>
<body>
<?php //現在年月日を取得し、現在時刻をcur_yer,cur_mon,cur_day,cur_hou,cur_minの5つに分けてセット（年以外はそのうち使います）
$current_year = date ("Y"); 
$current_month = date ("m");
$current_day = date ("d");
$current_hour = date ("H");
$current_min = date ("i");
?>

<!--年月日の入力フォームを作成-->
<form method="POST" action="add_process.php">

<!--各データ項目のxxxx_optionを作成し、その中にデータを代入し、echoで出力-->

<span>登録日時：</span><select name="year"><!--年を生成(1900~現在まで)-->
    <?php  
    $year_option = "";
    for($i = 1970; $i <= $current_year; $i++) {
        if($i == $current_year) {
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
        if($i == $current_month) {
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
        if($i == $current_day) {
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
        if($i == $current_hour) {
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
    for($i = 1; $i <= 59; $i++) {
        if($i == $current_min) {
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

<span>金額：</span><input type="text" name="price" size="10" maxlength="10"> <br/>
<span>カテゴリ：</span><select name="category">
                <option value="0">食費</option>
                <option value="1">交際費</option>
                <option value="2">ゲーム</option>
                <option value="3">収入</option>
            </select><br/>

<span>支出/収入</span><input type="radio" name="method" value="1"> 
            <input type="radio" name="method" value="2"><br/>

<span>備考：</span><input type="text" name="comment" size="10" maxlength="20"><br/>
    <input type="submit" name="登録する">
</form>
</body>
</html>