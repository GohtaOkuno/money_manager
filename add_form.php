<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>収支の登録</title>
</head>
<body>
<?php //現在年月日を取得し、現在時刻をcur_yer,cur_mon,cur_day,cur_hou,cur_minの5つに分けてセット
$cur_yer = date("Y"); 
$cur_mon = date("m");
$cur_day = date("d");
$cur_hou = date("H");
$cur_min = date("i");
?>

<!--年月日の入力フォームを作成-->
<form method="POST" action="add_process.php">
登録日時：<select name="year">
    <option value=""> <?=$cur_yer?> </option>
    <?php foreach(range(1900,$cur_yer) as $year): ?><!--1900年から現在年までのチェックボックスを作成-->
    <option value="<?=$year?>"> <?=$year?> </option>
<?php endforeach; ?>
</select>
年
<select name="month">
    <option value=""> <?=$cur_mon?> </option>
    <?php foreach(range(1,12) as $month): ?>
    <option value="<?=$month?>"> <?=$month?> </option>
<?php endforeach;?> 
</select>
月
<select name="day">
    <option value=""> <?=$cur_day?> </option>
    <?php foreach(range(1,31) as $day): ?>
    <option value="<?=$day?>"> <?=$day?> </option>
<?php endforeach;?>
</select>
日
<select name="hour">
    <option value=""> <?=$cur_hou?> </option>
    <?php foreach(range(01,24) as $hour): ?>
    <option value="<?=$hour?>"> <?=$hour?> </option>
<?php endforeach;?>
</select>
時
<select name="min">
    <option value=""> <?=$cur_min?> </option>
    <?php foreach(range(00,59) as $min): ?>
    <option value="<?=$min?>"> <?=$min?> </option>
<?php endforeach;?>
</select>
分

<br/>

金額：<input type="text" name="money" size="10" maxlength="10"> <br/>
カテゴリ：<select name="category">
            <option value="food">食費</option>
        </select><br/>

支出：<input type="radio" name="exp_inc" value="1"> 
収入：<input type="radio" name="exp_inc" value="2">