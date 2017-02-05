<?php
//GETでParamを取得
if(isset($_GET["result"])){
  $result = $_GET["result"];
  if($result=="error0"){
    $view = "IDとパスワードを入力してください。";
  }elseif($result=='error1'){
    $view = "パスワードが一致しません。";
  }elseif($result=='error2'){
    $view = "管理者IDではありません。";
  }
}else{
  $view = "";
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="navbar-header"><h2 style="color:white;">書籍ブックマーク</h1></div>
    <p><?=$view?></p>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="login.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ログイン</legend>
     <label>ID：<input type="text" name="lid" maxlength="64"></label><br>
     <label>パスワード：<input type="password" name="lpw" maxlength="64"></label><br>
     <input type="submit" value="ログイン">
     <input type="checkbox" name="chk_admin" value="1">管理者としてログイン
    </fieldset>
    <input type="button" onclick="location.href='registration.php'"value="新規登録">
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
