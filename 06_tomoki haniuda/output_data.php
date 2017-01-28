<?php
    include("funcs.php");
    $name = $_POST["name"];
    $mail = $_POST["mail"];

?>
<html>
<head>
<meta charset="utf-8">
<title>output_data</title>
</head>
<body>
お名前：<?php echo h($name); ?>
Mail：<?php echo h($mail); ?>
<ul>
<li><a href="input_data.php">入力にもどる</a></li>
</ul>
</body>
</html>