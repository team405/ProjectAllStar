<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userID = $_GET["userID"]; //浅井追記
}else {
  $userID = $_POST["userID"]; //浅井追記
}
$lines = file("content.csv", FILE_IGNORE_NEW_LINES);

$contents_array = array();
$auth_check = "";
$auth_message = "";

foreach ($lines as $line) {
  $line_array = explode(",", $line);
  $user = $line_array[0];
  if ($user === $userID) {
    $auth_check = "true";
    $auth_message = "";
    $con = array('contentID' => $line_array[1],'contentName' => $line_array[2],'quesSum' =>  $line_array[3]);
    array_push($contents_array, $con);
  }else{
    $auth_check = "false";
    $auth_message = "fuck";
  }
}

$b = json_encode(array('result' => $auth_check, 'resultdesc' => $auth_message, 'contents' => $contents_array));

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
