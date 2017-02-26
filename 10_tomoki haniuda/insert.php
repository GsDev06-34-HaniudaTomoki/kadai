<?php
include("functions.php");
//入力チェック(受信確認処理追加)
if(
  !isset($_POST["title"]) || $_POST["title"]=="" ||
  !isset($_POST["article"]) || $_POST["article"]==""
){
  exit('ParamError');
}

//1. POSTデータ取得
$title   = $_POST["title"];
$article = $_POST["article"];


//1.アップロードが正常に行われたかチェック
//isset();でファイルが送られてきてるかチェック！そしてErrorが発生してないかチェック
if(isset($_FILES['filename']) && $_FILES['filename']['error']==0){
    
    //2. アップロード先とファイル名を作成
    $upload_file = "./upload/".$_FILES["filename"]["name"];
    
    // アップロードしたファイルを指定のパスへ移動
    //move_uploaded_file("一時保存場所","成功後に正しい場所に移動");
    if (move_uploaded_file($_FILES["filename"]['tmp_name'],$upload_file)){
        
        //パーミッションを変更（ファイルの読み込み権限を付けてあげる）チェンジモディファイ
        chmod($upload_file,0644);
        
    }else{
        echo "fileuploadOK...Failed";
        exit;
    }
}else{
    echo "fileupload失敗";
    exit;
}


//2. DB接続します(エラー処理追加)
$pdo = db_con();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_cms_table(id, title, article, upfile,
indate)VALUES(NULL, :a1, :a2, :a3, sysdate())");
$stmt->bindValue(':a1', $title,    PDO::PARAM_STR);
$stmt->bindValue(':a2', $article,  PDO::PARAM_STR);
$stmt->bindValue(':a3', $upload_file,  PDO::PARAM_STR);

$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  queryError($stmt);

}else{
  //５．index.phpへリダイレクト
  header("Location: select.php");
  exit;
}
?>
