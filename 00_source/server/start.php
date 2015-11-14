<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
   $userID = $_GET["userID"];
   $contentID = $_GET["contentID"];
   $quesID = $_GET["quesID"];
}else {
   $userID = $_POST["userID"];
   $contentID = $_POST["contentID"];
   $quesID = $_POST["quesID"];
}
$result="false";
$resultDesc="";

if ($userID !== "" && $contentID !== "" && $quesID !== "" ) {
  $now = microtime(true);
//  $answer = $quesID. "," . $now. PHP_EOL;
//  file_put_contents($path."starttimestamp.csv", $answer, FILE_APPEND);

$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset("utf8");
}

//ここに処理書くよ
$sql = "UPDATE question SET startTimeStamp = $now WHERE contentID = $contentID";
if ( $mysqli->query($sql)) {
        echo "INSERT成功";
    // 結果セットを閉じる
}
//処理書き終わったよ

// DB接続を閉じる
$mysqli->close();

  $result = "true";
} else{
  $resultDesc="fuck";
}
$b = json_encode(array('result' => $result,'resultDesc' => $resultDesc));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
