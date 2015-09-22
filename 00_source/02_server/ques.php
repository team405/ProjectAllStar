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
$preKind="";
$prePath="";
$preTextPath="";
$quesKind="";
$quesPath="";
$quesTextPath="";
$quesSec="";
$result="false";
$resultDesc="";

if ($quesID !== "" && $userID !== "" && $quesID !== "" ) {

  $path = "data/".$userID.'/'.$contentID.'/'.$quesID.'/'; 
  $preTextPath = $path;
  $sprePath = $path;
  $quesTextPath = $path;
  $quesPath = $path;

  $lines = file($path."config.ini", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $info = explode(",", $line);
        $preKind = $info[0];
        $quesKind = $info[1];
        $quesSec = $info[2];
    }
  $result = "true";

} else{
  $resultDesc="fuck";
}
$b = json_encode(array('preKind' => $preKind, 'prePath' => $prePath, 'preTextPath' => $preTextPath, 'quesKind'=>$quesKind, 'quesPath' => $quesPath, 'quesTextPath' => $quesTextPath,'quesSec' => $quesSec,'result' => $result,'resultDesc' => $resultDesc));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
