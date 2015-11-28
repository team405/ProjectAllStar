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
$result="false";
$resultDesc="";
$b=array();

$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
}

$link = mysqli_connect("localhost", "dbsmaq", "ufbn516", "dbsmaq");

$quesArray = array();
$choices = array();
$corrects = array();
//configの中身{"preKind":"intro","preText":"次の音楽をお聴きください","quesText":"老さんはどれでしょう？","choiceKind":"picture","choiceText":["","","",""],"quesSec":10,"ansText":["ゴリラ","正解","テングザル","パンダ"],"correctNumber":2}

//ここに処理書くよ
$sql = "SELECT * FROM question WHERE adminUid = '$userID' AND contentID = '$contentID' AND quesNum = '$quesID' ";
if($sql_result = mysqli_query($link,$sql)){
    while($row = mysqli_fetch_assoc($sql_result)){
        array_push($choices,$row['ansText1'],$row['ansText2'],$row['ansText3'],$row['ansText4']);
        array_push($corrects,$row['correctText1'],$row['correctText2'],$row['correctText3'],$row['correctText4']);
        $preKind = $row['preKind'];
        $preText = $row['preText'];
        $quesText = $row['quesText'];
        $choiceKind = $row['quesKind'];
        $quesSec = (int)$row['quesSec'];
        $correctNumber = (int)$row['correctNum'];
        $demo = $row['demo'];
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

$b = json_encode(array('preKind' => $preKind,'preText' => $preText,'quesText' => $quesText,'choiceKind'=> $choiceKind,'choiceText'=>$choices,'quesSec'=>$quesSec,'ansText'=>$corrects,'correctNumber'=>$correctNumber,'demo'=>$demo,'result' => $result, 'resultdesc' => $resultDesc,));


header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
