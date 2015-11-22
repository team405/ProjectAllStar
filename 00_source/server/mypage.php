<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userID = $_GET["userID"]; //浅井追記
}else {
  $userID = $_POST["userID"]; //浅井追記
}

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

//ここに処理書くよ
$sql = "SELECT contentID,contentName,quesLinNum FROM content WHERE adminUid = '$userID' ";
if($sql_result = mysqli_query($link,$sql)){
    while($row = mysqli_fetch_assoc($sql_result)){
        array_push($contents_array,array( "contentID" => $row['contentID'],"contentName" => $row['contentName'],"quesSum" => $row['quesLinNum']));
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
