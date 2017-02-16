<?php
  $id = $_GET["id"];
  $param = $_GET["param"];

  try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
  } catch (PDOException $e) {
    exit('DbConnectError:'.$e->getMessage());
  }

if($param == "edit"){
  $stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id=:id");
  $stmt->bindValue(':id', $id);
  $status = $stmt->execute();

  if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
  }else{
    $res = $stmt->fetch();//1レコードのみ取得
  }
}elseif($param == "delete"){
  $stmt = $pdo->prepare("DELETE FROM gs_user_table WHERE id=:id");
  $stmt->bindValue(':id', $id);
  $status = $stmt->execute();

  if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
  }else{
    //５．index.phpへリダイレクト
    header("Location: admin_page.php?result=delete");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>POSTデータ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_update.php">
  <div class="jumbotron">
   <fieldset>
      <legend>ユーザー情報編集</legend>
      <input type="hidden" name="id" value="<?=$id?>">    
      <label>名前：<input type="text" name="name" value="<?=$res["name"]?>"></label><br>
      <label>ユーザーID：<input type="text" name="lid" value="<?=$res["lid"]?>"></label><br>
      <label>ユーザーPW：<input type="text" name="lpw" value="<?=$res["lpw"]?>"></label><br>
      <label>管理者フラグ：<input type="text" name="kanri_flg" value="<?=$res["kanri_flg"]?>"></label><br>
      <input type="submit" value="編集">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
