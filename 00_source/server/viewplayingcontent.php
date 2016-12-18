<?php

$contents_array = array();
$result = "false";
$resultDesc = "";

$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
}

$link = mysqli_connect("localhost", "dbsmaq", "ufbn516", "dbsmaq");

$contents_array = array();

$now = microtime(true);

//ここに処理書くよ
$sql = "SELECT contentID,contentName FROM content WHERE ($now - playTimeStamp) < 3600 ";
if($sql_result = mysqli_query($link,$sql)){
    while($row = mysqli_fetch_assoc($sql_result)){
        array_push($contents_array,array( "contentID" => $row['contentID'],"contentName" => $row['contentName']));
        $result="true";
}
}else{
    $resultDesc="error";
}
mysqli_free_result($sql_result);
// 結果セットを閉じる
// DB接続を閉じる
mysqli_close($link);



$b = json_encode(array('result' => $result, 'resultdesc' => $resultDesc, 'contents' => $contents_array));

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
