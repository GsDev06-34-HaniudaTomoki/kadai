<?php
session_start();
$id = $_POST["lid"];
$pw = $_POST["lpw"];

//1. 接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_user_table WHERE user_id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id);
$res = $stmt->execute();

//SQL実行時にエラーがある場合
if($res==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}

//３．抽出データ数を取得
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
$val = $stmt->fetch(); //1レコードだけ取得する方法

//４. 該当レコードがあればSESSIONに値を代入
if( password_verify($pw, $val["user_pw"])){ 
  //password_hash("パスワード文字", PASSWORD_DEFAULT);でパスワード登録しておくこと
  $_SESSION["chk_ssid"]   = session_id();
  $_SESSION["kanri_flg"]  = $val['kanri_flg'];
  $_SESSION["name"]       = $val['name'];
  //Login処理OKの場合select.phpへ遷移
  header("Location: select.php");
}else{
  //Login処理NGの場合login.phpへ遷移
  header("Location: login_1.php");
}
//処理終了
exit();
?>

