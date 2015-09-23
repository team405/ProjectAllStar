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
    $time_start=0.0;
    $time_a = 0.0;

    //config.iniから正解の番号と回答時間を取得する
    $filename = "data/".$userID.'/'.$contentID.'/'.$quesID.'/'.'config.ini';
    $fileData = file_get_contents($filename);
    $decode = json_decode($fileData, true);
    $correct = $decode["correctNumber"];
    $quesSec = $decode["quesSec"];

    //timestamp.csvからtime_startを取得する
    foreach ($starts as $starttimestamp) {
      $start_array = explode(",", $starttimestamp);
      if($start_array[0] === $quesID){
          $time_start = $start_array[1];
      }
    }

    //正解者一覧を作成する winner(userNumber,Sec)
    $answers = file($path."answer.csv", FILE_IGNORE_NEW_LINES);
    foreach ($answers as $answer) {
      $answer_array = explode(",", $answer);
      $time_a = $answer_array[2] - $time_start;
      if($time_a <= $quesSec && $answer_array[1] == $correct){
        $winner[] = array( "userNumber" => (int)$answer_array[0], "ansSec" => $time_a);
      }
    }

    //mobileuserから正解者の名前を取得
    $winner_array = array();
    $mobileusers = file("mobile_user.csv", FILE_IGNORE_NEW_LINES);
    foreach ($mobileusers as $mobileuser) {
      $mobileuser_array = explode(",", $mobileuser);
      for($i =0; $i < count($winner); $i++){
        if($mobileuser_array[1] == $winner[$i]["userNumber"]){
          $tmp_array = array("userName" => $mobileuser_array[1]);
          $winner[$i] = $winner[$i] + $tmp_array;
        }
      }
    }

    //winner配列の順番を変更する
    foreach($winner as $key => $row){
      $ansSec[$key] = $row["ansSec"];
    }
    array_multisort($ansSec,SORT_ASC,$winner);

    for($j=0; $j<count($winner); $j++){
      $line = $quesID.",".$winner[$j]["userNumber"].",".$winner[$j]["userName"].",".$winner[$j]["ansSec"].PHP_EOL;
      file_put_contents("answermembers.csv", $line,FILE_APPEND);
    }
    $b = json_encode(array("rank"=> $winner,'result' => $result, 'resultDesc' => $resultDesc));

}else{
  $resultDesc="fuck";
  $b = json_encode(array('result' => $result, 'resultDesc' => $resultDesc));
}

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
