<?php
//1. POSTデータ取得
$name = $_POST["name"];
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];


//2. DB接続します
try {
  //PDO(使用するDB名pgsql:dbname=DB名;文字コード,ホスト名,ユーザー名,pass)
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  //エラー取得
  exit('DbConnectError:'.$e->getMessage());
}

//3.lidが既に存在するか確認する。
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid=:lid");
//SQLインジェクション回避
$stmt->bindValue(':lid', $lid, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();  //sql実行

if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    //既に存在するidの場合
    header("Location: registration.php?result=error1");
    exit;
  }
}

//4．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_user_table(
    id, name, lid, lpw, kanri_flg, life_flg
  )VALUES(
    NULL, :name, :lid, :lpw, 0, 1
    )");//kanri_flg:1=管理者,0=一般 life_flg:1=ログアウト中,0=ログイン中
//SQLインジェクション回避
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();  //sql実行

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: registration.php?result=success");
  exit;
}
?>
