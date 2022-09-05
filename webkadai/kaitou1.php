<!DOCTYPE html>
<html lang="ja">
<html>
  <head>
      <meta charset="utf-8">
      <title>クイズ</title>
      <link rel="stylesheet" href="totonoe.css">
    </head>
    <?php 
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    if($question == $answer){
      $result = "正解！";
    }else{
      $result = "不正解･･･";
    }
    ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>結果</title>
</head>
<body>

<h2>結果</h2>
<?php echo $result ?><br></br>
<a href="mondai2.php">次に進む</a>
<a href="hazime.php">最初に戻る</a>
</body>