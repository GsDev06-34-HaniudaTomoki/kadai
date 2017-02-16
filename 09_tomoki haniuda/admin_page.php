<?php
  session_start();
  if(
  !isset($_SESSION["lid"]) || $_SESSION["lid"]==""||
  !isset($_SESSION["lpw"]) || $_SESSION["lpw"]==""||
  !isset($_SESSION["chk_admin"]) || $_SESSION["chk_admin"]!=1
){
  header("location: index.php");
  exit();
}
//GETでParamを取得
if(isset($_GET["result"])){
  $result = $_GET["result"];
  if($result=="delete"){
    $res_message = "削除しました。";
  }elseif($result=="edit"){
    $res_message = "編集しました。";
  }
}else{
  $res_message = "";
}

//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    //getデータ送信リンク作成
    $view .= '<tr>';
    $view .= '<td>'.$res["id"].'</td>';
    $view .= '<td>'.$res["name"].'</td>';
    $view .= '<td>'.$res["lid"].'</td>';
    $view .= '<td>'.$res["lpw"].'</td>';
    $view .= '<td>'.$res["kanri_flg"].'</td>';
    $view .= '<td>'.$res["life_flg"].'</td>';
    $view .= '<td><a href="user_edit.php?id='.$res["id"].'&param=edit">[編集]</a></td>';
    $view .= '<td><a href="user_edit.php?id='.$res["id"].'&param=delete">[削除]</a></td>';
    $view .= '</tr>';
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザー管理</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
    </div>
    <p><?=$res_message?></p>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
        <table>
          <caption>ユーザー一覧</caption>
          <tr>
            <th>ID</th>
            <th>ユーザー名</th>
            <th>ユーザーID</th>
            <th>ユーザーPW</th>
            <th>管理者フラグ</th>
            <th>ログインフラグ</th>
          </tr>
          <?=$view?>
      </table>
    </div>
  </div>
</div>
<!-- Main[End] -->

</body>
</html>
