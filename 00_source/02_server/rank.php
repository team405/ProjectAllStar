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

//もらったquesIDのtime(start)を取得
if ($userID !== "" && $contentID !== "" && $quesID !== "" ) {
    $path = "data/".$userID.'/'.$contentID.'/';
    $starts = file($path."starttimestamp.csv", FILE_IGNORE_NEW_LINES);
    foreach ($starts as $starttimestamp) {
      $start_array = explode(",", $starttimestamp);
      if($start_array[0] === $quesID){
          $time_start = $start_array[1];
          $result="true";
      }
      }
    }else{
      $resultDesc="fuck";
      echo "fuck_check";
    }

    //答えがあってるかの確認のために答えを取得
    $filename = "data/".$userID.'/'.$contentID.'/'.$quesID.'/'.'config.ini';
    $fileData = file_get_contents($filename);
    $decode = json_decode($fileData, true);
    $correct = $decode["correctNumber"];
    $quesSec = $decode["quesSec"]

    //取得したtime_startとanswer_timeを比較
    $answers = file($path."answer.csv", FILE_IGNORE_NEW_LINES);
    foreach ($answers as $answer) {
      $answer_array = explode(",", $answer);
      $time_gap = $answer_array[3] - $time_start;
      if($quesSec => $time_gap　&& $answer_array[2] === $correct){
        $winner = array($answer_array[0], ceil($time_a*1000));
      }else{
      $resultDesk = "fuck";
      echo "fuck_answer";
      }
    }

//mobileuserから正解者の名前を取得
    $mobileusers = file("mobile_user.csv", FILE_IGNORE_NEW_LINES);
    foreach ($mobileusers as $mobileuser) {
      $mobileuser_array = explode(",", $mobileuser);
      if($mobileuser_array[0] === $winner[0]){
        $winner_name = $answer_array[2];
      }else{
      $resultDesk = "fuck";
      echo "fuck_mobileuser";
      }
    }

//配列作り
$rank = array($winner_name,);

$b = json_encode(array('result' => $result,'resultDesc' => $resultDesc,'rank' => $rank));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
