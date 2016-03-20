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

//もらったquesIDのtime(start)を取得
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
   select *
   from dbsmaq.question ques 
   where  ques.contentID = '$contentID' and ques.adminUid = '$userID'
   ";

  if ( $sqlresult = $mysqli->query($sql)) {
    $i=0;
    while($row = $sqlresult->fetch_array()){
      $choices = array();
      $corrects = array();
      $eventList[$i]["demo"] = (int)$row['demo'];
      $eventList[$i]["quesID"] = $row['quesNum'];
      $eventList[$i]["preKind"] = $row['preKind'];
      $eventList[$i]["preText"] = $row['preText'];
      $eventList[$i]["quesText"] = $row['quesText'];
      $eventList[$i]["choiceKind"] = $row['quesKind'];
      $eventList[$i]["correctNum"] = (int)$row['correctNum'];
      $eventList[$i]["quesSec"] = (int)$row['quesSec'];
      array_push($choices,$row['ansText1'],$row['ansText2'],$row['ansText3'],$row['ansText4']);
      $eventList[$i]["choiceText"] = $choices;
      array_push($corrects,$row['correctText1'],$row['correctText2'],$row['correctText3'],$row['correctText4']);
      $eventList[$i]["ansText"] = $corrects;
      $i++;
    }
    $sqlresult->free();
  }
  $mysqli->close();

  $result = "true";
  $b = json_encode(array("ques"=> $eventList,'result' => $result, 'resultDesc' => $resultDesc));

}else{
  $resultDesc="Error";
  $b = json_encode(array('result' => $result, 'resultDesc' => $resultDesc));
}

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
