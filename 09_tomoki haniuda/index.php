<?php
//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view="";
$modal=[];
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //fetch=データ取得（1レコードごと）
  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    //tr,tdで出力するときれいに出力できる
    $view .= '<tr>';
    $view .= '<td>'.$res["id"].'</td>';
    $view .= '<td><p><a id="modal-open" class="button-link">'.$res["book_name"].'</a></p></td>';
    $view .= '</tr>';

    $modal[$res["id"]] = '<tr>';
    $modal[$res["id"]] .= '<td>'.$res["id"].'</td>';
    $modal[$res["id"]] .= '<td>'.$res["book_name"].'</td>';
    $modal[$res["id"]] .= '<td>'.$res["book_url"].'</td>';
    $modal[$res["id"]] .= '<td>'.$res["comment"].'</td>';
    $modal[$res["id"]] .= '<td>'.$res["indate"].'</td>';
    $modal[$res["id"]] .= '</tr>';
  }

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script id="script" src="js/modal.js"></script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>データ一覧</title>
<!--<link href="css/range.css" rel="stylesheet">-->
<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
<link href="css/style.css" rel="stylesheet">
<link href="css/modal.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="login.php">ログイン</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
      <table>
        <caption>ブックマーク書籍</caption>
        <tr>
          <th>id</th>
          <th>書籍名</th>
        </tr>
        <?=$view?>
      </table>
    </div>
</div>
<!-- Main[End] -->
<!-- ここからモーダルウィンドウ -->
<div id="modal-content">
	 <!--モーダルウィンドウのコンテンツ開始 -->
        <table>
        <caption>ブックマーク書籍</caption>
        <tr>
          <th>id</th>
          <th>書籍名</th>
          <th>書籍URL</th>
          <th>コメント</th>
          <th>登録日</th>
        </tr>
        <?=$modal[2]?>
      </table>
	<p><a id="modal-close" class="button-link">閉じる</a></p>
	<!-- モーダルウィンドウのコンテンツ終了 -->
</div>

</body>
</html>
