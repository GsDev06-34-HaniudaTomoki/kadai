<?php
session_start();
include("functions.php");
ssidCheck();
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>POSTデータ登録</title>
  <script src="./ckeditor/ckeditor.js"></script>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<?php include("menu.php"); ?>
<!-- Head[End] -->

<!-- Main[Start] -->
<!--ファイルも送信できるようにする-->
<form method="post" action="insert.php" enctype="multipart/form-data">
  <div class="jumbotron">
   <fieldset>
    <legend>記事登録</legend>
     <label>Newsタイトル：<input type="text" name="title"></label><br>
     <label>News記事：<br><textArea name="article" id="editor1" rows="10" cols="80">ワードみたいに使ってね  v（＊＾_＾＊）v</textArea></label><br>
     <script>
       CKEDITOR.replace('editor1');//テキストエリアをCKEDITORに置換
     </script>
     <input type="file" name="filename">
     <input type="submit" value="記事登録">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
