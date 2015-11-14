<?php

if($_SERVER["REQUEST_METHOD"] != "POST"){
   $contentID = $_GET["contentID"];
    }else {
   $contentID = $_POST["contentID"];
  }

$result = "false";
$resultDesc="";

// mysqliクラスのオブジェクトを作成
$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
}

$link = mysqli_connect("localhost", "dbsmaq", "ufbn516", "dbsmaq");

$userArray = array();

//ここに処理書くよ
$sql = "SELECT * FROM mobileUser WHERE contentID = '$contentID'";
if($sql_result = mysqli_query($link,$sql)){
    while($row = mysqli_fetch_assoc($sql_result)){
        array_push($userArray,array( "mobileName" => $row['mobileName']));
        $result="true";
}
}else{
    $resultDesc="error";
}
mysqli_free_result($sql_result);
// 結果セットを閉じる
// DB接続を閉じる
mysqli_close($link);

//配列の中に配列作る？
//$userArray += $arraystatus;

$b = json_encode(array("user" => $userArray,'result' => $result, 'resultDesc' => $resultDesc));

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;

?>