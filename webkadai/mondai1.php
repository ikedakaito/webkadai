<!DOCTYPE html>
<html lang="ja">
<html>
    <head>
        <meta charset="utf-8">
        <title>数学の問題</title>
        <link rel="stylesheet" href="totonoe.css">
    </head>
    <body>
        <h1>第一問</h1>
        <?php
        $title = '2022年現在のアメリカの大統領は？';
        $question = array(); 
        $question = array('ジョー・バイデン','ワットソン・ベーカリー','ドナルド・J・トランプ'); 
        $answer = $question[0]; 
        shuffle($question);
        ?>
        <h2><?php echo $title ?></h2>
        <form method="POST" action="kaitou1.php">
            <?php foreach($question as $value){ ?>
                <input type="radio" name="question" value="<?php echo $value; ?>" /> <?php echo $value; ?><br>
                <?php } ?>
                <input type="hidden" name="answer" value="<?php echo $answer ?>">
                <input type="submit" value="回答する">
        </form>
    </body>
</html>