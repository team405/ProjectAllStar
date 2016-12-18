<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>SmaQ</title>
</head>
<body>
Smaqへようこそ<br />
<br />
<form action="admin_gala.php" method="get">
username:<input type="text" name="userName" size="14" maxlength="12"> <br />
password:<input type="password" name="pass" size="14" maxlength="12"> <br />
contentid:<input type="text" name="contentid" size="14" maxlength="12"> <br />
<input type="submit">
</form>

<?php
/*
//出力バッファリングを開始
ob_start();
//rank.phpを読み込む
include ("../../server/rank.php");
$contents = ob_get_contents();
//出力バッファリングを終了
ob_end_clean();
//結果を$jsonにいれる
$json = json_decode($contents, true);
//後はその$jsonをつかって良い
$row = $json["rank"];
echo $row[0]["userName"];
*/
?>
</body>
</html>
