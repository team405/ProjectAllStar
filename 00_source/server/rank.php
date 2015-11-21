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

  //DBオープン
  $mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
  if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
  } else {
    $mysqli->set_charset("utf8");
  }

  $sql = "
select ans.contentID, ans.mobileUnum, ans.answerNum, min(ans.answerTimeStamp)-ques.startTimeStamp ansTime, user.mobileName 
from    dbsmaq.ansTime ans, dbsmaq.question ques, dbsmaq.mobileUser user
where   ans.answerTimeStamp between ques.startTimeStamp and (ques.startTimeStamp + ques.quesSec)
and     ans.contentId = ques.contentId
and     ques.contentId = $contentID
and     ques.quesNum = $quesID
and     ans.mobileUnum = user.mobileUnum
group by ans.contentID, ans.mobileUnum
having ans.answerNum = (select correctNum from dbsmaq.question where contentID = $contentID and quesNum= $quesID)
order by ansTime
  ";
  if ( $sqlresult = $mysqli->query($sql)) {
    $i=0;
    while($row = $sqlresult->fetch_array()){
      $winner[$i]["userNumber"] = $row[1];
      $winner[$i]["userName"] = $row[4];
      $winner[$i]["ansSec"] = $row[3];
      $i++;
    }
    $sqlresult->free();
  }
  $mysqli->close();

  $result = "true";
  $b = json_encode(array("rank"=> $winner,'result' => $result, 'resultDesc' => $resultDesc));

}else{
  $resultDesc="Error";
  $b = json_encode(array('result' => $result, 'resultDesc' => $resultDesc));
}

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
