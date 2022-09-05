<?php
 
//（2）$_FILEに情報があれば（formタグからpost送信されていれば）以下の処理を実行する
if(!empty($_FILES)){
 
//（3）$_FILESからファイル名を取得する
$filename = $_FILES['upload_image']['name'];
 
//（4）$_FILESから保存先を取得して、images_after（ローカルフォルダ）に移す
//move_uploaded_file（第1引数：ファイル名,第2引数：格納後のディレクトリ/ファイル名）
$uploaded_path = 'images_after/'.$filename;
//echo $uploaded_path.'<br>';
 
$result = move_uploaded_file($_FILES['upload_image']['tmp_name'],$uploaded_path);
 
if($result){
  $MSG = 'アップロード成功！ファイル名：'.$filename;
  $img_path = $uploaded_path;
}else{
  $MSG = 'アップロード失敗！エラーコード：'.$_FILES['upload_image']['error'];
}
 
}else{
  $MSG = '画像を選択してください';
}
?>
 
 
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>$_FILESの基本</title>
</head>
<body>
 
<main>
 
<section class="form-container">
 
<!--  メッセージを表示している箇所-->
<p><?php if(!empty($MSG)) echo $MSG;?></p>
 
  <!-- 画像を表示している箇所 -->
  <?php if(!empty($img_path)){;?>
 
   <img src="<?php echo $img_path;?>" alt="">
 
  <?php } ;?>
 
 
  <!-- （1）form タグからpost送信する -->
  <form action="" method="post" enctype="multipart/form-data">
 
    <!-- input 属性はtype="file" と指定-->
    <input type="file" name="upload_image">
 
    <!-- 送信ボタン -->
    <input type="submit" calss="btn_submit" value="送信">
 
  </form>
</section>
 
<section class="img-area">
 
<?php
if(!empty($img_path)){  ?>
<!-- （5）ローカルフォルダに移動した画像を画面に表示する -->
 <img src="echo <?php $img_path;?>" alt="">
<?php
}
?>
</section>
 
</main>
 
 
</body>
</html>