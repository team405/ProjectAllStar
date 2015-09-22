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

//answerを並べてる
if ($userID !== "" && $contentID !== "" && $quesID !== "" ) {
  $path = "data/".$userID.'/'.$contentID.'/';

  //もらったquesIDのtimeを取得
    $starts = file($path."starttimestamp.csv", FILE_IGNORE_NEW_LINES);
    foreach ($starts as $starttimestamp) {
      $start_array = explode(",", $starttimestamp);
      if($start_array[0] = $quesID){
          $time = $start_array[1];
          return true;
      }else{
        return false;
      }
    }

//答えがあってるかの確認のためにっ答えを取得
$filename = "data/".$userID.'/'.$contentID.'/'.$quesID.'/'.'config.ini';
$fileData = file_get_contents($filename);
$decode = json_decode($fileData, true);
$answer_b = $decode[???];

    //取得したtimeとanswer_timeを比較
    $answers = file($path."answer.csv", FILE_IGNORE_NEW_LINES);
    foreach ($answers as $answer) {
      $answer_array = explode(",", $answer);
      $time_a = $answer_array[3]-$time;
      if(10 => $time_a　&& $answer_array[2] = $answer_b){
        echo $answer_array[0], ceil($time_a)*1000;
      }else{
        return false;
      }
    }
    //明日治す…
  $result = "true";
} else{
  $resultDesc="fuck";
}



$b = json_encode(array('result' => $result,'resultDesc' => $resultDesc));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
