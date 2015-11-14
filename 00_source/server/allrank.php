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
