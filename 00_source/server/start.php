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
$path="";
$result="false";
$resultDesc="";

if ($userID !== "" && $contentID !== "" && $quesID !== "" ) {
  $path = "data/".$userID.'/'.$contentID.'/';
  $now = microtime(true);
  $answer = $quesID. "," . $now. PHP_EOL;
  file_put_contents($path."starttimestamp.csv", $answer, FILE_APPEND);
  $result = "true";
} else{
  $resultDesc="fuck";
}
$b = json_encode(array('result' => $result,'resultDesc' => $resultDesc));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
