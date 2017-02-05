<?php
//1. POSTデータ取得
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];
$chk_admin = $_POST["chk_admin"];

if(($lid == "")||($lpw == "")){
    header("Location: index.php?result=error0");
    exit;
}

//2. DB接続します
try {
  //PDO(使用するDB名pgsql:dbname=DB名;文字コード,ホスト名,ユーザー名,pass)
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  //エラー取得
  exit('DbConnectError:'.$e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid=:lid");
//SQLインジェクション回避
$stmt->bindValue(':lid', $lid, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();  //sql実行

if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  $res = $stmt->fetch();//1レコードのみ取得
  //パスワードが一致するか確認
  if($lpw==$res["lpw"]){
    //管理者の場合管理者フラグが立っていなければエラーにする
    if($chk_admin==1){
      if($res["kanri_flg"]==1){
        header("Location: admin_page.php");
        exit;
      }else{
        header("Location: index.php?result=error2");
        exit;
      }
    }else{
      header("Location: select.php");
      exit;
    }
  }else{
    header("Location: index.php?result=error1");
    exit;
  }
}
?>
