<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>SmaQ</title>
</head>
<body>



<?php

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

?>



</body>
</html>
