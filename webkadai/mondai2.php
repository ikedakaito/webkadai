<!DOCTYPE html>
<html lang="ja">
<html>
    <head>
        <meta charset="utf-8">
        <title>数学の問題</title>
        <link rel="stylesheet" href="totonoe.css">
    </head>
    <body>
        <h1>第二問</h1>
        <?php
        $title = '縄文時代の交易で主に取引されていた石を２つ答えなさい';
        $question = array(); 
        $question = array('黒曜石、翡翠','琥珀、翡翠','インフィニティストーン、賢者の石'); 
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