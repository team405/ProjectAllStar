<?php
function contents($userID) {
    $lines = file("content.csv", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $user = explode(",", $line);
        if ($user[0] === $userID) {
          $contents = array($user[1],$user[2]);
          return array(true,$contents,"");
        }
    }
    return array(false,"0","0","fuck");
}
if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userID = $_GET["userID"]; //浅井追記
}else {
  $userID = $_POST["userID"]; //浅井追記
}
foreach(contents($userID) as $line2){
  $a = explode(",", $line2);
  $b = json_encode(array('result' => $a[0], 'contentID' => $a[1],'contentName' => $a[2], 'resultdesc' => $a[3]));
}

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
