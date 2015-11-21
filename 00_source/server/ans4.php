<?php

function setNewAnswer($userID, $contentID, $quesID, $newAnswer) {
  //正解番号を書き換える
  if(isset($newAnswer)){
    $mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
    if ($mysqli->connect_error) {
      echo $mysqli->connect_error;
      exit();
    } else {
      $mysqli->set_charset("utf8");
    }
    //quesIDが一緒のやつのnewAnswerを反映する
    $sql = "UPDATE question SET correctNum = '$newAnswer' WHERE adminUid = '$userID' AND contentID = '$contentID' AND quesNum = '$quesID'";
    if ( $mysqli->query($sql)) {
      echo "UPDATE成功";
    }else{
      echo "UPDATE失敗";
    }
    // DB接続を閉じる
    $mysqli->close();
  }
}

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


if ($userID !== "" && $contentID !== "" && $quesID !== "" ) {

//回答変更ショートカット対応
if(isset($newAnswer)) setNewAnswer($userID, $contentID, $quesID, $newAnswer);

//ここに処理書くよ
$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
  echo $mysqli->connect_error;
  exit();
} else {
  $mysqli->set_charset("utf8");
}

//startTimeStamp,quesSec,ansNum取得
$sql = "SELECT * FROM question WHERE adminUid = '$userID' AND contentID = $contentID AND quesNum = $quesID";
if ( $sqlresult = $mysqli->query($sql)) {
  while($row = $sqlresult->fetch_array()){
    $startTimeStamp = $row['startTimeStamp'];
    $quesSec = $row['quesSec'];
    $ansNum = $row['correctNum'];
  }
  $sqlresult->free();
}else{
    $resultDesc="error";
}

//quesEndsec
$quesEndsec = $startTimeStamp + $quesSec;

//各選択肢毎の人数。初期値は全部0
$choice = array(0, 0, 0, 0);

//ここに処理書くよ
$sql = "SELECT * FROM ansTime WHERE contentID = '$contentID' AND answeTimeStamp >= '$startTimeStamp' AND answeTimeStamp =< '$quesEndsec' ";
if ( $sqlresult = $mysqli->query($sql)) {
  while($row = $sqlresult->fetch_array()){
    $choice[$row["answerNum"]]++;
  }
        $result=true;
}else{
    $resultDesc="error";
}
$sqlresult->free;
// 結果セットを閉じる
$mysqli->close();

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