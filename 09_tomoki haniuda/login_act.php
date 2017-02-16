<?php
//session開始
session_start();

//lidとlpwが入力されていない場合ログイン画面に戻る
if(
  !isset($_POST['lid']) || $_POST['lid']==""||
  !isset($_POST['lpw']) || $_POST['lpw']==""
){
  header("location: login.php?result=error0");
  exit();
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
$stmt->bindValue(':lid', $_POST["lid"], PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();  //sql実行

if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  $res = $stmt->fetch();//1レコードのみ取得
  //パスワードが一致するか確認
  if($_POST["lpw"]==$res["lpw"]){
    //管理者の場合管理者フラグが立っていなければエラーにする
    if($_POST["chk_admin"]==1){
      if($res["kanri_flg"]==1){
        //1. POSTデータ取得
        $_SESSION["lid"]=$_POST["lid"];
        $_SESSION["lpw"]=$_POST["lpw"];
        $_SESSION["chk_admin"]=$_POST["chk_admin"];
        header("Location: admin_page.php");
        exit;
      }else{
        header("Location: index.php?result=error2");
        exit;
      }
    }else{
      //1. POSTデータ取得
      $_SESSION["lid"]=$_POST["lid"];
      $_SESSION["lpw"]=$_POST["lpw"];
      $_SESSION["chk_admin"]=$_POST["chk_admin"];
      header("Location: bookmark.php");
      exit;
    }
  }else{
    header("Location: index.php?result=error1");
    exit;
  }
}
?>
