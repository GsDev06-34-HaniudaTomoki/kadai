<?php
//GETでParamを取得
if(isset($_GET["result"])){
  $result = $_GET["result"];
  if($result=="success"){
    $view = "登録が完了しました。";
  }elseif($result=="error1"){
    $view = "既に存在するIDです。";
  }
}else{
  $view = "";
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新規登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="index.php">ログインページに戻る</a></div>
    </div>
    <p><?=$view?></p>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>新規登録</legend>
     <label>名前：<input type="text" name="name"></label><br>
     <label>ID：<input type="text" name="lid"></label><br>
     <label>パスワード：<input type="text" name="lpw"></label><br>
     <input type="submit" value="新規登録">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
