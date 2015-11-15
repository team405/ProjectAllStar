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


$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
}

$link = mysqli_connect("localhost", "dbsmaq", "ufbn516", "dbsmaq");

//ここに処理書くよ
//startTimestamp,quessec,correctNum取得
$sql = "SELECT * FROM question WHERE adminUid = '$userID' AND contentID = '$contentID' AND quesNum = '$quesID' ";
if($sql_result = mysqli_query($link,$sql)){
    while($row = mysqli_fetch_assoc($sql_result)){
        $starttimestamp = $row['startTimeStamp'];
        $quessec = $row['quesSec']
        $correctNum = $row['correctNum'];
        //array_push($quesArray,array( "preKind" => $row['preKind'],"preText" => $row['preText'],"quesText" => $row['quesText'],"choiceKind"=> $row['quesKind'],"choice"=>$choices,"quesSec"=>$row['quesSec'],"ansText"=>$corrects,"correctNumber"=>$row['correctNum']));
        $result="true";
}
}else{
    $resultDesc="error";
}
mysqli_free_result($sql_result);
// 結果セットを閉じる
// DB接続を閉じる
mysqli_close($link);

$quesEndsec = $starttimestamp + $quessec;
$choice = array(0, 0, 0, 0);
//各選択肢毎の人数。初期値は全部0

$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
}

$link = mysqli_connect("localhost", "dbsmaq", "ufbn516", "dbsmaq");

//ここに処理書くよ
$sql = "SELECT * FROM ansTime WHERE contentID = '$contentID' AND answeTimeStamp >= '$starttimestamp' AND answeTimeStamp =< '$quesEndsec' ";
if($sql_result = mysqli_query($link,$sql)){
    while($row = mysqli_fetch_assoc($sql_result)){


        $result="true";
}
}else{
    $resultDesc="error";
}
mysqli_free_result($sql_result);
// 結果セットを閉じる
// DB接続を閉じる
mysqli_close($link);

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


//$b = json_encode(array('preKind' => $preKind,'preText' => $preText,'quesText' => $quesText,'choiceKind'=> $choiceKind,'choiceText'=>$choices,'quesSec'=>$quesSec,'ansText'=>$corrects,'correctNumber'=>$correctNumber,'result' => $result, 'resultdesc' => $resultDesc,));


header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>