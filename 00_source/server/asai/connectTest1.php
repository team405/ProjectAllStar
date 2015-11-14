<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>PHP DBAccess TEST</title>
</head>
<body>

<?php
//DBへの接続
$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");

// 接続状況チェック
// mysqli_connect_errno : 直近の接続コールに関するエラーコードを返却
if(mysqli_connect_errno()){
	// mysqli_connect_error : 直近のエラー内容を文字列で返却
	die('接続失敗です。'.mysqli_connect_error());
}

print('<p>接続に成功しました。</p>');

// mysqli_close : DB切断
$close_flag = mysqli_close($mysqli);

if ($close_flag){
    print('<p>切断に成功しました。</p>');
} else {
	die('切断失敗です。');
}
?>
</body>
</html>
