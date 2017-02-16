<?php
//1.POSTでParamを取得
$id = $_POST["id"];
$name   = $_POST["name"];
$lid  = $_POST["lid"];
$lpw  = $_POST["lpw"];
$kanri_flg  = $_POST["kanri_flg"];


//2. DB接続します(エラー処理追加)
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE gs_user_table SET name=:name,lid=:lid,lpw=:lpw,kanri_flg=:kanri_flg WHERE id=:id");
$stmt->bindValue(':id', $id);
$stmt->bindValue(':name', $name);
$stmt->bindValue(':lid', $lid);
$stmt->bindValue(':lpw', $lpw);
$stmt->bindValue(':kanri_flg', $kanri_flg);
//SQL実行
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: admin_page.php?result=edit");
  exit;
}

?>
