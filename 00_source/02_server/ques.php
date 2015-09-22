<?php
function ques($quesID) {
  //ゆくゆくはユーザID、イベントID？を渡してファイルパスを指定すること。
    $lines = file("data/aaa/0/$quesID/config.ini", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $rule = explode(",", $line);
        $Path = "data/aaa/0/$quesID/0";
        
        return array(true,$rule[0],$rule[1],$rule[2],$rule[3],$rule[4],"");
        }

if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userID = $_GET["userID"]; //浅井追記
}else {
  $userID = $_POST["userID"]; //浅井追記
}

foreach(contents($userID) as $line2){
  $a = explode(",", $line2);
  $b = json_encode(array('result' => $a[0], 'contentID' => $a[1],'contentName' => $a[2], 'resultDesc' => $a[3]));
}

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
