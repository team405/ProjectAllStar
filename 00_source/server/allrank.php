<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
   $userID = $_GET["userID"];
   $contentID = $_GET["contentID"];
}else {
   $userID = $_POST["userID"];
   $contentID = $_POST["contentID"];
}
$path="";
$result="false";
$resultDesc="";

if ($userID !== "" && $contentID !== "") {



  //DBオープン
  $mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
  if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
  } else {
    $mysqli->set_charset("utf8");
  }

  $sql = "
select a.mobileName,sum(a.ansTime) AS 'ansSecSum', sum(a.counter) AS 'correctSum'
from dbsmaq.question q,
  (select '1' counter,ans.contentID, ans.mobileUnum, ans.answerNum, ques.quesNum, min(ans.answerTimeStamp)-ques.startTimeStamp ansTime, user.mobileName 
  from    dbsmaq.ansTime ans, dbsmaq.question ques, dbsmaq.mobileUser user
  where   ans.answerTimeStamp between ques.startTimeStamp and (ques.startTimeStamp + ques.quesSec + 1)
  and     ans.contentId = ques.contentId
  and     ques.contentId = $contentID
  and     ans.mobileUnum = user.mobileUnum
  group by ans.contentID, ans.mobileUnum, ques.quesNum
  order by ques.quesNum,ansTime) a
where q.quesNum = a.quesNum and a.answerNum = q.correctNum and a.contentID = q.contentID
group by a.mobileUnum
order by sum(a.counter) DESC, sum(a.ansTime)
  ";
  if ( $sqlresult = $mysqli->query($sql)) {
    $i=0;
    while($row = $sqlresult->fetch_array()){
///      $list[$i]["userNumber"] = 111;
      $list[$i]["userName"] = $row[0];
      $list[$i]["correctSum"] = $row["correctSum"];
      $list[$i]["ansSecSum"] = $row["ansSecSum"];
      $i++;
    }
    $sqlresult->free();
  }
  $mysqli->close();




/*
    $path = "data/".$userID.'/'.$contentID.'/';
    $ans_mem = file("answermembers.csv", FILE_IGNORE_NEW_LINES);
    $mobile_user = file("mobile_user.csv", FILE_IGNORE_NEW_LINES);

    //timestamp.csvからtime_startを取得する
    foreach ($mobile_user as $m_users) {
      $sumSec=0.0;
      $count=0;
      $user_array = explode(",", $m_users);
      foreach($ans_mem as $a_mem){
        $ans_array = explode(",",$a_mem);
        if($user_array[0] == $ans_array[1]){
          $sumSec = $sumSec + $ans_array[3];
          $count++;
        }
      }
      $list[] = array("userNumber" => (int) $user_array[0] , "userName" => $user_array[1], "correctSum" => $count, "ansSecSum" => $sumSec);
    }

    //winner配列の順番を変更する
    foreach($list as $key => $row){
      $correctSum[$key] = $row["correctSum"];
      $ansSecSum[$key] = $row["ansSecSum"];
    }
    array_multisort($correctSum,SORT_DESC,$ansSecSum,SORT_ASC,$list);
*/

    $result = "true";
    $b = json_encode(array("allrank"=> $list,'result' => $result, 'resultDesc' => $resultDesc));
}else{
  $resultDesc="Error";
  $b = json_encode(array('result' => $result, 'resultDesc' => $resultDesc));
}
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
