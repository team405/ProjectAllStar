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
$preKind="";
$preText="";
$quesText="";
$choiceKind="";
$choiceText=array();
$quesSec="";
$result="false";
$resultDesc="";

if ($userID !== "" && $contentID !== "" && $quesID !== "" ) {

  $filename = "data/".$userID.'/'.$contentID.'/'.$quesID.'/'.'config.ini'; 
  $fileData = file_get_contents($filename);
  var_dump(json_decode($fileData));
  //stdClass objectを連想配列にキャスト
//  foreach($kouan_kyuuka as $value){
//      $tmp_data[] = (array)$value;
//  }
//  $preKind=$tmp_data[preKind];
//  $preText=$tmp_data[preText]
//  $quesText=$tmp_data[quesText];
//  $choiceKind=$tmp_data[choiceKind];
//  $choiceText=$tmp_data[choiceText];
//  $quesSec=$tmp_data[quesText];  

  $result = "true";

} else{
  $resultDesc="fuck";
}
//$b = json_encode($tmp_data[preKind],$tmp_data[preText],$tmp_data[quesText],$tmp_data[choiceKind],$tmp_data[choiceText],'result' => $auth_check, 'resultdesc' => $auth_message);
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
//echo $b;
?>
