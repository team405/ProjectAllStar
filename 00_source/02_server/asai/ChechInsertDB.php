<?php
// mysqliクラスのオブジェクトを作成
$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset("utf8");
}

//ここに処理書くよ
$sql = "INSERT INTO adminUser VALUES ('bbb','bbb','bbb') ";
if ( $mysqli->query($sql)) {
        echo "INSERT成功";
    // 結果セットを閉じる
}
//処理書き終わったよ

// DB接続を閉じる
$mysqli->close();
?>
