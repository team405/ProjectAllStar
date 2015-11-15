<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
   $userID = $_GET["userID"];
   $contentID = $_GET["contentID"];
   $quesID = $_GET["quesID"];
   if(isset($_GET["newAnswer"])){
    $newAnswer = $_GET["newAnswer"];
  }
}else {
   $userID = $_POST["userID"];
   $contentID = $_POST["contentID"];
   $quesID = $_POST["quesID"];
   if(isset($_POST["newAnswer"])){
    $newAnswer = $_POST["newAnswer"];
  }
}

//回答変更ショートカット対応
if(isset($newAnswer)){
$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset("utf8");
}
//quesIDが一緒のやつのnewAnswerを反映する
$sql = "UPDATE question SET correctNum = '$newAnswer' WHERE quesNum = '$quesID'";
if ( $mysqli->query($sql)) {
        echo "UPDATE成功";
}
    // 結果セットを閉じる
//処理書き終わったよ
// DB接続を閉じる
$mysqli->close();
}else{
  echo "UPDATE失敗";
}




$choice = array(0, 0, 0, 0);
//各選択肢毎の人数。初期値は全部0

if ($userID !== "" && $contentID !== "" && $quesID !== "" ) {

  $filename = "data/".$userID.'/'.$contentID.'/'.$quesID.'/'.'config.ini';
  $fileData = file_get_contents($filename);
  $decode = json_decode($fileData, true);
  $quesSec = $decode["quesSec"];

  $path = "data/".$userID.'/'.$contentID.'/';

  $getTimeStamp = 0.0;
  $starts = file($path."starttimestamp.csv", FILE_IGNORE_NEW_LINES);
  //タイムスタンプを取得する
  foreach ($starts as $starttimestamp) {
    $start_array = explode(",", $starttimestamp);
    if($start_array[0] === $quesID){
      $getTimeStamp = $start_array[1];
    }
  }
  //回答を集計する
  $answers = file($path."answer.csv", FILE_IGNORE_NEW_LINES);
  foreach ($answers as $userans) {
    $ans_array = explode(",", $userans);
    $a = $ans_array[2] - $getTimeStamp;
    if( 0 <= $a && $a <= $quesSec){
      $ans_num = $ans_array[1];
      $choice[$ans_num] = $choice[$ans_num] + 1 ;
    }
  }
  $resultDesc="";
  $result = "true";
  $calresult=array('ansSum' => $choice, 'result' => $result, 'resultDesc' => $resultDesc);
  $b = json_encode($calresult);
} else{
  $resultDesc="Error";
  $b = json_decode(array('result' => $result, 'resultDesc' => $resultDesc));
}
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>