<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userID = $_GET["userID"]; //浅井追記
}else {
  $userID = $_POST["userID"]; //浅井追記
}
$lines = file("content.csv", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $user = explode(",", $line);
        if ($user[0] === $userID) {
          $li0 = "true";
          $li1 = $user[1];
          $li2 = $user[2];
          $li3 = "";
        }else{
          $li0 = "false";
          $li1 = "";
          $li2 = "";
          $li3 = "fuck";
        }
     $b = json_encode(array('result' => $li0, 'contentID' => $li1, 'contentName' => $li2,'resultdesc' => $li3 ));
     }
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
