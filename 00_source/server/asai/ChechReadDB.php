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
$sql = "SELECT * FROM adminUser";
if ($result = $mysqli->query($sql)) {
    // 連想配列を取得
    while ($row = $result->fetch_assoc()) {
        echo $row["adminUid"] .",". $row["adminPass"] . "<br>";
    }
    // 結果セットを閉じる
    $result->close();
}
//処理書き終わったよ

// DB接続を閉じる
$mysqli->close();
?>
