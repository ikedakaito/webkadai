<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>$_FILESの基本</title>
</head>
<body>
 
 
<section class="form-container">
 
<div class="textarea">
 <h2>画像アップロード</h2>
 <p>$_FILESの中身</p>
 
<!-- （3）formタグで送信したfile情報はここに表示 -->
 <?php
   echo "<pre>";
    var_dump($_FILES);
   echo "</pre>";
 ?>
</div>
 
  <!-- （1）formタグにenctype="multipart/form-data"を記載 -->
  <form action="" method="post" enctype="multipart/form-data">
 
    <!-- （2）input 属性はtype="file" と指定-->
    <input type="file" name="upload_image">
 
    <!-- 送信ボタン -->
    <input type="submit" calss="btn_submit" value="送信">
 
  </form>
</section>
 
 
 
</body>
</html>