<?php

/* 
　　回答状況確認サービス
  Get Methodのみ設定
  回答状況をブラウザ上から確認する
　　使用例）　選択肢①～④までのうち、一番回答が集まったものを正解にしたいときに
　　　　　　　　司会者側で回答状況を確認する　など
*/

   $userID = $_GET["userID"];
   $contentID = $_GET["contentID"];
   $quesID = $_GET["quesID"];

if ($userID !== "" && $contentID !== "" && $quesID !== "" ) {

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
    $quesNum = $row['quesNum'];
    $startTimeStamp = $row['startTimeStamp'];
    $quesSec = $row['quesSec'];
    $ansNum = $row['correctNum'];
    $preText = $row['preText'];
    $quesText = $row['quesText'];
  }
  $sqlresult->free();
}else{
    $resultDesc="error";
}
//quesEndsec
$quesEndsec = $startTimeStamp + $quesSec +1;

//各選択肢毎の人数。初期値は全部0
$choice = array(0, 0, 0, 0);

$sql = "SELECT mobileUnum, answerNum, MIN(answerTimeStamp) FROM ansTime WHERE contentID = $contentID AND answerTimeStamp >= $startTimeStamp AND answerTimeStamp <= $quesEndsec group by mobileUnum";
if ( $sqlresult = $mysqli->query($sql)) {
  while($row = $sqlresult->fetch_array()){
    $choice[$row["answerNum"]]++;

  }
  $result=true;
  $sqlresult->free();
}else{
    $resultDesc="error";
}

$maxval = max($choice);

  $result = "true";
  echo '問題番号: '.$quesNum.'<br />'; 
  echo '前説文: '.$preText.'<br />';
  echo '問題文: '.$quesText.'<br />';
  echo '選択肢1: '.$choice[0].'<br />';
  echo '選択肢2: '.$choice[1].'<br />';
  echo '選択肢3: '.$choice[2].'<br />';
  echo '選択肢4: '.$choice[3].'<br />';

for($i=0 ;$i < 4 ;$i++){
  if($maxval = $choice[$i]){
    $output = $i + 1;
    echo '<h2>問題No. '.$quesNum .': 『'.$quesText.'』で、';
    echo '<h2> 最も回答者が多かった選択肢は『 '.$output.' 』です。</h2>';
  }
}
// 結果セットを閉じる
$mysqli->close();

}
?>