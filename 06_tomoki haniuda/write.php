<?php
$name = $_POST["name"];
$mail = $_POST["mail"];
?>
<head>
<meta charset="utf-8">
<title>File書き込み</title>
</head>
<body>
書き込みを行います。<br>
data.txt に書き込みます。
</body>
<?php
$str = date("Y-m-d H:i:s")."文字列";
$file = fopen("data/data.txt","a");	// ファイル読み込み(a属性は新規作成、既存の場合は追記)
flock($file, LOCK_EX);			// ファイルロック
fwrite($file, $name.",".$mail."\n");
flock($file, LOCK_UN);			// ファイルロック解除
fclose($file);
?>
<ul>
<li><a href="index.php">index.php</a></li>
</ul>
</body>
</html>