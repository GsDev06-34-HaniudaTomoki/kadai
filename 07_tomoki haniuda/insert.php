<?php
//1. POSTデータ取得
$book_name = $_POST["book_name"];
$book_url = $_POST["book_url"];
$comment = $_POST["comment"];


//2. DB接続します
try {
  //PDO(使用するDB名pgsql:dbname=DB名;文字コード,ホスト名,ユーザー名,pass)
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  //エラー取得
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(
    id, book_name, book_url, comment, indate
  )VALUES(
    NULL, :book_name, :book_url, :comment, sysdate()
  )");
//SQLインジェクション回避
$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_url', $book_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();  //sql実行

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit;

}
?>
